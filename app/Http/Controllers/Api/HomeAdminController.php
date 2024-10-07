<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\Validator;

class HomeAdminController extends Controller
{
    public function index(){
        
        $produk = Produk::get();

        return view('index', compact('produk'));
    }

    public function create(){
        return view('create');
    }

    public function store(Request $request){
        \Log::info($request->all());
        $validator = Validator::make($request->all(),[
            'nama_produk' => 'required|String|max:255',
            'kategori_id' => 'nullable|exists:kategori,id',
            'harga' => 'required|numeric', 
            'deskripsi' => 'nullable|string',
            'jumlah' => 'required|numeric',
            'gambar' =>  'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
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

        return redirect()->route('index');
    }

    public function edit(Request $request,$id){
        $produk = Produk::find($id);

        return view('edit', compact('produk'));
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'nama_produk' => 'required|String|max:255',
            'kategori_id' => 'nullable|exists:kategori,id',
            'harga' => 'required|numeric', 
            'deskripsi' => 'nullable|string',
            'jumlah' => 'required|numeric',
            'gambar' =>  'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $produk = Produk::find($id);
        if (!$produk) {
            return redirect()->back()->withErrors(['message' => 'Produk tidak ditemukan.']);
        }

        // Buat instance baru dari model Produk
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

        return redirect()->route('index');
    }

    public function delete(Request $request, $id){
        $produk = Produk::find($id);
        if($produk){
            $produk->delete();
        }
        
        return redirect ()->route('index');
    }
}

