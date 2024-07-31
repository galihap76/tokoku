<?php

namespace App\Http\Controllers;

use App\Models\BeliProdukModel;
use App\Models\ProdukModel;
use App\Models\User;
use App\Models\CustomerModel;
use App\Models\PembayaranModel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PembayaranController extends Controller
{

    public function __construct()
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
    }

    public function index()
    {
        $id = session('id');
        $produk = ProdukModel::withWhereHas('produk_beli', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->get();

        return view('pembayaran.bukti_pembayaran', compact('produk'));
    }

    public function metode_pembayaran(Request $request, string $order_id)
    {
        $id = session('id');
        $beli_produk = BeliProdukModel::where('order_id', $order_id)->first();
        $produk = ProdukModel::find($beli_produk->produk_id);
        $user = User::find($id);
        $nomorTeleponCustomer = CustomerModel::where('user_id', $user->id)->first();

        if ($beli_produk->status == 'success') {
            return redirect('/bukti_pembayaran');
        } else {

            $items = array(
                array(
                    'id'       => $produk->id,
                    'price'    => $produk->harga,
                    'quantity' => $beli_produk->qty,
                    'name'     => $produk->nama
                )
            );

            $params = array(
                'item_details'  => $items,
                'transaction_details' => array(
                    'order_id' => $beli_produk->order_id,
                    'gross_amount' => $produk->harga,
                ),
                'customer_details' => array(
                    'first_name' => $user->name,
                    'phone' => $nomorTeleponCustomer->nomor_telepon,
                )
            );

            $pathId = $beli_produk->order_id;
            $orderIdProduk = $beli_produk->order_id;
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            return view('pembayaran.metode_pembayaran', compact('produk', 'snapToken', 'pathId', 'orderIdProduk', 'user', 'nomorTeleponCustomer'));
        }
    }

    public function download_bukti_pembayaran(string $order_id)
    {
        $id = session('id');
        $user = User::find($id);
        $pembayaran = PembayaranModel::where('order_id', $order_id)->first();
        $produk = ProdukModel::withWhereHas('produk_beli', function ($query) use ($order_id) {
            $query->where('order_id', $order_id);
        })->get();

        $invoice = 'invoice-' . $pembayaran->order_id . '.pdf';
        $pdf = Pdf::loadView('pembayaran.download_bukti_pembayaran', compact('user', 'produk', 'pembayaran'));
        return $pdf->download($invoice);
    }
}
