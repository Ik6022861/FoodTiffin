<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Vendor\GalleryController;
use App\Http\Controllers\Vendor\MenuController;
use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\Vendor\RestaurantController;
use App\Http\Controllers\Vendor\VendorController as VendorVendorController;
use App\Http\Controllers\VendorController;



Route::controller(UserController::class)->group(function(){
    route::get('/', 'index')->name('index');
});

Route::get('/dashboard', function () {
    return view('frontend.dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/store/profile', [ProfileController::class, 'profileStore'])->name('profile.store');
    Route::get('/user/logout', [ProfileController::class, 'userLogout'])->name('user.logout');
    Route::get('/change/password', [ProfileController::class, 'changePassword'])->name('change.password');
    Route::post('/password/update', [ProfileController::class, 'passwordUpdate'])->name('user.password.update');
});

require __DIR__.'/auth.php';

// Admin Routes

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])
->name('admin.login');

route::middleware('admin')->group(function() {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])
    ->name('admin.dashboard');

    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])
    ->name('admin.profile');

    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])
    ->name('admin.profile.store');

    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])
    ->name('admin.change.password');

    Route::post('/admin/password/update', [AdminController::class, 'AdminUpdatePassword'])
    ->name('admin.password.update');
});

Route::post('/admin/login_submit', [AdminController::class, 'AdminLoginSubmit'])
->name('admin.login_submit');

Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])
->name('admin.logout');

Route::get('/admin/forget_password', [AdminController::class, 'AdminForgetPassword'])
->name('admin.forget_password');

Route::post('/admin/password_submit', [AdminController::class, 'AdminPasswordSubmit'])
->name('admin.password_submit');

Route::get('/admin/reset-password/{token}/{email}', [AdminController::class, 'AdminResetPassword']);
Route::post('/admin/reset-password_submit', [AdminController::class, 'AdminResetPasswordSubmit'])
->name('admin.reset_password_submit');



// All Routes for vendor

Route::get('/vendor/login', [VendorController::class, 'VendorLogin'])
->name('vendor.login');

Route::post('/vendor/login/submit', [VendorController::class, 'VendorLoginSubmit'])
->name('vendor.login_submit');

Route::get('/vendor/logout', [VendorController::class, 'VendorLogout'])
->name('vendor.logout');

Route::get('/vendor/forget_password', [VendorController::class, 'VendorForgetPassword'])
->name('vendor.forget_password');

Route::post('/vendor/forget_password/submit', [VendorController::class, 'VendorPasswordSubmit'])
->name('vendor.password_submit');

Route::get('vendor/reset_password/{token}/{email}', [VendorController::class, 'VendorResetPassword']);

Route::post('/vendor/reset_password_submit', [VendorController::class, 'VendorResetPasswordSubmit'])
->name('vendor.reset_password_submit');

Route::get('/vendor/register', [VendorController::class, 'VendorRegister'])
->name('vendor.register');

Route::post('/vendor/register/submit', [VendorController::class, 'VendorRegisterSubmit'])
->name('vendor.register.submit');


Route::middleware('vendor')->group(function(){
    Route::get('/vendor/dashboard', [VendorController::class, 'VendorDashboard'])
    ->name('vendor.dashboard');

    Route::get('/vendor/profile', [VendorController::class, 'VendorProfile'])
    ->name('vendor.profile');

    Route::post('/vendor/profile/store', [VendorController::class, 'VendorProfileStore'])
    ->name('vendor.profile.store');

    Route::get('/change/password', [VendorController::class, 'changePassword'])
    ->name('vendor.change_password');

    Route::post('/vendor/update/password', [VendorController::class, 'updatePassword'])
    ->name('vendor.password.update');


    // Gallery
    Route::get('/vendor/all/gallery', [GalleryController::class, 'allGallery'])
    ->name('all.gallery');

    Route::get('/vendor/add/gallery', [GalleryController::class, 'addGallery'])
    ->name('add.gallery');

    Route::post('/vendor/gallery/store', [GalleryController::class, 'galleryStore'])
    ->name('gallery.store');

    Route::get('/edit/gallery/{id}', [GalleryController::class, 'EditGallery'])
    ->name('edit.gallery');

    Route::post('/update/gallery', [GalleryController::class, 'UpdateGallery'])
    ->name('gallery.update');

    Route::get('/delete/gallery/{id}', [GalleryController::class, 'DeleteGallery'])
    ->name('delete.gallery');
});


// All Routes for vendors end here

// All Admin Category

route::middleware('admin')->group(function() {

    // Group Controller

    Route::controller(CategoryController::class)->group(function() {
        Route::get('/all/category', 'AllCategory')->name('all.category');
        Route::get('/add/category', 'AddCategory')->name('add.category');
        Route::post('/store/category', 'storeCategory')->name('category.store');
        Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category');
        Route::post('/update/category', 'UpdateCategory')->name('category.update');
        Route::get('/delete/category/{id}', 'DeleteCategory')->name('delete.category');
    });

});

// All Admin City

route::middleware('admin')->group(function() {
    Route::controller(CityController::class)->group(function() {
        Route::get('/all/city', 'AllCity')->name('all.city');
        Route::post('/store/city', 'storeCity')->name('city.store');
        Route::get('/edit/city/{id}', 'EditCity')->name('edit.city');
        Route::post('/update/city', 'UpdateCity')->name('city.update');
        Route::get('/delete/city/{id}', 'DeleteCity')->name('delete.city');
    });

});


// Vendor Menus

Route::middleware('vendor')->group(function(){
    Route::controller(MenuController::class)->group(function() {
        Route::get('/all/menu', 'AllMenu')->name('all.menu');
        Route::get('/add/menu', 'AddMenu')->name('add.menu');
        Route::post('/store/menu', 'StoreMenu')->name('menu.store');
        Route::get('/edit/menu/{id}', 'EditMenu')->name('edit.menu');
        Route::post('/update/menu', 'UpdateMenu')->name('menu.update');
        Route::get('/delete/menu/{id}', 'DeleteMenu')->name('delete.menu');

    });
});


// Vendor Products

Route::middleware('vendor')->group(function(){
    Route::controller(ProductController::class)->group(function() {
        Route::get('/all/product', 'AllProduct')->name('all.product');
        Route::get('/add/product', 'AddProduct')->name('add.product');
        Route::post('/store/product', 'StoreProduct')->name('product.store');
        Route::get('/edit/product/{id}', 'EditProduct')->name('edit.product');
        Route::post('/update/product', 'UpdateProduct')->name('product.update');
        Route::get('/delete/product/{id}', 'DeleteProduct')->name('delete.product');
        Route::get('/changeStatus', 'changeStatus');

    });
});








