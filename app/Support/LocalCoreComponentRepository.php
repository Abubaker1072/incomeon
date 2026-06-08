<?php

namespace App\Support;

use MehediIitdu\CoreComponentRepository\CoreComponentRepository as BaseCoreComponentRepository;

class LocalCoreComponentRepository extends BaseCoreComponentRepository
{
    protected static function shouldSkipLicenseCheck(): bool
    {
        return app()->environment('local')
            || filter_var(env('SKIP_LICENSE_CHECK', false), FILTER_VALIDATE_BOOLEAN)
            || env('DEMO_MODE') === 'On';
    }

    public static function instantiateShopRepository(): void
    {
        if (static::shouldSkipLicenseCheck()) {
            return;
        }

        parent::instantiateShopRepository();
    }

    public static function initializeCache(): void
    {
        if (static::shouldSkipLicenseCheck()) {
            return;
        }

        parent::initializeCache();
    }
}
