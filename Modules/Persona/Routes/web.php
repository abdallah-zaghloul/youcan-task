<?php

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

use Illuminate\Support\Facades\Route;
use Modules\Persona\Http\Controllers\Web\User\ConfirmPasswordController;
use Modules\Persona\Http\Controllers\Web\User\ForgotPasswordController;
use Modules\Persona\Http\Controllers\Web\User\HomeController;
use Modules\Persona\Http\Controllers\Web\User\LoginController;
use Modules\Persona\Http\Controllers\Web\User\RegisterController;
use Modules\Persona\Http\Controllers\Web\User\ResetPasswordController;
use Modules\Persona\Http\Controllers\Web\User\VerificationController;
use Modules\Persona\Http\Controllers\Web\WelcomeController;

/* |--------------------------------------------------------------------------
   | Authentication Routes
   |--------------------------------------------------------------------------
   | this override authentication routes of default app web guard
   | names of routes is the same as the default web auth routes
*/


/* override default web auth routes */

Route::group([
    'prefix'=> '/'

],function (){
    /* welcome */
    Route::get('/', WelcomeController::class);

    /* home */
    Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('auth','verified');

    /* login */
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
    Route::post('login', [LoginController::class, 'login'])->middleware('guest');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    /* register */
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
    Route::post('register', [RegisterController::class, 'register'])->middleware('guest');

    /* password-confirm */
    Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm')->middleware('auth');
    Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm'])->middleware('auth');

    /* password-forgot */
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

    /* password-reset */
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    /* verify-email */
    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice')->middleware('auth');
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify')->middleware('auth','signed','throttle:6,1');
    Route::post('email/verify/resend', [VerificationController::class,'resend'])->name('verification.resend')->middleware('auth','throttle:6,1');
});
