<?php

namespace App\Providers;

use Github\Client;
use GrahamCampbell\GitHub\GithubFactory;
use GrahamCampbell\GitHub\GithubManager;
use GrahamCampbell\GitHub\Authenticators\AuthenticatorFactory;
use Illuminate\Contracts\Container\Container;
use Roots\Acorn\Application;
use Roots\Acorn\ServiceProvider;

/**
 * This is the github service provider class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class GitHubServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAuthFactory();
        $this->registerGitHubFactory();
        $this->registerManager();
        $this->registerBindings();
    }

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath($raw = __DIR__ . './../../config/github.php') ?: $raw;

        $this->mergeConfigFrom($source, 'github');
    }

    /**
     * Register the auth factory class.
     *
     * @return void
     */
    protected function registerAuthFactory()
    {
        $this->app->singleton('github.authfactory', function () {
            return new AuthenticatorFactory();
        });

        $this->app->alias('github.authfactory', AuthenticatorFactory::class);
    }

    /**
     * Register the github factory class.
     *
     * @return void
     */
    protected function registerGitHubFactory()
    {
        $this->app->singleton('github.factory', function (Container $app) {
            $auth = $app['github.authfactory'];
            $cache = $app['cache'];

            return new \GrahamCampbell\GitHub\GitHubFactory($auth, $cache);
        });

        $this->app->alias('github.factory', \GrahamCampbell\GitHub\GitHubFactory::class);
    }

    /**
     * Register the manager class.
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->app->singleton('github', function (Container $app) {
            $config = $app['config'];
            $factory = $app['github.factory'];

            return new \GrahamCampbell\GitHub\GithubManager($config, $factory);
        });

        $this->app->alias('github', \GrahamCampbell\GitHub\GithubManager::class);
    }

    /**
     * Register the bindings.
     *
     * @return void
     */
    protected function registerBindings()
    {
        $this->app->bind('github.connection', function (Container $app) {
            $manager = $app['github'];

            return $manager->connection();
        });

        $this->app->alias('github.connection', Client::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'github.authfactory',
            'github.factory',
            'github',
            'github.connection',
        ];
    }
}
