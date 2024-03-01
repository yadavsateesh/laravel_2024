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
	
	Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
		return $request->user();
	});
	
	Route::group(['prefix' => '', 'middleware' => ['saveApiAudit']], function () {
		Route::post('register', [App\Http\Controllers\Api\AuthController::class, 'register']);
		Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'login']);
		Route::post('verify-otp', [App\Http\Controllers\Api\AuthController::class, 'verifyOtp']);
		
		
		Route::group(['middleware' => ['authApi']], function () {
		
			//User
			Route::post('logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
			Route::post('edit-profile', [App\Http\Controllers\Api\AuthController::class, 'editProfile']);
			Route::post('change-password', [App\Http\Controllers\Api\AuthController::class, 'changePasswordUpdate']);
			Route::post('get-user-details', [App\Http\Controllers\Api\AuthController::class, 'getUserDetails']);
			
			//category
			Route::post('get-category', [App\Http\Controllers\Api\CategoryController::class, 'getCategory']);
			Route::post('get-category-by-id', [App\Http\Controllers\Api\CategoryController::class, 'getCategorybyid']);
			
			//subcategory
			Route::post('get-subcategory', [App\Http\Controllers\Api\SubCategoryController::class, 'getSubCategory']);
			Route::post('get-subcategory-by-id', [App\Http\Controllers\Api\SubCategoryController::class, 'getByidSubCategory']);
			
			//product
			Route::post('get-product', [App\Http\Controllers\Api\ProductController::class, 'getProduct']);
			Route::post('get-product-by-id', [App\Http\Controllers\Api\ProductController::class, 'getByidProduct']);
			
			
		});
	});		