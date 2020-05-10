<?php

use Illuminate\Http\Request;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Route to register new users. Must be disabled by default
//Route::post('register', 'API\RegisterController@register');

//Login API
Route::get('token', 'API\RegisterController@login');


//Courses API
Route::get('courses/', 'API\CoursesController@showPages')->middleware('auth:api');
Route::get('courses/all', 'API\CoursesController@showAll')->middleware('auth:api');
Route::get('courses/{id}', 'API\CoursesController@show')->middleware('auth:api');
Route::post('courses', 'API\CoursesController@store')->middleware('auth:api');
Route::put('courses/{id}', 'API\CoursesController@update')->middleware('auth:api');
Route::delete('courses/{id}', 'API\CoursesController@destroy')->middleware('auth:api');
