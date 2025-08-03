<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailVerificationController;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Mail\ResetPasswordSuccess;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified');

    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verifikasi telah berhasil dikirim.');
    })->middleware('throttle:3,1')->name('verification.send');

    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/dashboard', [DashboardController::class, 'index']);
});

Route::middleware('guest')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'index')->name('login');
        Route::post('/login-process', 'login_process')->middleware('throttle:4,3');
        Route::get('/registration', 'registration');
        Route::post('/registration-process', 'registration_process')->middleware('throttle:4,3');
    });

    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::post('/forgot-password', function (Request $request) {

        function statusFunction($status)
        {
            return $status;
        }

        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Email tidak valid.'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __(statusFunction('Link reset kata sandi telah berhasil dikirim melalui email. Silakan periksa email Anda.'))])
            : back()->withErrors(['email' => __(statusFunction('Kami tidak bisa menemukan email Anda.'))]);
    })->name('password.email');

    Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    })->middleware('guest')->name('password.reset');

    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:10|confirmed',
            'password_confirmation' => 'required',
        ], [
            'password.required' => 'Password harus di isi.',
            'password.min' => 'Password setidaknya minimal 10 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password_confirmation.required' => 'Konfirmasi password harus di isi.'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));

                // Kirim email ke User setelah password berhasil diubah
                if ($user->role == 'user') {
                    Mail::to($user->email)->send(new ResetPasswordSuccess($user->name));
                }
            }
        );

        return $status === Password::PasswordReset
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    })->name('password.update');
});
