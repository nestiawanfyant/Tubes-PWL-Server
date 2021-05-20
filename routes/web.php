<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
    return "test";
});

$router->post('login',              'AuthController@login');
$router->post('logout',             'AuthController@logout');
$router->post('register',           'AuthController@register');


$router->post('kelas/list',         'KelasController@index');
$router->post('kelas/store',        'KelasController@store');
$router->post('kelas/show',         'KelasController@show');
$router->post('kelas/update',       'KelasController@update');
$router->post('kelas/destroy',      'KelasController@destroy');

$router->post('materi/store',       'MateriController@store');
$router->post('materi/show',        'MateriController@show');
$router->post('materi/update',      'MateriController@update');
$router->post('materi/destroy',     'MateriController@destroy');

$router->post('tugas/store',        'TugasController@store');
$router->post('tugas/show',         'TugasController@show');
$router->post('tugas/update',       'TugasController@update');
$router->post('tugas/destroy',      'TugasController@destroy');

$router->post('post/store',         'PostController@store');
$router->post('post/update',        'PostController@update');
$router->post('post/destroy',       'PostController@destroy');

$router->post('post/komentar/store',    'KomentarKelas@store');
$router->post('post/komentar/destroy',  'KomentarKelas@destroy');

$router->post('materi/komentar/store',   'KomentarMateri@store');
$router->post('materi/komentar/destroy', 'KomentarMateri@destroy');

$router->post('tugas/komentar/store',   'KomentarTugas@store');
$router->post('tugas/komentar/destroy', 'KomentarTugasController@destroy');
