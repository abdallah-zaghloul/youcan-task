<?php /** @noinspection DuplicatedCode */

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
use Modules\Persona\Http\Controllers\Web\Admin\ConfirmPasswordController;
use Modules\Persona\Http\Controllers\Web\Admin\ForgotPasswordController;
use Modules\Persona\Http\Controllers\Web\Admin\HomeController;
use Modules\Persona\Http\Controllers\Web\Admin\LoginController;
use Modules\Persona\Http\Controllers\Web\Admin\RegisterController;
use Modules\Persona\Http\Controllers\Web\Admin\ResetPasswordController;
use Modules\Persona\Http\Controllers\Web\Admin\VerificationController;

/* |--------------------------------------------------------------------------
   | auth:adminWeb Routes
   |--------------------------------------------------------------------------
   | this override auth:adminWeb routes of default app web guard
   | names of routes is the same as the default web auth:adminWeb routes
*/


/* prefix /admin registered at routeServiceProvider */

Route::group([
    'as'=> 'adminWeb.'
],function (){

    /* home */
    Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth:adminWeb','verified:adminWeb.verification.notice');

    /* login */
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest:adminWeb');
    Route::post('login', [LoginController::class, 'login'])->middleware('guest:adminWeb');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    /* register */
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest:adminWeb');
    Route::post('register', [RegisterController::class, 'register'])->middleware('guest:adminWeb');

    /* password-confirm */
    Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm')->middleware('auth:adminWeb');
    Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm'])->middleware('auth:adminWeb');

    /* password-forgot */
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

    /* password-reset */
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    /* verify-email */
    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice')->middleware('auth:adminWeb');
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:adminWeb','signed','throttle:6,1');
    Route::post('email/verify/resend', [VerificationController::class,'resend'])->name('verification.resend')->middleware('auth:adminWeb','throttle:6,1');
});
