<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;


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


// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class,'getAll']);
Route::get('/products/{id}', [ProductController::class,'getSingleProduct']);


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

});

Route::post('/products', [ProductController::class,'storeProduct']);
Route::delete('/products/{id}',[ProductController::class,'deleteProduct']);
Route::put('/products/{id}',[ProductController::class,'updateProduct']);
Route::post('/logout', [AuthController::class, 'logout']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
