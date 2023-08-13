<?php

use App\Http\Controllers\Admin\RekapitulasiDataController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');
Route::get('/lomba', 'HomeController@lomba')->name('home.lomba');
Route::get('/lomba/{content_page:title}', 'HomeController@show')->name('home.show');

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {

    Route::get('/', 'HomeController@index')->name('home');
    
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Prodi
    Route::delete('prodis/destroy', 'ProdiController@massDestroy')->name('prodis.massDestroy');
    Route::resource('prodis', 'ProdiController');

    // Mahasiswa
    Route::delete('mahasiswas/destroy', 'MahasiswaController@massDestroy')->name('mahasiswas.massDestroy');
    Route::resource('mahasiswas', 'MahasiswaController');
    Route::post('mahasiswa', 'MahasiswaController@index')->name('mahasiswa.index');

    // Prestasi
    Route::delete('prestasis/destroy', 'PrestasiController@massDestroy')->name('prestasis.massDestroy');
    Route::post('prestasis/media', 'PrestasiController@storeMedia')->name('prestasis.storeMedia');
    Route::post('prestasis/ckmedia', 'PrestasiController@storeCKEditorImages')->name('prestasis.storeCKEditorImages');
    Route::patch('prestasis/verif/{prestasi}', 'PrestasiController@verif')->name('prestasis.verif');
    Route::resource('prestasis', 'PrestasiController');

    // Content Page
    Route::delete('content-pages/destroy', 'ContentPageController@massDestroy')->name('content-pages.massDestroy');
    Route::post('content-pages/media', 'ContentPageController@storeMedia')->name('content-pages.storeMedia');
    Route::post('content-pages/ckmedia', 'ContentPageController@storeCKEditorImages')->name('content-pages.storeCKEditorImages');
    Route::resource('content-pages', 'ContentPageController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
Route::group(['as' => 'frontend.', 'namespace' => 'Frontend', 'middleware' => ['auth']], function () {

    Route::get('password', 'ChangePasswordUserController@edit')->name('password.edit');
    Route::post('password', 'ChangePasswordUserController@update')->name('password.update');
    Route::post('profile', 'ChangePasswordUserController@updateProfile')->name('password.updateProfile');
    Route::post('profile/destroy', 'ChangePasswordUserController@destroy')->name('password.destroyProfile');
    Route::get('/home', 'HomeController@index')->name('home');

    // Mahasiswa
    Route::resource('mahasiswas', 'MahasiswaController');

    // prestasi
    Route::delete('prestasis/destroy', 'PrestasiController@massDestroy')->name('prestasis.massDestroy');
    Route::post('prestasis/media', 'PrestasiController@storeMedia')->name('prestasis.storeMedia');
    Route::post('prestasis/ckmedia', 'PrestasiController@storeCKEditorImages')->name('prestasis.storeCKEditorImages');
    Route::resource('prestasis', 'PrestasiController');

    Route::get('frontend/profile', 'ProfileController@index')->name('profile.index');
    Route::post('frontend/profile', 'ProfileController@update')->name('profile.update');
    Route::post('frontend/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
    Route::post('frontend/profile/password', 'ProfileController@password')->name('profile.password');
});
