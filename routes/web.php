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


$router->get('kelas/list',          'KelasController@index');
$router->get('kelas/terbuka',       'KelasController@kelasTerbuka');
$router->get('kelas/show',          'KelasController@show');
$router->get('kelas/peserta',       'KelasController@pesertaList');
$router->get('kelas/tipe',          'KelasController@getTipeKelas');
$router->post('kelas/store',        'KelasController@store');
$router->post('kelas/update',       'KelasController@update');
$router->post('kelas/destroy',      'KelasController@destroy');
$router->post('kelas/join',         'KelasController@join');
$router->post('kelas/terbuka/join', 'KelasController@joinKelasTerbuka');
$router->post('kelas/terbuka/accept',   'KelasController@acceptKelasTerbuka');
$router->post('kelas/peserta/destroy',  'KelasController@pesertaDestroy');

$router->get('materi/list',         'MateriController@index');
$router->post('materi/store',       'MateriController@store');
$router->post('materi/show',        'MateriController@show');
$router->post('materi/update',      'MateriController@update');
$router->post('materi/destroy',     'MateriController@destroy');

$router->get('tugas/list',          'TugasController@index');
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

$router->post('tugas/submission',           'SubmissionController@index');
$router->post('tugas/submission/store',     'SubmissionController@store');
$router->post('tugas/submission/destroy',   'SubmissionController@destroy');
