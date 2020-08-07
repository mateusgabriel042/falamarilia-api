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


                // Profile Routes
                $router
                    ->namespace('User')
                    ->prefix('profile')
                    ->name('profile.')
                    ->group(function () use ($router) {
                        $router->get('/', 'ProfilesController@get')->name('index');
                        $router->put('/', 'ProfilesController@update')->name('update');
                    });

                // Services Routes
                $router
                    ->namespace('Service')
                    ->prefix('service')
                    ->name('service.')
                    ->group(function () use ($router) {
                        $router->get('/', 'ServicesController@getAll')->name('all');
                        $router->post('/', 'ServicesController@store')->name('store');
                        $router->get('/{id}', 'ServicesController@get')->name('index');
                        $router->put('/{id}', 'ServicesController@update')->name('update');
                        $router->delete('/{id}', 'ServicesController@destroy')->name('destroy');
                        $router->post('/category', 'ServicesController@storeCategory')->name('store.category');
                        $router->put('{id}/category/{category_id}', 'ServicesController@updateCategory')->name('update.category');
                        $router->delete('{id}/category/{category_id}', 'ServicesController@destroyCategory')->name('destroy.category');
                    });

                // Categories Routes
                $router
                    ->namespace('Categories')
                    ->prefix('category')
                    ->name('category.')
                    ->group(function () use ($router) {
                        $router->get('/', 'CategoryController@getAll')->name('all');
                        $router->get('/{id}', 'CategoryController@get')->name('index');
                        $router->put('/{id}', 'CategoryController@update')->name('update');
                        $router->post('/', 'CategoryController@store')->name('store');
                        $router->delete('/{id}', 'CategoryController@destroy')->name('destroy');
                    });

                // Reset Password Routes
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
