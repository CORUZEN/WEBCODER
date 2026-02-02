<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

// Register core services IMMEDIATELY after app creation
$app->singleton('files', fn() => new \Illuminate\Filesystem\Filesystem);

$app->singleton('cookie', fn($app) => (new \Illuminate\Cookie\CookieJar)->setDefaultPathAndDomain(
    '/', 
    null, 
    null, 
    null
));

$app->singleton('session', fn($app) => new \Illuminate\Session\SessionManager($app));

$app->singleton('cache', fn($app) => new \Illuminate\Cache\CacheManager($app));

$app->singleton('view', function ($app) {
    $resolver = new \Illuminate\View\Engines\EngineResolver;
    $resolver->register('php', fn() => new \Illuminate\View\Engines\PhpEngine($app['files']));
    
    $app->singleton('blade.compiler', fn($app) => new \Illuminate\View\Compilers\BladeCompiler(
        $app['files'],
        storage_path('framework/views')
    ));
    
    $resolver->register('blade', fn() => new \Illuminate\View\Engines\CompilerEngine(
        $app['blade.compiler'],
        $app['files']
    ));
    
    $finder = new \Illuminate\View\FileViewFinder($app['files'], [resource_path('views')]);
    $env = new \Illuminate\View\Factory($resolver, $finder, $app['events']);
    $env->setContainer($app);
    $env->share('app', $app);
    return $env;
});

$app->singleton(\Illuminate\Contracts\Foundation\MaintenanceMode::class, 
    fn($app) => new \Illuminate\Foundation\MaintenanceModeManager($app)
);

// Register the compatibility provider
$app->register(\App\Providers\CompatibilityServiceProvider::class);

return $app;
