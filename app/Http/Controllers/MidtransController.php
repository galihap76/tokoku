<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BeliProdukModel;
use App\Models\PembayaranModel;
use App\Models\ProdukModel;
use App\Models\User;
use App\Mail\MailProdukBeli;
use Illuminate\Support\Facades\Mail;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        $tanggal_saat_ini = date('Y-m-d');
        $tipePembayaran = $request->payment_type;
        $total = $request->gross_amount;
        $order_id = $request->order_id;

        if ($hashed === $request->signature_key) {
            if ($request->transaction_status == "capture" || $request->transaction_status == "settlement") {
                if ($request->fraud_status == "accept") {
                    $pembayaranProduk = PembayaranModel::create([
                        'total' => $total,
                        'metode' => $tipePembayaran,
                        'order_id' => $order_id
                    ]);

                    BeliProdukModel::where('order_id', $order_id)
                        ->update(['status' => 'success', 'tanggal_transaksi' => $tanggal_saat_ini]);

                    $detail = BeliProdukModel::where('order_id', $order_id)->first();
                    $produk = ProdukModel::find($detail->produk_id);
                    $user = User::find($detail->user_id);

                    Mail::to($user->email)->send(new MailProdukBeli(
                        $user->name,
                        $produk->nama,
                        $produk->deskripsi,
                        $pembayaranProduk->total,
                        $order_id
                    ));
                }
            } else if ($request->transaction_status == "deny") {
                BeliProdukModel::where('order_id', $order_id)
                    ->update(['status' => 'deny']);
            }
        }
    }
}
