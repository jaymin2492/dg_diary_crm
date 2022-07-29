<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\SchoolTypeController;
use App\Http\Controllers\Admin\SchoolLevelController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\StatusController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RoleUserController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\SchoolContactController;
use App\Http\Controllers\Admin\SchoolNoteController;
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

Auth::routes();

Route::middleware(['auth'])->group(function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
});
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function(){
    Route::resource('school_types', SchoolTypeController::class);
    Route::post('school_types/change_Status', [SchoolTypeController::class, 'change_Status']);
    Route::resource('school_levels', SchoolLevelController::class);
    Route::post('school_levels/change_Status', [SchoolLevelController::class, 'change_Status']);
    Route::resource('countries', CountryController::class);
    Route::post('countries/change_Status', [CountryController::class, 'change_Status']);
    Route::resource('statuses', StatusController::class);
    Route::post('statuses/change_Status', [StatusController::class, 'change_Status']);
    Route::resource('areas', AreaController::class);
    Route::post('areas/change_Status', [AreaController::class, 'change_Status']);
    Route::resource('roles', RoleController::class);
    Route::post('roles/change_Status', [RoleController::class, 'change_Status']);
    Route::resource('role_users', RoleUserController::class);
    Route::post('role_users/change_Status', [RoleUserController::class, 'change_Status']);
    Route::resource('schools', SchoolController::class);
    Route::post('schools/change_Status', [SchoolController::class, 'change_Status']);

    Route::get('school_contacts/{sid}', [SchoolContactController::class, 'index']);
    Route::get('school_contacts/create/{sid}', [SchoolContactController::class, 'create']);
    Route::post('school_contacts/change_Status', [SchoolContactController::class, 'change_Status']);
    Route::resource('school_contacts', SchoolContactController::class);

    Route::get('school_notes/{sid}', [SchoolNoteController::class, 'index']);
    Route::get('school_notes/create/{sid}', [SchoolNoteController::class, 'create']);
    Route::post('school_notes/change_Status', [SchoolNoteController::class, 'change_Status']);
    Route::resource('school_notes', SchoolNoteController::class);
});
Route::group(['prefix' => 'admin', 'middleware' => ['auth','masteruserrole']], function(){
    Route::resource('school_types', SchoolTypeController::class);
    Route::post('school_types/change_Status', [SchoolTypeController::class, 'change_Status']);
    Route::resource('school_levels', SchoolLevelController::class);
    Route::post('school_levels/change_Status', [SchoolLevelController::class, 'change_Status']);
    Route::resource('countries', CountryController::class);
    Route::post('countries/change_Status', [CountryController::class, 'change_Status']);
    Route::resource('statuses', StatusController::class);
    Route::post('statuses/change_Status', [StatusController::class, 'change_Status']);
    Route::resource('areas', AreaController::class);
    Route::post('areas/change_Status', [AreaController::class, 'change_Status']);
    Route::resource('roles', RoleController::class);
    Route::post('roles/change_Status', [RoleController::class, 'change_Status']);
    Route::resource('role_users', RoleUserController::class);
    Route::post('role_users/change_Status', [RoleUserController::class, 'change_Status']);
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function(){
    Route::resource('schools', SchoolController::class);
    Route::post('schools/change_Status', [SchoolController::class, 'change_Status']);
    Route::get('school_contacts/{sid}', [SchoolContactController::class, 'index']);
    Route::get('school_contacts/create/{sid}', [SchoolContactController::class, 'create']);
    Route::post('school_contacts/change_Status', [SchoolContactController::class, 'change_Status']);
    Route::resource('school_contacts', SchoolContactController::class);
    Route::get('school_notes/{sid}', [SchoolNoteController::class, 'index']);
    Route::get('school_notes/create/{sid}', [SchoolNoteController::class, 'create']);
    Route::post('school_notes/change_Status', [SchoolNoteController::class, 'change_Status']);
    Route::resource('school_notes', SchoolNoteController::class);
});