<?php

namespace App\Http\Controllers;

use App\Models\ProdukModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ScreenshotsProdukModel;
use ZipArchive;

class PengaturanController extends Controller
{
    public function index()
    {
        return view('pengaturan.ganti_password');
    }

    public function proses_ganti_password(Request $request)
    {

        $password_baru = $request->input('password_baru');
        $konfirmasi_password_baru = $request->input('konfirmasi_password_baru');

        $rules = [
            'password_baru' => 'required|min:10',
            'konfirmasi_password_baru' => 'required'
        ];

        $messages = [
            'password_baru.required' => 'Password baru harus di isi.',
            'password_baru.min' => 'Password baru setidaknya minimal 10 karakter.',
            'konfirmasi_password_baru.required' => 'Konfirmasi password harus di isi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('/ganti_password')
                ->withErrors($validator)
                ->withInput();
        } else if ($password_baru != $konfirmasi_password_baru) {
            Session::flash('error', 'Mohon maaf konfirmasi password tidak sesuai.');
            return redirect('/ganti_password');
        } else {

            $id = $request->session()->get('id');
            $passwordHash = Hash::make($password_baru);
            User::where('id', $id)
                ->update(['password' => $passwordHash]);

            Session::flash('success', 'Password lama berhasil di ganti.');
            return redirect('/ganti_password');
        }
    }

    public function extract_screenshots()
    {
        $produk = ProdukModel::all();
        return view('pengaturan.extract_screenshots', compact('produk'));
    }

    public function proses_extract_screenshots(Request $request)
    {
        $rules = [
            'produk_id' => 'required|integer',
            'nama_produk' => 'required',
            'file' => 'required|mimetypes:application/zip|extensions:zip'
        ];

        $messages = [
            'nama_produk.required' => 'Nama produk harus di isi.',
            'file.required' => 'File ZIP harus di upload.',
            'file.mimetypes' => 'File ZIP tidak valid.',
            'file.extensions' => 'File ZIP tidak valid.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('/extract_screenshots')
                ->withErrors($validator)
                ->withInput();
        } else {
            $basePath = public_path('assets');
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $folderExtract = 'extract_' . pathinfo($fileName, PATHINFO_FILENAME) . '_' . time();
            $newDirPath = $basePath . '/' . $folderExtract;

            if (!file_exists($newDirPath)) {
                mkdir($newDirPath);
                $file->move($newDirPath, $fileName);

                // Extract zip file
                $zip = new ZipArchive();
                $zipFilePath = $newDirPath . '/' . $fileName;

                if ($zip->open($zipFilePath) === TRUE) {
                    $zip->extractTo($newDirPath);
                    $zip->close();

                    // Hapus file zip setelah di extract
                    $hapusFileZip = $basePath . '/' . $folderExtract . '/' . $fileName;
                    unlink($hapusFileZip);

                    ScreenshotsProdukModel::create([
                        'folder' => $folderExtract,
                        'produk_id' => $request->input('produk_id')
                    ]);

                    Session::flash('success', 'Berhasil melakukan extract file ZIP.');
                    return redirect('/extract_screenshots');
                } else {
                    Session::flash('error', 'Gagal melakukan extract file ZIP.');
                    return redirect('/extract_screenshots');
                }
            }
        }
    }
}
