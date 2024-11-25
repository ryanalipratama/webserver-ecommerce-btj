<?php

namespace App\Http\Controllers\Api;

use App\Models\Banner;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class PageController extends Controller
{
    public function home()
    {
        $banner = Banner::all();
        $produk = Produk::take(7)->get();
        $kategori = Kategori::all();
        return view('pengunjung.home', compact('banner', 'produk', 'kategori'));
    }

    public function aboutus()
    {
        return view('pengunjung.aboutus');
    }

    public function produk()
    {
        $produk = Produk::all();
        $kategori = Kategori::all();
        return view ('pengunjung.produk', compact('produk', 'kategori'));
    }

    
}