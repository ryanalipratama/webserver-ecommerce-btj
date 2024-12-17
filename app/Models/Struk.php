<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;
use App\Models\User;

class Struk extends Model
{
    use HasFactory;

    protected $fillable = [
        'tgl',
        'user_id',
        'name',
        'email',
        'telepon',
        'alamat',
        'produk_id',
        'nama_produk',
        'harga_produk',
        'qty',
        'jasa_pengiriman',
        'biaya_pengiriman',
        'total_harga',
        'status',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
    
}
