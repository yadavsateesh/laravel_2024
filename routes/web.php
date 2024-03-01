<?php
	
	use Illuminate\Support\Facades\Route;
	
	/*
		|--------------------------------------------------------------------------
		| Web Routes
		|--------------------------------------------------------------------------
		|
		| Here is where you can register web routes for your application. These
		| routes are loaded by the RouteServiceProvider within a group which
		| contains the "web" middleware group. Now create something great!
		|
	*/
	
	Route::get('/', function () {
		return view('welcome');
	});
	
	Route::group(['prefix' => 'admin'], function () {
		Route::get('/login', 'App\Http\Controllers\AdminAuth\LoginController@showLoginForm')->name('login');
		Route::post('/login', 'App\Http\Controllers\AdminAuth\LoginController@login');
		Route::post('/logout', 'App\Http\Controllers\AdminAuth\LoginController@logout')->name('logout');
		Route::get('/logout', 'App\Http\Controllers\AdminAuth\LoginController@logout')->name('logout');
		Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home');
		
		Route::get('/register', 'App\Http\Controllers\AdminAuth\RegisterController@showRegistrationForm')->name('register');
		Route::post('/register', 'App\Http\Controllers\AdminAuth\RegisterController@register');
		
		Route::post('/password/email', 'App\Http\Controllers\AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
		Route::post('/password/reset', 'App\Http\Controllers\AdminAuth\ResetPasswordController@reset')->name('password.email');
		Route::get('/password/reset', 'App\Http\Controllers\AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
		Route::get('/password/reset/{token}', 'App\Http\Controllers\AdminAuth\ResetPasswordController@showResetForm');
		
		//Edit Profile
		Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('admin.profile');
		Route::post('/profile-update', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('admin.profile.update');
		
		//Change Password 
		Route::get('/change-password', [App\Http\Controllers\Admin\ProfileController::class, 'changePassword'])->name('admin.change.password');
		Route::post('/change-password-update', [App\Http\Controllers\Admin\ProfileController::class, 'changePasswordUpdate'])->name('admin.change.password.update');
		
		//category
		Route::resource('/category', App\Http\Controllers\Admin\CategoryController::class);
		Route::post('/category-list', [App\Http\Controllers\Admin\CategoryController::class, 'categoryList'])->name('category-list');
		Route::get('/category/delete/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'delete'])->name('category.delete');
		Route::post('all-category-delete/', [App\Http\Controllers\Admin\CategoryController::class, 'deleteAll'])->name('all-category-delete');
		
		//subcategory
		Route::resource('/subcategory', App\Http\Controllers\Admin\SubCategoryController::class);
		Route::post('/subcategory-list', [App\Http\Controllers\Admin\SubCategoryController::class, 'subcategoryList'])->name('subcategory-list');
		Route::get('/subcategory/delete/{subcategory}', [App\Http\Controllers\Admin\SubCategoryController::class, 'delete'])->name('subcategory.delete');
		Route::post('all-subcategory-delete', [App\Http\Controllers\Admin\SubCategoryController::class, 'allDelete'])->name('all-subcategory-delete');
		
		//product
		Route::resource('/product', App\Http\Controllers\Admin\ProductController::class);
		Route::post('/product-list', [App\Http\Controllers\Admin\ProductController::class, 'productList'])->name('product-list');
		Route::get('/product/delete/{product}', [App\Http\Controllers\Admin\ProductController::class, 'delete'])->name('product.delete');
		Route::get('/image-delete/{image}', [App\Http\Controllers\Admin\ProductController::class, 'imageDelete'])->name('image.delete');
		Route::post('/get-subcategory', [App\Http\Controllers\Admin\ProductController::class, 'getSubcategory'])->name('get-subcategory');
		Route::get('change-status/{user}/{status}', [App\Http\Controllers\Admin\ProductController::class, 'userBlock'])->name('product.change-status');
		Route::get('export', [App\Http\Controllers\Admin\ProductController::class, 'export'])->name('product.export');
		Route::post('import', [App\Http\Controllers\Admin\ProductController::class, 'import'])->name('product.import');
		Route::get('generate-pdf/{id}',[App\Http\Controllers\Admin\ProductController::class, 'generatePDF'])->name('product.generatepdf');
		Route::get('product-order',[App\Http\Controllers\Admin\ProductController::class, 'productOrder'])->name('product-order');
		Route::post('product-order',[App\Http\Controllers\Admin\ProductController::class, 'productOrder'])->name('product-order');
		Route::post('/product-order-save', [App\Http\Controllers\Admin\ProductController::class, 'saveOrder'])->name('product-order-save');
		Route::post('all-product-delete/', [App\Http\Controllers\Admin\ProductController::class, 'deleteAll'])->name('all-product-delete');
		Route::post('/status-multiple-publish', [App\Http\Controllers\Admin\ProductController::class, 'status'])->name('status.multiple.active');
		
		//Language
		//Route::get('lang/change', [App\Http\Controllers\Admin\LanguageController::class, 'index'])->name('changeLang');
		
		Route::get('lang/change/{locale}', function ($locale) {
			if (! in_array($locale, ['en', 'hi', ])) {
				abort(400);
			}
			App::setLocale($locale);
			session()->put('locale', $locale);
			return redirect()->back();
			})->name('lang.change');
		
	});
	
	Route::group(['prefix' => 'user'], function () {
		Route::get('/login', 'App\Http\Controllers\UserAuth\LoginController@showLoginForm')->name('login');
		Route::post('/login',  'App\Http\Controllers\UserAuth\LoginController@login');
		Route::post('/logout',  'App\Http\Controllers\UserAuth\LoginController@logout')->name('logout');
		
		Route::get('/register',  'App\Http\Controllers\UserAuth\RegisterController@showRegistrationForm')->name('register');
		Route::post('/register', 'UserAuth\RegisterController@register');
		
		Route::post('/password/email',  'App\Http\Controllers\UserAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
		Route::post('/password/reset', 'App\Http\Controllers\UserAuth\ResetPasswordController@reset')->name('password.email');
		Route::get('/password/reset',  'App\Http\Controllers\UserAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
		Route::get('/password/reset/{token}',  'App\Http\Controllers\UserAuth\ResetPasswordController@showResetForm');
	});
