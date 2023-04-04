<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', [RegisterController::class, 'create']);
Route::post('/login', [LoginController::class, 'login']);

// Route::prefix('api')->group(function () {
//     Route::get('/authors', [AuthorController::class, 'index']);
//     Route::get('/authors/{id}/comics', [AuthorController::class, 'authorComics']);
// });


// Route::group(['prefix' => 'api', 'middleware' => ['auth:api']], function(){
//     Route::get('/authors', [AuthorController::class, 'index']);
//     Route::get('/authors/{id}/comics', [AuthorController::class, 'authorComics']);
// });
