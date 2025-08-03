<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Mail\VerificationNotification;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailVerificationController extends Controller
{
    public function verify(EmailVerificationRequest $request, $id)
    {
        $user = User::find($id);

        if ($user->email_verified_at != '' || $user->email_verified_at != null) {
            return redirect('/dashboard');
        } else {

            $request->fulfill();

            if ($user) {
                Log::info('Berhasil diverifikasi pada user : ' . $user->email);
                Mail::to($user->email)->send(new VerificationNotification(
                    ucwords($user->name)
                ));
            }

            return redirect('/dashboard')->with('verify-successfully', 'Selamat akun Anda berhasil diverifikasi!');
        }
    }
}
