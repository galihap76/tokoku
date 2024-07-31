<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CustomerModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{

    public function index($id)
    {
        $user = User::find($id);
        return view('customer.index', compact('user'));
    }

    public function update_profile(Request $request)
    {

        $checkEmail = $request->session()->get('email');
        $customer = User::where('email', $checkEmail)->first();
        $nomorTeleponCustomer = CustomerModel::where('user_id', $customer->id)->first();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'nomor_telepon' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Profile Anda gagal di ubah.');
        } else if (
            $request->input('name') == $customer->name
            && $request->input('email') == $customer->email
            && $request->input('nomor_telepon') == $nomorTeleponCustomer->nomor_telepon
        ) {
            Session::flash('warning', 'Anda tidak memperbarui apapun.');
            return redirect('profile_customer/' . $customer->id);
        } else if ($request->input('email') == $checkEmail) {

            $customer->update(['name' => $request->input('name')]);
            $nomorTeleponCustomer->update(['nomor_telepon' => $request->input('nomor_telepon')]);

            Session::flash('success', 'Profile Anda berhasil di update.');
            return redirect('profile_customer/' . $customer->id);
        } else {
            return redirect()->back()->with('error', 'Profile Anda gagal di ubah.');
        }
    }
}
