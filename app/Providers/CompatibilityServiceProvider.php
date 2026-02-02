<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CompatibilityServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register all core Laravel services that might not auto-register in Laravel 11
        $this->registerFilesystem();
        $this->registerCache();
        $this->registerView();
        $this->registerEncrypter();
        $this->registerMaintenanceMode();
        $this->registerCookie();
        $this->registerSession();
        $this->registerUrl();
    }

    protected function registerFilesystem()
    {
        $this->app->singleton('files', function ($app) {
            return new \Illuminate\Filesystem\Filesystem;
        });
    }

    protected function registerCache()
    {
        $this->app->singleton('cache', function ($app) {
            return new \Illuminate\Cache\CacheManager($app);
        });
        
        $this->app->singleton('cache.store', function ($app) {
            return $app['cache']->driver();
        });
        
        $this->app->singleton('memcached.connector', function () {
            return new \Illuminate\Cache\MemcachedConnector;
        });
    }

    protected function registerView()
    {
        $this->app->singleton('view', function ($app) {
            $resolver = $app['view.engine.resolver'];
            $finder = $app['view.finder'];
            $env = new \Illuminate\View\Factory($resolver, $finder, $app['events']);
            $env->setContainer($app);
            $env->share('app', $app);
            return $env;
        });

        $this->app->singleton('view.finder', function ($app) {
            return new \Illuminate\View\FileViewFinder($app['files'], $app['config']['view.paths']);
        });

        $this->app->singleton('view.engine.resolver', function () {
            $resolver = new \Illuminate\View\Engines\EngineResolver;
            
            foreach (['php', 'blade'] as $engine) {
                $this->{'register'.ucfirst($engine).'Engine'}($resolver);
            }
            
            return $resolver;
        });
        
        $this->app->singleton('blade.compiler', function ($app) {
            return new \Illuminate\View\Compilers\BladeCompiler(
                $app['files'],
                $app['config']['view.compiled']
            );
        });
    }

    protected function registerPhpEngine($resolver)
    {
        $resolver->register('php', function () {
            return new \Illuminate\View\Engines\PhpEngine($this->app['files']);
        });
    }

    protected function registerBladeEngine($resolver)
    {
        $resolver->register('blade', function () {
            return new \Illuminate\View\Engines\CompilerEngine(
                $this->app['blade.compiler'],
                $this->app['files']
            );
        });
    }

    protected function registerEncrypter()
    {
        $this->app->singleton('encrypter', function ($app) {
            $config = $app->make('config');
            $key = $config->get('app.key');
            $cipher = $config->get('app.cipher', 'AES-256-CBC');
            
            if (str_starts_with($key, 'base64:')) {
                $key = base64_decode(substr($key, 7));
            }
            
            return new \Illuminate\Encryption\Encrypter($key, $cipher);
        });
    }

    protected function registerMaintenanceMode()
    {
        $this->app->singleton(
            \Illuminate\Contracts\Foundation\MaintenanceMode::class,
            function ($app) {
                return new \Illuminate\Foundation\MaintenanceModeManager($app);
            }
        );
    }

    protected function registerCookie()
    {
        $this->app->singleton('cookie', function ($app) {
            $config = $app->make('config')->get('session');
            return new \Illuminate\Cookie\CookieJar;
        });
    }

    protected function registerSession()
    {
        $this->app->singleton('session', function ($app) {
            return new \Illuminate\Session\SessionManager($app);
        });
        
        $this->app->singleton('session.store', function ($app) {
            return $app->make('session')->driver();
        });
    }

    protected function registerUrl()
    {
        $this->app->singleton('url', function ($app) {
            $routes = $app['router']->getRoutes();
            $app->instance('routes', $routes);
            
            return new \Illuminate\Routing\UrlGenerator(
                $routes,
                $app->rebinding('request', function ($app, $request) {
                    $app['url']->setRequest($request);
                }),
                $app['config']['app.asset_url']
            );
        });
    }

    public function boot()
    {
        //
    }
}
