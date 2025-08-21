<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\CategorySubMenuModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CategorySubMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CategoryModel::with('sub_categories')->get();

        return view('sub_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CategoryModel::select(
            'categories.id',
            'categories.name'
        )->get();

        return view('sub_categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|max:100',
            'label'       => 'required',
            'description' => 'required',
            'thumbnail'   => 'extensions:jpeg,jpg,png|mimes:jpeg,png,jpg|max:2048',
            'drive'       => 'url',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'status'      => 'required|in:public,draft',
            'category_id' => 'required|exists:categories,id',
        ], [
            'name.required'        => 'Nama sub kategori wajib diisi.',
            'name.max'             => 'Nama sub kategori maksimal 100 karakter.',
            'label.required'       => 'Label wajib diisi.',
            'description.required' => 'Deskripsi wajib diisi.',
            'thumbnail.extensions' => 'File thumbnail harus berupa jpeg, jpg, atau png.',
            'thumbnail.mimes'      => 'File thumbnail harus berupa jpeg, jpg, atau png.',
            'thumbnail.max'        => 'Ukuran file thumbnail maksimal 2MB.',
            'drive.url'            => 'Link drive harus berupa URL yang valid.',
            'price.required'       => 'Harga wajib diisi.',
            'price.numeric'        => 'Harga harus berupa angka.',
            'stock.required'       => 'Stok wajib diisi.',
            'stock.integer'        => 'Stok harus berupa angka bulat.',
            'status.required'      => 'Status wajib dipilih.',
            'status.in'            => 'Status hanya boleh public atau draft.',
            'category_id.required' => 'Kategori induk wajib dipilih.',
            'category_id.exists'   => 'Kategori induk tidak ditemukan.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $fileName = null;

            // Kalau ada file thumbnail
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $extension = $thumbnail->getClientOriginalExtension();
                $fileName  = Str::random(20) . '.' . $extension;

                // Simpan file ke storage/app/public/thumbnails
                Storage::disk('public')->putFileAs('thumbnails', $thumbnail, $fileName);
            }

            CategorySubMenuModel::create([
                'name'        => trim($request->input('name')),
                'label'       => trim($request->input('label')),
                'description' => trim($request->input('description')),
                'thumbnail'   => $fileName ? 'thumbnails/' . $fileName : null,
                'drive'       => $request->input('drive'),
                'price'       => $request->input('price'),
                'stock'       => $request->input('stock'),
                'status'      => $request->input('status'),
                'category_id' => $request->input('category_id'),
            ]);

            Session::flash('success', 'Sub kategori produk berhasil ditambahkan.');
            return redirect()->route('categories-submenu.index');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Ambil kategori beserta semua sub kategori terkait
        $subCategory = CategorySubMenuModel::find($id);

        return view('sub_categories.show', compact('subCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $submenu = CategorySubMenuModel::findOrFail($id);
        $categories = CategoryModel::select(
            'categories.id',
            'categories.name'
        )->get();

        return view('sub_categories.edit', compact('submenu', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|max:100',
            'label'       => 'required',
            'description' => 'required',
            'thumbnail'   => 'extensions:jpeg,jpg,png|mimes:jpeg,jpg,png|max:2048',
            'drive'       => 'url',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'status'      => 'required|in:public,draft',
            'category_id' => 'required|exists:categories,id',
        ], [
            'name.required'        => 'Nama sub kategori wajib diisi.',
            'name.max'             => 'Nama sub kategori maksimal 100 karakter.',
            'label.required'       => 'Label wajib diisi.',
            'description.required' => 'Deskripsi wajib diisi.',
            'thumbnail.extensions' => 'File thumbnail harus jpeg, jpg, atau png.',
            'thumbnail.mimes'      => 'File thumbnail harus jpeg, jpg, atau png.',
            'thumbnail.max'        => 'Ukuran thumbnail maksimal 2MB.',
            'drive.url'            => 'Link drive harus berupa URL yang valid.',
            'price.required'       => 'Harga wajib diisi.',
            'price.numeric'        => 'Harga harus berupa angka.',
            'stock.required'       => 'Stok wajib diisi.',
            'stock.integer'        => 'Stok harus berupa bilangan bulat.',
            'status.required'      => 'Status wajib dipilih.',
            'status.in'            => 'Status hanya boleh public atau draft.',
            'category_id.required' => 'Kategori induk wajib dipilih.',
            'category_id.exists'   => 'Kategori induk tidak ditemukan.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $submenu = CategorySubMenuModel::findOrFail($id);

        $submenu->name        = trim($request->input('name'));
        $submenu->label       = trim($request->input('label'));
        $submenu->description = trim($request->input('description'));
        $submenu->drive       = $request->input('drive');
        $submenu->price       = $request->input('price');
        $submenu->stock       = $request->input('stock');
        $submenu->status      = $request->input('status');
        $submenu->category_id = $request->input('category_id');

        // Kalau ada file thumbnail baru
        if ($request->hasFile('thumbnail')) {

            // Hapus thumbnail lama kalau ada
            if (!empty($submenu->thumbnail) && Storage::disk('public')->exists($submenu->thumbnail)) {
                Storage::disk('public')->delete($submenu->thumbnail);
            }

            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::random(20) . '.' . $extension;

            Storage::disk('public')->putFileAs('thumbnails', $file, $fileName);

            $submenu->thumbnail = 'thumbnails/' . $fileName;
        }

        $submenu->save();

        Session::flash('success', 'Berhasil update sub kategori produk.');
        return redirect()->route('categories-submenu.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $submenu = CategorySubMenuModel::findOrFail($id);

        // Hapus file lama dari storage (jika ada)
        if (!empty($submenu->thumbnail) && Storage::disk('public')->exists($submenu->thumbnail)) {
            Storage::disk('public')->delete($submenu->thumbnail);
        }

        $replaceStrName = ucwords(str_replace('-', ' ', $submenu->name));
        $msg = "Berhasil melakukan hapus sub kategori " . $replaceStrName . ".";

        // Hapus record dari database
        $submenu->delete();

        Session::flash('success', $msg);
        return redirect()->route('categories-submenu.index');
    }
}
