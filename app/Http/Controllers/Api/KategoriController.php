<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Validator;
class KategoriController extends Controller
{
    public function index() {
        $kategori = Kategori::all();
        return response()->json([
            'status' => true, 
            'data' => $kategori
        ], 200);
    }

    public function store(Request $request) {
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

        return response()->json([
            'status' => true, 
            'message' => 'Kategori berhasil ditambahkan', 
            'data' => $kategori
        ], 201);
    }

    public function update(Request $request, $id) {
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

        return response()->json([
            'status' => true, 
            'message' => 'Kategori berhasil diupdate', 
            'data' => $kategori
        ], 200);
    }

    public function destroy($id) {
        $kategori = Kategori::find($id);
        if (!$kategori) {
            return response()->json([
                'status' => false, 
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }
        $kategori->delete();
        return response()->json([
            'status' => true, 
            'message' => 'Kategori berhasil dihapus'
        ], 200);
    }
}
