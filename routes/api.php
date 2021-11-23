<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('v1/events', 'Api\EventsController')->only('index');
Route::apiResource('v1/registrations', 'Api\RegistrationsController')->only('index');
Route::apiResource('v1/organizers/{organizerSlug}/events/{eventSlug}/registration', 'Api\Organizers\Events\RegistrationController')->only('store');
Route::get('v1/organizers/{organizerSlug}/events/{eventSlug}', 'Api\Organizers\EventsController@show');
Route::post('v1/login', 'Api\AuthController@login');
Route::post('v1/logout', 'Api\AuthController@logout');
