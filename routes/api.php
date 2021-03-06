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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('user_list', 'API\UserController@userList');

Route::resource('questions', 'QuestionController');

Route::resource('tasks', 'API\TaskController');
Route::get('task_list','API\TaskController@taskList');

Route::post('register', 'API\UserController@register');
Route::post('login', 'API\UserController@login');
Route::post('logout', 'API\UserController@logout');

Route::group(['middleware' => ['jwt.verity']], function(){
    
    Route::get('user', 'API\UserController@user');
    
    Route::group(['prefix' => 'topics/'], function(){

        Route::get('', 'API\TopicController@index');
        Route::post('', 'API\TopicController@store');
        Route::get('{topic}', 'API\TopicController@show');
        Route::patch('{topic}', 'API\TopicController@update');
        Route::delete('{topic}', 'API\TopicController@destroy');
    
        Route::group(['prefix' => '{topic}/posts/'], function(){
            Route::get('', 'API\PostController@index');
            Route::post('', 'API\PostController@store');
            Route::get('{post}', 'API\PostController@show');
            Route::patch('{post}', 'API\PostController@update');
            Route::delete('{post}', 'API\PostController@destroy');

        });

        Route::group(['prefix' => '{post}/likes/'], function(){
            Route::get('', 'API\PostLikeController@index');
            Route::post('', 'API\PostLikeController@store');

        });

    });
   


});