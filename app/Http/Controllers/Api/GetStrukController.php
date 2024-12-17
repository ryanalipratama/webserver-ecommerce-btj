<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controllers;
use App\Models\User;
Use App\Models\Produk;
use App\Models\Struk;

class GetStrukController extends Controller
{
    public function getStruk()
    {
        $getstruk = Struk::get();

        return view('getstruk', compact('getstruk'));
    }
}