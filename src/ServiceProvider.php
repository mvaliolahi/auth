<?php

namespace Mvaliolahi\Auth;

use Illuminate\Support\ServiceProvider as SupportServiceProvider;

/**
 * Package Service Provider.
 */
class ServiceProvider extends SupportServiceProvider
{
    /**
     * Alias For access package elements inside Laravel Application.
     *
     * @var string
     */
    protected $packageAlias = 'auth';

    /**
     * Register Services to Service Container
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Boot
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
        $this->loadTranslationsFrom(__DIR__ . '/Resources/lang', $this->packageAlias);
        $this->loadViewsFrom(__DIR__ . '/Resources/views', $this->packageAlias);
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
        $this->loadFactoriesFrom(__DIR__ . '/Database/factories');
        $this->mergeConfigFrom(__DIR__ . '/Config/mvaliolahi_auth.php', $this->packageAlias);

        $this->publishes([
            __DIR__ . '/Config/mvaliolahi_auth.php' => config_path('mvaliolahi_auth.php'),
            __DIR__ . '/Resources/lang' => resource_path("lang/mvaliolahi/{$this->packageAlias}"),
            __DIR__ . '/Resources/views' => resource_path("views/vendor/mvaliolahi/{$this->packageAlias}"),
        ]);

        $this->publishes([
            __DIR__ . '/Resources/assets' => public_path("vendor/mvaliolahi/{$this->packageAlias}"),
        ], 'public');
    }
}
