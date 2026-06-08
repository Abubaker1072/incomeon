<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
      Schema::defaultStringLength(191);
      Paginator::useBootstrap();
      View::getFinder()->prependLocation(resource_path('views/modules/seller/compat'));
      View::getFinder()->prependLocation(resource_path('views/modules/admin/compat'));
      View::getFinder()->prependLocation(resource_path('views/modules/delivery/compat'));

      if ($this->app->environment('local') && request()->isSecure()) {
          URL::forceScheme('https');
      }
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->singleton('core-component-repository', function () {
      return new \App\Support\LocalCoreComponentRepository();
    });
  }
}
