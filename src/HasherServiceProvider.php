<?php


namespace ClumsyPixel\Hasher;


use Illuminate\Support\ServiceProvider;


class HasherServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__.'/../config/hasher.php';

        if (function_exists('config_path')) {
            $this->publishes([
                $configPath => config_path('hasher.php'),
            ]);
        }

        if (function_exists('database_path')) {
            $this->publishes([
                __DIR__.'/../database/migrations/' => database_path('migrations')
            ], 'migrations');
        }

        $this->mergeConfigFrom($configPath, 'hasher');
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('hash', function ($app) {
            $hasher = $app->config->get('hasher.intermediate_hasher');

            return new WrappedHasher(
                new $hasher(
                    ['rounds' => $app->config->get('hasher.options.rounds', 10)]
                ),
                $this->app->make('encrypter'),
                ['algo' => $app->config->get('hasher.algo', 'sha512')]
            );
        });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['hash'];
    }
}