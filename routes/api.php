<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$router = app(Router::class);

$router
    ->prefix('/')
    ->middleware(['cors', 'json.response', 'useapiguard'])
    ->group(function () use ($router) {

        // Public Routes
        $router
            ->prefix('auth')
            ->name('auth.')
            ->group(function () use ($router) {
                $router->post('/login', 'Auth\ApiAuthController@login')->name('login');
                $router->post('/register', 'Auth\ApiAuthController@register')->name('register');
                $router->post('/logout', 'Auth\ApiAuthController@logout')->name('logout');
            });

        // Protected Routes
        $router
            ->middleware(['auth:api', 'api.superAdmin'])
            ->group(function () use ($router) {


                // Profile Controller
                $router
                    ->namespace('User')
                    ->prefix('profile')
                    ->name('profile.')
                    ->group(function () use ($router) {
                        // $router->user();
                        $router->get('/', 'ProfilesController@get')->name('index');
                        $router->put('/', 'ProfilesController@update')->name('update');
                    });

                // Reset Password
                $router
                    ->namespace('Auth')
                    ->prefix('password')
                    ->name('password.')
                    ->group(function () use ($router) {
                        $router->post('/send', 'ResetPasswordController@sendPasswordByEmail')->name('send');
                        $router->post('/forgot', 'ResetPasswordController@resetPassword')->name('forgot');
                    });
            });
    });
