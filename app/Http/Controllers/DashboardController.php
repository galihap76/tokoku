<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BeliProdukModel;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $hari_ini = date('Y-m-d');
        $total_order_hari_ini = $this->getTotalOrderHariIni($hari_ini);
        $total_penjualan_hari_ini = $this->getTotalPenjualanHariIni($hari_ini);
        $total_barang_terjual_hari_ini = $this->getTotalBarangTerjualHariIni($hari_ini);
        $nama_order_hari_ini = $this->getNamaOrderHariIni($hari_ini);

        return view('dashboard.index', compact(
            'total_order_hari_ini',
            'total_penjualan_hari_ini',
            'total_barang_terjual_hari_ini',
            'nama_order_hari_ini'
        ));
    }

    protected function getTotalOrderHariIni($hari_ini)
    {
        $total = BeliProdukModel::where('tanggal_transaksi', $hari_ini)->count();
        return $total;
    }

    protected function getTotalPenjualanHariIni($hari_ini)
    {
        $totalCollection = BeliProdukModel::withSum(['pembayaran' => function ($query) use ($hari_ini) {
            $query->whereDate('tanggal_transaksi', $hari_ini);
        }], 'total')->get();

        // Mengambil jumlah total dari koleksi
        $total = $totalCollection->sum('pembayaran_sum_total');

        // Mengembalikan hasil format Rupiah
        return number_format($total, 0, ',', '.');
    }

    protected function getTotalBarangTerjualHariIni($hari_ini)
    {
        $qty = BeliProdukModel::where('status', 'success')
            ->whereDate('tanggal_transaksi', $hari_ini)
            ->sum('qty');

        return $qty;
    }

    protected function getNamaOrderHariIni($hari_ini)
    {
        $orders = User::withWhereHas('order_details', function ($query) use ($hari_ini) {
            $query->whereDate('tanggal_transaksi', $hari_ini);
        })->get();

        return $orders;
    }
}
