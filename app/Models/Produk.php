<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Produk;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'nama_produk',
        'kategori_id',
        'harga', 
        'deskripsi',
        'jumlah',
        'gambar'
    ];


    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function struks()
    {
        return $this->hasMany(Struk::class, 'produk_id');
    }
}
