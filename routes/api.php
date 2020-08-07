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

        $router->get('/', function () use ($router) {
            return response()->json([
                'name' => config('app.name'),
                'version' => config('app.version'),
                'locale' => app()->getLocale()
            ]);
        });

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
            ->middleware(['auth:api'])
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
                        $router->post('/', 'ServicesController@store')
                            ->middleware('api.superAdmin')->name('store');
                        $router->get('/{id}', 'ServicesController@get')->name('index');
                        $router->put('/{id}', 'ServicesController@update')
                            ->middleware('api.superAdmin')->name('update');
                        $router->delete('/{id}', 'ServicesController@destroy')
                            ->middleware('api.superAdmin')->name('destroy');
                        $router->post('/category', 'ServicesController@storeCategory')
                            ->middleware('api.superAdmin')->name('store.category');
                        $router->put('{id}/category/{category_id}', 'ServicesController@updateCategory')
                            ->middleware('api.superAdmin')->name('update.category');
                        $router->delete('{id}/category/{category_id}', 'ServicesController@destroyCategory')
                            ->middleware('api.superAdmin')->name('destroy.category');
                    });

                // Solicitations Routes
                $router
                    ->namespace('Solicitation')
                    ->prefix('solicitation')
                    ->name('solicitation.')
                    ->group(function () use ($router) {
                        $router->get('/', 'SolicitationsController@getAll')
                            ->middleware('api.superAdmin')->name('all');
                        $router->get('/user', 'SolicitationsController@getAllUser')->name('allUser');
                        $router->get('/{id}', 'SolicitationsController@get')->name('index');
                        $router->post('/', 'SolicitationsController@store')->name('store');
                        $router->put('/{id}', 'SolicitationsController@update')
                            ->middleware('api.superAdmin')->name('update');
                    });

                // Notices Routes
                $router
                    ->namespace('Notice')
                    ->prefix('notice')
                    ->name('notice.')
                    ->group(function () use ($router) {
                        $router->get('/', 'NoticesController@getAll')->name('all');
                        $router->get('/{id}', 'NoticesController@get')->name('index');
                        $router->put('/{id}', 'NoticesController@update')
                            ->middleware('api.superAdmin')->name('update');
                        $router->post('/', 'NoticesController@store')
                            ->middleware('api.superAdmin')->name('store');
                        $router->delete('/{id}', 'NoticesController@destroy')
                            ->middleware('api.superAdmin')->name('destroy');
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
