<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Middleware\OnlyCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->middleware('prevent.customer');
    });

    Route::controller(CustomerController::class)->group(function () {
        Route::get('/profile_customer/{id}', 'index')->middleware('check.id.customer');
        Route::post('/update_profile', 'update_profile');
    });

    Route::controller(PengaturanController::class)->group(function () {
        Route::get('/ganti_password', 'index');
        Route::post('/proses_ganti_password', 'proses_ganti_password');
        Route::get('/extract_screenshots', 'extract_screenshots')->middleware('prevent.customer');
        Route::post('/proses_extract_screenshots', 'proses_extract_screenshots')->middleware('prevent.customer');
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('/produk_terjual', 'produk_terjual')->middleware('prevent.customer');
        Route::get('/beli/{id}', 'beli')->name('beli')->middleware('only.customer');
        Route::post('/proses_checkout', 'proses_checkout');
        Route::get('/download_produk/{id_produk}', 'download_produk')->name('download_produk')->middleware('reset.headers');
    });

    Route::resource('menu_produk', ProductController::class);

    Route::controller(PembayaranController::class)->group(function () {
        Route::middleware([OnlyCustomer::class])->group(function () {
            Route::get('/download_bukti_pembayaran/{order_id}', 'download_bukti_pembayaran')->name('download_bukti_pembayaran');
            Route::get('/bukti_pembayaran', 'index');
            Route::get('/metode_pembayaran/{order_id}', 'metode_pembayaran')->name('metode_pembayaran');
        });
    });

    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::middleware('guest')->group(function () {

    Route::get('/lupa_password', function () {
        return view('auth.lupa_password');
    })->name('password.request');

    Route::post('/lupa_password', function (Request $request) {

        function statusFunction($status)
        {
            return $status;
        }

        $request->validate(['email' => 'required|email'], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __(statusFunction('Link reset password telah berhasil dikirim melalui email. Silakan periksa email Anda.'))])
            : back()->withErrors(['email' => __(statusFunction('Email tidak ada.'))]);
    })->name('password.email');

    Route::get('/reset_password/{token}', function (string $token) {
        return view('auth.reset_password', ['token' => $token]);
    })->name('password.reset');

    Route::post('/reset_password', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:10|confirmed',
            'password_confirmation' => 'required',
        ], [
            'password.required' => 'Password harus di isi.',
            'password.min' => 'Password setidaknya minimal 10 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password_confirmation.required' => 'Konfirmasi password harus di isi.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    })->name('password.update');

    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'index')->name('login');
        Route::get('/pendaftaran', 'pendaftaran');
        Route::get('/redirect', 'redirect');
        Route::get('/auth/google/callback', 'callback');

        Route::post('/proses_login', 'proses_login')->middleware('throttle:limit_login');
        Route::post('/proses_pendaftaran', 'proses_pendaftaran');
        Route::post('/proses_lupa_password', 'proses_lupa_password');
    });
});

Route::resource('menu_produk', ProductController::class, ['except' => ['index', 'show']])->middleware('prevent.customer');
