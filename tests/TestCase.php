<?php

namespace Tests;

use Mvaliolahi\Auth\ServiceProvider;
use Orchestra\Testbench\TestCase as TestBenchCase;

class TestCase extends TestBenchCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp():void
    {
        parent::setUp();

        $this->app->setLocale('fa');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
        $this->withFactories(__DIR__ . '/../Database/Factories');
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('translatable.locales', ['en']);
    }


    private function migrateTables()
    {
        $this->artisan('migrate', [
            '--database' => 'testing',
            '--realpath' => realpath(__DIR__ . '/../Database/migrations'),
        ]);

        $this->artisan('vendor:publish');
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class
        ];
    }
}
