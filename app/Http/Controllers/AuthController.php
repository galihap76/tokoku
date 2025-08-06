<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AuthController extends Controller
{

    protected function setIconProfile()
    {
        $sourcePath = public_path('assets/img/default');
        $destinationPath = 'default';

        // Ambil semua file dari public/assets/img/default/
        $files = File::files($sourcePath);

        // Copy semua file ke storage/app/public/default/
        foreach ($files as $file) {
            $filename = $file->getFilename();

            $targetPath = $destinationPath . '/' . $filename;

            // Dan simpan ke file pada storage/app/public/default/ jika file belum ada 
            if (!Storage::disk('public')->exists($targetPath)) {
                Storage::disk('public')->putFileAs($destinationPath, $file, $filename);
            }
        }

        // Ambil semua file dari storage/app/public/default/
        $storageFiles = Storage::disk('public')->files($destinationPath);

        // Filter hanya gambar
        $icons = array_filter($storageFiles, function ($file) {
            return in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png']);
        });

        // Pilih satu acak
        $randomIcon = $icons[array_rand($icons)];

        return $randomIcon;
    }

    public function index()
    {
        return view('auth.login');
    }

    public function login_process(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Email tidak valid.',
            'password.required' => 'Password tidak boleh kosong.'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->has('remember') ? true : false;

        if ($validator->fails()) {
            return redirect('/login')
                ->withErrors($validator)
                ->withInput();
        } else if (Auth::attempt(
            [
                'email' => $email,
                'password' => $password
            ],
            $remember
        )) {
            $request->session()->regenerate();

            // Session::flash('success', 'Selamat datang di ' . env('APP_NAME') . '!');
            return redirect('/dashboard');
        } else {
            Session::flash('error', 'Email atau password salah. Harap coba lagi.');
            return redirect('/login')->withInput();
        }
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function registration_process(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users|email',
            'password' => 'required|min:10|confirmed',
            'password_confirmation' => 'required'
        ], [
            'email.required' => 'Email tidak boleh kosong.',
            'email.unique' => 'Email tidak valid.',
            'email.email' => 'Email tidak valid.',
            'password.required' => 'Password tidak boleh kosong.',
            'password.min' => 'Password minimal 10 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password_confirmation.required' => 'Konfirmasi password tidak boleh kosong.'
        ]);

        if ($validator->fails()) {
            return redirect('/registration')
                ->withErrors($validator)
                ->withInput();
        } else {

            $user = User::create([
                'name' => trim(ucwords($request->input('name'))),
                'email' => trim($request->input('email')),
                'password' => Hash::make($request->input('password')),
                'profile_picture' => $this->setIconProfile(),
                'role' => 'user'
            ]);

            event(new Registered($user));
            Auth::login($user);
            return redirect('/email/verify');
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        Session::flash('success', 'Anda berhasil logout.');

        return redirect('/login');
    }
}
