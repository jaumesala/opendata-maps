<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register blade directives
        $this->bladeDirectives();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
        }
    }

    /**
     * Register the blade directives
     *
     * @return void
     */
    private function bladeDirectives()
    {
        // Call to Auth::user()->hasRole
        Blade::directive('role', function($expression) {
            return "<?php if (Auth::user()->hasRole{$expression}) : ?>";
        });
        Blade::directive('endrole', function($expression) {
            return "<?php endif; // Auth::user()->hasRole ?>";
        });
        // Call to Auth::user()->can
        Blade::directive('permission', function($expression) {
            return "<?php if (Auth::user()->can{$expression}) : ?>";
        });
        Blade::directive('endpermission', function($expression) {
            return "<?php endif; // Auth::user()->can ?>";
        });
    }
}
