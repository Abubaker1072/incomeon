<!doctype html>
<?php if(\App\Models\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1): ?>
    <html dir="rtl" lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<?php else: ?>
    <html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<?php endif; ?>

<head>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="app-url" content="<?php echo e(getBaseURL()); ?>">
    <meta name="file-base-url" content="<?php echo e(getFileBaseURL()); ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?php echo e(uploaded_asset(get_setting('site_icon'))); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(uploaded_asset(get_setting('site_icon'))); ?>">
    <title><?php echo e(translate('Admin')); ?> | <?php echo e(get_setting('site_name')); ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <?php if(\App\Models\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1): ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-v4-rtl@4.6.2-1/dist/css/bootstrap-rtl.min.css">
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo e(static_asset('assets/modules/admin/css/admin.css')); ?>?v=5.0.0">

    <script>
        (function () {
            try {
                if (localStorage.getItem('adm-theme') === 'dark') {
                    document.documentElement.classList.add('adm-dark');
                }
            } catch (e) {}
        })();
    </script>

    <style>
        :root {
            --blue: #2557aa;
            --hov-blue: #1a3f7a;
            --soft-blue: #eef3fa;
            --primary: #2557aa;
            --hov-primary: #1a3f7a;
            --soft-primary: #eef3fa;
            --secondary: #a1a5b3;
            --soft-secondary: rgba(143, 151, 171, 0.15);
            --success: #19c553;
            --hov-success: #16a846;
            --soft-success: #e6fff3;
            --info: #00b4d8;
            --hov-info: #0096b8;
            --soft-info: #e6f9fd;
            --warning: #ffc700;
            --soft-warning: #fff9e3;
            --danger: #F0416C;
            --soft-danger: #fff4f8;
            --dark: #232734;
            --soft-dark: #1b2133;
            --secondary-base: #00b4d8;
            --hov-secondary-base: #0096b8;
            --soft-secondary-base: rgba(0, 180, 216, 0.15);
        }
        body { font-size: 13px; font-family: 'Public Sans', sans-serif; }
        .border-gray { border-color: #e4e5eb !important; }
        .card, .dashboard-box {
            border-radius: 10px;
            background: #fff;
            border: 1px solid #eef0f4;
            box-shadow: 0 6px 14px rgba(35, 39, 52, 0.04);
        }
        .form-control { border: 1px solid #e4e5eb; }
    </style>
    <script>
        var AIZ = AIZ || {};
        AIZ.local = {
            nothing_selected: '<?php echo translate('Nothing selected', null, true); ?>',
            nothing_found: '<?php echo translate('Nothing found', null, true); ?>',
            choose_file: '<?php echo e(translate('Choose file')); ?>',
            file_selected: '<?php echo e(translate('File selected')); ?>',
            files_selected: '<?php echo e(translate('Files selected')); ?>',
            add_more_files: '<?php echo e(translate('Add more files')); ?>',
            adding_more_files: '<?php echo e(translate('Adding more files')); ?>',
            drop_files_here_paste_or: '<?php echo e(translate('Drop files here, paste or')); ?>',
            browse: '<?php echo e(translate('Browse')); ?>',
            upload_complete: '<?php echo e(translate('Upload complete')); ?>',
            upload_paused: '<?php echo e(translate('Upload paused')); ?>',
            resume_upload: '<?php echo e(translate('Resume upload')); ?>',
            pause_upload: '<?php echo e(translate('Pause upload')); ?>',
            retry_upload: '<?php echo e(translate('Retry upload')); ?>',
            cancel_upload: '<?php echo e(translate('Cancel upload')); ?>',
            uploading: '<?php echo e(translate('Uploading')); ?>',
            processing: '<?php echo e(translate('Processing')); ?>',
            complete: '<?php echo e(translate('Complete')); ?>',
            file: '<?php echo e(translate('File')); ?>',
            files: '<?php echo e(translate('Files')); ?>',
        }
    </script>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body class="adm-module">

    <template id="adm-theme-toggle-tpl">
        <?php echo $__env->make('modules.admin.compat.backend.inc.admin_nav_toggle', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </template>

    <div class="aiz-main-wrapper">
        <?php echo $__env->make('backend.inc.admin_sidenav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="aiz-content-wrapper bg-white">
            <?php echo $__env->make('backend.inc.admin_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="aiz-main-content">
                <div class="px-15px px-lg-25px">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
                <div class="bg-white text-center py-3 px-15px px-lg-25px mt-auto border-top adm-footer">
                    <p class="mb-0 text-secondary">&copy; <?php echo e(get_setting('site_name')); ?> &middot; <?php echo e(translate('Admin Control Panel')); ?> v<?php echo e(get_setting('current_version')); ?></p>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->yieldContent('modal'); ?>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo e(static_asset('assets/modules/admin/js/admin.js')); ?>?v=5.0.0"></script>
    <?php echo $__env->yieldContent('script'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>

    <script type="text/javascript">
        <?php $__currentLoopData = session('flash_notification', collect())->toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            AIZ.plugins.notify('<?php echo e($message['level']); ?>', '<?php echo e($message['message']); ?>');
            <?php if($message['message'] == translate('Product has been inserted successfully')): ?>
                var data_type = ['digital', 'physical', 'auction', 'wholesale'];
                data_type.forEach(element => {
                    localStorage.setItem('tempdataproduct_'+element, '{}');
                    localStorage.setItem('tempload_'+element, 'no');
                });
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        $('.dropdown-menu a[data-toggle="tab"]').click(function(e) {
            e.stopPropagation();
            $(this).tab('show');
        });

        if ($('#lang-change').length > 0) {
            $('#lang-change .dropdown-menu a').each(function() {
                $(this).on('click', function(e) {
                    e.preventDefault();
                    $.post('<?php echo e(route('language.change')); ?>', {
                        _token: '<?php echo e(csrf_token()); ?>',
                        locale: $(this).data('flag')
                    }, function() { location.reload(); });
                });
            });
        }

        function menuSearch() {
            var filter = $("#menu-search").val().toUpperCase();
            var items = $("#main-menu").find("a").filter(function(i, item) {
                var textEl = $(item).find(".aiz-side-nav-text")[0];
                return textEl && textEl.innerText.toUpperCase().indexOf(filter) > -1 && $(item).attr('href') !== '#';
            });

            if (filter !== '') {
                $("#main-menu").addClass('d-none');
                $("#search-menu").html('');
                if (items.length > 0) {
                    items.each(function() {
                        var text = $(this).find(".aiz-side-nav-text")[0].innerText;
                        var link = $(this).attr('href');
                        $("#search-menu").append(
                            '<li class="aiz-side-nav-item"><a href="' + link + '" class="aiz-side-nav-link"><i class="las la-ellipsis-h aiz-side-nav-icon"></i><span>' + text + '</span></a></li>'
                        );
                    });
                } else {
                    $("#search-menu").html('<li class="aiz-side-nav-item"><span class="text-center text-muted d-block py-3"><?php echo e(translate('Nothing Found')); ?></span></li>');
                }
            } else {
                $("#main-menu").removeClass('d-none');
                $("#search-menu").html('');
            }
        }
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\Incomeon_ecomm\resources\views\modules\admin\compat/backend/layouts/app.blade.php ENDPATH**/ ?>