<?php

use App\Http\Controllers\Auth;
use App\Http\Controllers\User;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// 認証関連 (ログイン前)
Route::post('/register', [Auth\RegisteredUserController::class, 'store'])->name('register');
Route::post('/login', [Auth\AuthenticatedSessionController::class, 'store'])->name('login');
Route::post('/forgot-password', [Auth\PasswordResetLinkController::class, 'store'])->name('password.email');
Route::post('/reset-password', [Auth\NewPasswordController::class, 'store'])->name('password.store');

Route::middleware('auth')->group(function () {
    // 書籍関連
    // 書籍トップ
    Route::resource('book', User\BookController::class)->only(['index', 'store', 'destroy']);
    // 書籍頁
    Route::resource('book.page', User\PageController::class)->only(['index', 'store', 'destroy']);

    // 作者関連
    Route::resource('author', User\AuthorController::class)->only(['index', 'store', 'destroy']);

    // ユーザ情報編集
    Route::resource('user', User\UserController::class)->only(['store', 'destroy']);

    // 認証関連 (ログイン後)
    Route::get('/verify-email/{id}/{hash}', Auth\VerifyEmailController::class)
                    ->middleware(['signed', 'throttle:6,1'])
                    ->name('verification.verify');

    Route::post('/email/verification-notification', [Auth\EmailVerificationNotificationController::class, 'store'])
                    ->middleware('throttle:6,1')
                    ->name('verification.send');
    Route::post('/logout', [Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

