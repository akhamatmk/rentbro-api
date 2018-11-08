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

$router->get('test', 'ExampleController@tes');
$router->post('product/option/multiple', 'ProductOptionController@multiple');

$router->get('invoice/{inv}', ['uses' => 'TransactionController@invoice' , 'middleware' => ['cors', 'jwtauth']]);

$router->get('chart/list/ajax', ['uses' => 'ChartController@ajaxList' , 'middleware' => ['cors', 'jwtauth']]);
$router->get('chart/list', ['uses' => 'ChartController@list' , 'middleware' => ['cors', 'jwtauth']]);
$router->delete('chart/{chart}', ['uses' => 'ChartController@destroy' , 'middleware' => ['cors','jwtauth']]);
$router->post('chart/checkout', ['uses' => 'ChartController@checkout' , 'middleware' => ['cors', 'jwtauth']]);

$router->get('product/list', 'ProductController@list');
$router->get('product/{vendor}/{product}', 'ProductController@detail');
$router->post('product/{vendor}/{product}', ['uses' => 'ProductController@chart' , 'middleware' => ['cors', 'jwtauth']]);

$router->get('product/option', 'ProductOptionController@index');
$router->get('product/option/{name}', 'ProductOptionController@show');

$router->get('catalogue', 'CatalogueController@index');
$router->get('catalogue/{id}', 'CatalogueController@show');

$router->post('user/register', 'User\RegisterController@create');
$router->post('user/register/{provider}', 'User\RegisterController@checkOtherApps');
$router->post('user/login', 'User\LoginController@check');
$router->post('user/login/with/{provider}', 'User\LoginController@checkOtherApps');
$router->get('category', 'CategoryController@index');
$router->post('shop/register', ['uses' => 'User\ShopController@register' , 'middleware' => ['jwtauth']]);
$router->get('user/info', ['uses' => 'UserController@info' , 'middleware' => ['jwtauth']]);
$router->post('vendor/{nickname}/product/store', ['uses' => 'User\VendorController@product_add' , 'middleware' => ['cors', 'jwtauth']]);
$router->post('user/profile/edit', ['uses' => 'UserController@profile_edit' , 'middleware' => ['jwtauth']]);
$router->get('user/send/code/newPassword', ['uses' => 'UserController@send_code_new_password' , 'middleware' => ['cors', 'jwtauth']]);
$router->get('user/check/code/newPassword', ['uses' => 'UserController@check_code_new_password' , 'middleware' => ['cors', 'jwtauth']]);

$router->post('user/set/new/password', ['uses' => 'UserController@make_new_password' , 'middleware' => ['cors', 'jwtauth']]);
$router->post('user/change/password', ['uses' => 'UserController@change_new_password' , 'middleware' => ['cors', 'jwtauth']]);


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
$router->get('vendor/{nickname}/list_product', ['uses' => 'User\VendorController@list_product' , 'middleware' => ['cors', 'jwtauth']]);
$router->get('vendor/{nickname}/location/first', ['uses' => 'User\VendorController@location_first' , 'middleware' => ['cors']]);
$router->post('location/{nickname}/vendor/edit', ['uses' => 'User\VendorController@location_edit' , 'middleware' => ['cors', 'jwtauth']]);


$router->post('vendor/create', ['uses' => 'User\VendorController@create' , 'middleware' => ['cors', 'jwtauth']]);
$router->post('user/address/add', ['uses' => 'UserController@address_add' , 'middleware' => ['jwtauth']]);
$router->get('user/address', ['uses' => 'UserController@list_address' , 'middleware' => ['jwtauth']]);
$router->get('user/address/{id}', ['uses' => 'UserController@detail_address' , 'middleware' => ['jwtauth']]);
$router->put('user/address/{id}', ['uses' => 'UserController@edit_address' , 'middleware' => ['jwtauth']]);
$router->delete('user/address/{id}', ['uses' => 'UserController@delete_address' , 'middleware' => ['jwtauth']]);