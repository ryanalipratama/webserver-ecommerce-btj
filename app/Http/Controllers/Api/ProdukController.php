<?php

namespace App\Http\Controllers\Api;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use File;

class ProdukController extends Controller
{
    // index
    public function index(){
        $produk = Produk::with('kategori')->get();
        return response()->json([
            'status' => true, 
            'data' => $produk
        ], 200);
    }

    public function show($id){
        $produk = Produk::with('kategori')->find($id);
        if(!$produk){
            return response()->json([
                'status' => false, 
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }
        return response()->json([
            'status' => true, 
            'data' => $produk
        ], 200);
    }

    public function update(Request $request, $id){
        \Log::info($request->all());
        $validator = Validator::make($request->all(),[
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'nullable|exists:kategori,id',
            'harga' => 'required|numeric', 
            'deskripsi' => 'nullable|string',
            'jumlah' => 'required|numeric',
            'gambar' =>  'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            \Log::info('Validation failed:', $validator->errors()->toArray());
            return response()->json([
                'status' => false, 
                'message' => 'Validation error', 
                'errors' => $validator->errors()
            ], 422);
        }

        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json([
                'status' => false, 
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        \Log::info('Data produk sebelum update:', $produk->toArray());
        // Update data produk
        $produk->nama_produk = $request->nama_produk;
        $produk->kategori_id = $request->kategori_id;
        $produk->harga = $request->harga;
        $produk->deskripsi = $request->deskripsi;
        $produk->jumlah = $request->jumlah;

        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($produk->gambar) {
                $oldImagePath = public_path().'/uploads/produk_image/' . $produk->gambar;
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
            $gambar = $request->file('gambar');
            $nama_gambar = time() . '_' . $gambar->getClientOriginalName(); // Memberi nama unik pada file gambar
            $path = $gambar->move(public_path('uploads/produk_image'), $nama_gambar); // Simpan gambar ke direktori penyimpanan
            $produk->gambar = $nama_gambar;
        }

        $produk->save();
        \Log::info('Data produk setelah update:', $produk->toArray());

        return response()->json([
            'status' => true, 
            'message' => 'Produk berhasil diupdate', 
            'data' => $produk
        ], 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|String|max:255',
            'kategori_id' => 'nullable|exists:kategori,id',
            'harga' => 'required|numeric', 
            'deskripsi' => 'nullable|string',
            'jumlah' => 'required|numeric',
            'gambar' =>  'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, 
                'message' => 'Validation error', 
                'errors' => $validator->errors()
            ], 422);
        }

        // Buat instance baru dari model Produk
        $produk = new Produk();
        $produk->nama_produk = $request->nama_produk;
        $produk->kategori_id = $request->kategori_id;
        $produk->harga = $request->harga;
        $produk->deskripsi = $request->deskripsi;
        $produk->jumlah = $request->jumlah;

        // Proses file gambar jika ada inputan gambar
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $nama_gambar = time() . '_' . $gambar->getClientOriginalName(); // Memberi nama unik pada file gambar
            $path = $gambar->move(public_path('uploads/produk_image'), $nama_gambar); // Simpan gambar ke direktori penyimpanan
            $produk->gambar = 'uploads/produk_image/' . $nama_gambar; // Simpan nama file gambar ke dalam database
        }

        $produk->save();

        return response()->json([
            'status' => true, 
            'message' => 'Produk berhasil ditambahkan', 
            'data' => $produk
        ], 201);
    }

    public function destroy($id) {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json([
                'status' => false, 
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }
        $produk->delete();
        return response()->json([
            'status' => true, 'message' => 
            'Produk berhasil dihapus'
        ], 200);
    }

    public function indexByCategory($kategori_id)
    {
        // Cari semua produk yang memiliki kategori dengan ID yang diberikan
        $produk = Produk::with('kategori')->where('kategori_id', $kategori_id)->get();

        return response()->json([
            'status' => true, 
            'data' => $produk
        ], 200);
    }
}
