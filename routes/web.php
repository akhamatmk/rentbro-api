<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->get('catalogue', 'CatalogueController@index');
$router->get('catalogue/{id}', 'CatalogueController@show');

$router->post('user/register', 'User\RegisterController@create');
$router->post('user/register/{provider}', 'User\RegisterController@checkOtherApps');
$router->post('user/login', 'User\LoginController@check');
$router->post('user/login/with/{provider}', 'User\LoginController@checkOtherApps');
$router->get('category', 'CategoryController@index');
$router->post('shop/register', ['uses' => 'User\ShopController@register' , 'middleware' => ['jwtauth']]);
$router->get('user/info', ['uses' => 'UserController@info' , 'middleware' => ['jwtauth']]);

$router->post('vendor/{vendor_id}/product/store', ['uses' => 'User\VendorController@product_add' , 'middleware' => ['cors', 'jwtauth']]);

$router->post('user/profile/edit', ['uses' => 'UserController@profile_edit' , 'middleware' => ['jwtauth']]);
$router->post('user/profile/image/change', ['uses' => 'UserController@profile_image_change' , 'middleware' => ['jwtauth']]);

$router->post('user/profile/edit/validation', ['uses' => 'UserController@profile_edit_validation' , 'middleware' => ['jwtauth']]);
$router->post('user/check/email', ['uses' => 'UserController@check_email']);
$router->post('user/check/validation', ['uses' => 'UserController@validation']);
$router->post('user/check/username', ['uses' => 'UserController@check_username' , 'middleware' => ['cors', 'jwtauth']]);

$router->get('place/province', ['uses' => 'PlaceController@province' , 'middleware' => ['cors']]);
$router->get('place/regency', ['uses' => 'PlaceController@regency' , 'middleware' => ['cors']]);
$router->get('place/district', ['uses' => 'PlaceController@district' , 'middleware' => ['cors']]);

$router->get('vendor/nickname/check', ['uses' => 'User\VendorController@nicknameCheck' , 'middleware' => ['cors']]);
$router->get('vendor/{nickname}/profile', ['uses' => 'User\VendorController@profile' , 'middleware' => ['cors', 'jwtauth']]);
$router->post('vendor/create', ['uses' => 'User\VendorController@create' , 'middleware' => ['cors', 'jwtauth']]);

$router->post('user/address/add', ['uses' => 'UserController@address_add' , 'middleware' => ['jwtauth']]);
$router->get('user/address', ['uses' => 'UserController@list_address' , 'middleware' => ['jwtauth']]);
$router->get('user/address/{id}', ['uses' => 'UserController@detail_address' , 'middleware' => ['jwtauth']]);
$router->put('user/address/{id}', ['uses' => 'UserController@edit_address' , 'middleware' => ['jwtauth']]);
$router->delete('user/address/{id}', ['uses' => 'UserController@delete_address' , 'middleware' => ['jwtauth']]);