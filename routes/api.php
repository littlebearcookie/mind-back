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

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});
Route::group([
	'middleware' => 'api',
	'namespace' => 'App\Http\Controllers\Api'
], function () {
	# Mind
	Route::get('/minds', 'MindController@all');
	Route::get('/minds/{mind_id}', 'MindController@one');
	Route::post('/minds', 'MindController@add');
	Route::put('/minds/{mind_id}', 'MindController@edit');
	Route::delete('/minds/{mind_id}', 'MindController@delete');
	Route::post('/minds/import', 'MindController@import');
	Route::get('/minds/{mind_id}/export', 'MindController@export');
});
