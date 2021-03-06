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
    $res['success'] = true;
    $res['result'] = "Hello there welcome to web api using lumen!";
    return response($res);
});

$router->options(
    '/{any:.*}', 
    [
        'middleware' => ['CorsMiddleware'], 
        function (){ 
            return response(['status' => 'success']); 
        }
    ]
);
$router->group(['middleware' => 'CorsMiddleware'], function($router){
    $router->post('/login', 'LoginController@index');
    $router->post('/register', 'UserController@register');
});
// $router->post('/login', 'LoginController@index');
// $router->group(['middleware' => 'CorsMiddleWare2'], function() use ($router) {
//     $router->post('/login', 'LoginController@index');
// });
$router->get('/user/{id}', ['middleware' => 'auth', 'uses' => 'UserController@get_user']);

// $router->post('/auth/login', 'AuthController@postLogin');
