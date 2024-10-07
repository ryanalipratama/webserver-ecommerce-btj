<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\Validator;


class KategoriAdminController
{
    public function getKategori()
    {
        $kategori = Kategori::get();

        return view('getkategori', compact('kategori'));
    }

    public function createkategori(){
        return view('createkategori');
    }

    public function kategori_store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, 
                'message' => 'Validation error', 
                'errors' => $validator->errors()
            ], 422);
        }

        $kategori = Kategori::create([
            'nama_kategori' => $request->nama_kategori]);

        return redirect()->route('getkategori');
    }

    public function kategori_edit(Request $request,$id){
        $kategori = Kategori::find($id);

        return view('editkategori', compact('kategori'));

    }

    public function kategori_update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, 
                'message' => 'Validation error', 
                'errors' => $validator->errors()
            ], 422);
        }

        $kategori = Kategori::find($id);
        if (!$kategori) {
            return response()->json([
                'status' => false, 
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('getkategori');
    }

    public function kategori_delete($id) {
        $kategori = Kategori::find($id);
        if($kategori){
            $kategori->delete();
        }
        return redirect()->route('getkategori');
    }
}
