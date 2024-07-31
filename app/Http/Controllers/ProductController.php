<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use Illuminate\Http\Request;
use App\Models\ProdukModel;
use App\Models\User;
use App\Models\BeliProdukModel;
use App\Models\ScreenshotsProdukModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    protected $messages = [
        'nama.required' => 'Nama tidak boleh kosong.',
        'deskripsi.required' => 'Deskripsi tidak boleh kosong.',
        'status.required' => 'Status tidak boleh kosong.',
        'harga.required' => 'Harga tidak boleh kosong.',
        'harga.numeric' => 'Inputan harga harus berupa angka.',
        'harga.max_digits' => 'Nominal harga tidak boleh lebih dari 10 digit.',
        'file.required' => 'File zip harus di upload.',
        'file.extensions' => 'File yang Anda upload tidak valid.',
        'file.mimetypes' => 'File yang Anda upload tidak valid.'
    ];

    protected function setSessionFlash($detectMessage, $message)
    {
        Session::flash($detectMessage, $message);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = session('id');
        $role = User::find($user_id);

        if ($role->role_id == 1) {
            $semuaProduk = ProdukModel::all();
        } else if ($role->role_id == 2) {
            $produkCustomer = ProdukModel::select(
                'tbl_produk.id AS id_produk',
                'tbl_produk.nama AS nama_produk',
                'tbl_produk.deskripsi AS deskripsi_produk',
                'tbl_produk.harga AS harga_produk',
                'tbl_produk.status AS status_produk',
                'tbl_produk.created_at AS tanggal_buat',
                'tbl_produk.updated_at AS tanggal_ubah',
                'tbl_beli_produk.status AS status_beli',
                'tbl_beli_produk.order_id AS order_id'
            )
                ->leftJoin('tbl_beli_produk', function ($join) use ($user_id) {
                    $join->on('tbl_produk.id', '=', 'tbl_beli_produk.produk_id')
                        ->where('tbl_beli_produk.user_id', '=', $user_id);
                })
                ->leftJoin('users', 'users.id', '=', 'tbl_beli_produk.user_id')
                ->get();
        }

        return view('produk.index', ($role->role_id == 1 ? compact('semuaProduk') : compact('produkCustomer')));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $rules = [
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric|max_digits:10',
            'status' => 'required',
            'file' => 'required|mimetypes:application/zip|extensions:zip'
        ];

        $validator = Validator::make($request->all(), $rules, $this->messages);

        if ($validator->fails()) {
            return redirect('/menu_produk' . '/' . 'create')
                ->withErrors($validator)
                ->withInput();
        } else {

            $dataRequests = [
                $request->input('nama'),
                $request->input('deskripsi'),
                $request->input('harga'),
                $request->input('status'),
                $request->file('file')
            ];

            $file = $dataRequests[4];
            $fileName = $file->getClientOriginalName();
            $destinationPath = public_path('assets');

            if (file_exists($destinationPath . '/' . $fileName)) {
                $this->setSessionFlash('error', 'File zip yang Anda upload sudah ada.');
                return redirect()->back()->withInput();
            } else {
                ProdukModel::create([
                    'nama' => $dataRequests[0],
                    'deskripsi' => $dataRequests[1],
                    'harga' => $dataRequests[2],
                    'status' => $dataRequests[3],
                    'file' => $fileName
                ]);

                $file->move($destinationPath, $fileName);
                $this->setSessionFlash('success', 'Data produk telah berhasil di tambahkan.');
                return redirect('/menu_produk');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $produkScreenshots = ScreenshotsProdukModel::where('produk_id', $id)->first();

        if ($produkScreenshots) {
            $directory = public_path('assets/' . $produkScreenshots->folder);
            $ImagesArray = [];
            $dir_contents = scandir($directory);
            $file_display = ['jpg', 'jpeg', 'png'];

            foreach ($dir_contents as $file) {
                $file_type = pathinfo($file, PATHINFO_EXTENSION);
                if (in_array($file_type, $file_display) == true) {
                    $ImagesArray[] = $file;
                }
            }

            $getFiles = $ImagesArray;
            $folderExtract = $produkScreenshots->folder;

            return view('produk.show', compact('getFiles', 'folderExtract'));
        } else {
            $msg = (Auth::user()->role_id == 1 ? 'Upload zip terlebih dahulu yang berisi file screenshots.'
                : 'Admin belum melakukan upload screenshots.');
            $this->setSessionFlash('error', $msg);
            return redirect('/menu_produk');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = ProdukModel::find($id);
        return view('produk.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $rules = [
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric|max_digits:10',
            'status' => 'required',
            'file' => 'mimetypes:application/zip|extensions:zip'
        ];

        $validator = Validator::make($request->all(), $rules, $this->messages);

        if ($validator->fails()) {
            return redirect('/menu_produk' . '/' . $id . '/' . 'edit')
                ->withErrors($validator)
                ->withInput();
        } else {

            $updateProduct = ProdukModel::find($id);
            $updateProduct->nama = $request->input('nama');
            $updateProduct->deskripsi = $request->input('deskripsi');
            $updateProduct->harga = $request->input('harga');
            $updateProduct->status = $request->input('status');

            if ($request->hasFile('file')) {

                // Hapus file lama jika ada
                if ($updateProduct->file) {
                    $oldFilePath = public_path('assets/' . $updateProduct->file);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file = $request->file('file');
                $fileName = $file->getClientOriginalName();
                $destinationPath = public_path('assets');
                $file->move($destinationPath, $fileName);
                $updateProduct->file = $fileName;
            }

            $updateProduct->save();

            $this->setSessionFlash('success', 'Data produk telah berhasil di update.');
            return redirect('/menu_produk');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = ProdukModel::find($id);
        $pathfile = public_path('assets/' . $produk->file);

        if (file_exists($pathfile)) {
            unlink($pathfile);
            $produk->delete();
            $this->setSessionFlash('success', 'Data produk berhasil di hapus.');
            return redirect('/menu_produk');
        } else {
            $this->setSessionFlash('error', 'Data produk gagal di hapus.');
            return redirect('/menu_produk');
        }
    }

    public function beli(string $id, Request $request)
    {

        $idCustomer = $request->session()->get('id');
        $produk = ProdukModel::find($id);

        if (!$produk) {
            return redirect('/menu_produk');
        } else {

            $detailStatusBeli = BeliProdukModel::where('produk_id', $id)
                ->where('status', 'success')
                ->where('user_id', $idCustomer)
                ->first();

            if ($detailStatusBeli) {
                return redirect('/menu_produk');
            } else {
                $user = CustomerModel::where('user_id', $idCustomer)->first();
                return view('produk.beli', compact('produk', 'user'));
            }
        }
    }

    public function proses_checkout(Request $request)
    {

        $qty = $request->input('qty');
        $harga = $request->input('harga');
        $idProduk = $request->input('id');
        $idCustomer = $request->session()->get('id');
        $hapusKoma = str_replace('.', '', $harga);
        $nilaiHarga = intval($hapusKoma);

        $min = 100000; // Nilai minimum 6 digit
        $max = 999999; // Nilai maksimum 6 digit
        $order_id = rand($min, $max);
        $produk = ProdukModel::find($idProduk);

        if ($qty > 1 || $qty <= 0 || $nilaiHarga != $produk->harga) {
            $this->setSessionFlash('error', 'Proses beli produk tidak valid. Harap coba lagi.');
            return redirect()->back();
        } else {
            $beliProduk = BeliProdukModel::create([
                'qty' => $qty,
                'status' => 'pending',
                'order_id' => $order_id,
                'produk_id' => $idProduk,
                'user_id' => $idCustomer
            ]);

            $this->setSessionFlash('success', 'Pilih metode pembayaran yang tersedia.');
            return redirect('/metode_pembayaran' . '/' . $beliProduk->order_id);
        }
    }

    public function produk_terjual()
    {
        $produk = ProdukModel::withSum('produk_terjual', 'jumlah_terjual')
            ->get()
            ->filter(function ($item) {
                return $item->produk_terjual_sum_jumlah_terjual > 0;
            });

        return view('produk.produk_terjual', compact('produk'));
    }

    public function download_produk(string $id_produk)
    {

        $user_id = session('id');
        $detail_produk_beli =  BeliProdukModel::where('produk_id', $id_produk)
            ->where('user_id', $user_id)
            ->first();

        if ($detail_produk_beli) {
            $pathfile = public_path('assets/' . $detail_produk_beli->produk->file);

            if (file_exists($pathfile)) {
                $headers = array(
                    'Content-Type: application/zip',
                );

                return response()->download($pathfile, $detail_produk_beli->produk->file, $headers);
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }
}
