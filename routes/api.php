<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\github\GithubController;
use App\Http\Controllers\github\GithubProcessController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Rutas sin necesidad de permisos
Route::get('/get-last-user', [GithubController::class, 'getLastUser']);
Route::post('/insert-user', [GithubProcessController::class, 'insertGihubUser']);
Route::get('/get-users-github-stored', [GithubController::class, 'index']);
Route::post('/insert-globe-users-graphos', [GithubProcessController::class, 'createGithubGraphos']);
Route::get('/get-github-globe-users', [GithubController::class, 'getGithubGlobeUsers']);
Route::get('/get-github-globe-users-location', [GithubController::class, 'getGithubGlobeUsersLocation']);
