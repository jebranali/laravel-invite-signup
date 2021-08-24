<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

//Auth protected routes.
Route::middleware('auth:sanctum')->group(function () {

    //Get authenticated user
    Route::get('get_user', [\App\Http\Controllers\ProfileController::class,'getUser'])->name('getUser');

    //Update profile
    Route::post('profile_update', [\App\Http\Controllers\ProfileController::class,'profileUpdate'])->name('profilUpdate');

});

//Api authentication
Route::post('/login', [\App\Http\Controllers\UserController::class,'login'])->name('login');

//Invitation routes
Route::post('send_invitation',[\App\Http\Controllers\InvitationController::class,'sendInvitation'])
    ->name('sendInvitation');

//Registration route
Route::post('registration',[\App\Http\Controllers\UserController::class,'register'])
    ->name('register');

//Verify pin code
Route::post('verify_pin',[\App\Http\Controllers\UserController::class,'verifyPin'])
    ->name('verifyPin');
