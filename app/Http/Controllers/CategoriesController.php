<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CategoryModel::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'description' => 'required',
            'image' => 'extensions:jpeg,jpg,png|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max' => 'Nama kategori maksimal 100 karakter.',
            'description.required' => 'Deskripsi kategori wajib diisi.',
            'image.extensions' => 'File gambar kategori harus berupa file jpeg, jpg, atau png.',
            'image.mimes' => 'File gambar kategori harus berupa file jpeg, jpg, atau png.',
            'image.max' => 'File gambar kategori maksimal 2MB.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {

            // Kalau ada file gambar
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $fileName = Str::random(20) . '.' . $extension;

                // Simpan file ke storage/app/public/images
                Storage::disk('public')->putFileAs('images', $image, $fileName);
            }

            CategoryModel::create([
                'name' => trim($request->input('name')),
                'description' => trim($request->input('description')),
                'image' => ($request->hasFile('image') ? 'images/' . $fileName : null)
            ]);

            Session::flash('success', 'Kategori produk berhasil ditambahkan.');
            return redirect('/categories-menu');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = CategoryModel::findOrFail($id);

        return view('categories.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'description' => 'required',
            'image' => 'extensions:jpeg,jpg,png|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max' => 'Nama kategori maksimal 100 karakter.',
            'description.required' => 'Deskripsi kategori wajib diisi.',
            'image.extensions' => 'File gambar kategori harus berupa file jpeg, jpg, atau png.',
            'image.mimes' => 'File gambar kategori harus berupa file jpeg, jpg, atau png.',
            'image.max' => 'File gambar kategori maksimal 2MB.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {

            $category = CategoryModel::find($id);

            $category->name = trim($request->input('name'));
            $category->description = trim($request->input('description'));

            // Kalau ada file gambar
            if ($request->hasFile('image')) {

                // Hapus file lama dari storage (jika ada)
                if (!empty($category->image) && Storage::disk('public')->exists($category->image)) {
                    Storage::disk('public')->delete($category->image);
                }

                // Simpan file baru
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $fileName = Str::random(20) . '.' . $extension;

                // Simpan file ke storage/app/public/images
                Storage::disk('public')->putFileAs('images', $image, $fileName);

                // Simpan hanya nama file ke database
                $category->image = 'images/' . $fileName;
            }

            $category->save();

            Session::flash('success', 'Berhasil update kategori produk.');
            return redirect('/categories-menu');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = CategoryModel::findOrFail($id);

        // Hapus file lama dari storage (jika ada)
        if (!empty($category->image) && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $replaceStrName = ucwords(str_replace('-', ' ', $category->name));
        $msg = "Berhasil melakukan hapus kategori " . "<strong>" . $replaceStrName . "</strong>" . ".";

        // Hapus record dari database
        $category->delete();

        Session::flash('success', $msg);
        return redirect('/categories-menu');
    }
}
