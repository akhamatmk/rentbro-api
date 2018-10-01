<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    
}

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

$app->withFacades();

$app->withEloquent();

$app->configure('cors');
$app->configure('jwt');
$app->configure('auth');
$app->configure('rajaongkir');

$app->withFacades(true, [
    Tymon\JWTAuth\Facades\JWTAuth::class => 'JWTAuth',
    Tymon\JWTAuth\Facades\JWTFactory::class => 'JWTFactory',

]);

$app->register(Pewe\RajaOngkir\Providers\RajaOngkirServiceProvider::class);
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);
$app->register(\Illuminate\Mail\MailServiceProvider::class);

class_alias('Pewe\RajaOngkir\Facades\Province', 'Province');
class_alias('Pewe\RajaOngkir\Facades\City', 'City');
class_alias('Pewe\RajaOngkir\Facades\Cost', 'Cost');

$app->configure('services');
$app->configure('mail');

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->routeMiddleware([
    'cors'    => \App\Http\Middleware\FormattingRequestMiddleware::class,
    'jwtauth'    => \App\Http\Middleware\authJWT::class,    
]);


$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

return $app;