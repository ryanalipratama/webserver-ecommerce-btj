<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;
use App\Models\Produk;
use App\Models\User;
use App\Models\Struk;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Inisialisai konfigurasi midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    // Fungsi untuk membuat transaksi
    public function createTransaction(Request $request)
    {
        // Validasi input data
        $request->validate([
            'user_id' => 'required|integer',
            'name' => 'required|string',
            'email' => 'required|email',
            'telepon' => 'required|string',
            'alamat' => 'required|string',
            'produk_id' => 'required|integer',
            'nama_produk' => 'required|string',
            'harga_produk' => 'required|numeric',
            'qty' => 'required|integer',
            'jasa_pengiriman' => 'required|string',
            
        ]);

        // Hitung total harga
        $totalHarga = $request->harga_produk * $request->qty + 15000;

        // Buat transaksi dan simpan ke database
        $struk = Struk::create([
            'tgl' => now(),
            'user_id' => $request->user_id,
            'name' => $request->name,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'produk_id' => $request->produk_id,
            'nama_produk' => $request->nama_produk,
            'harga_produk' => $request->harga_produk,
            'qty' => $request->qty,
            'jasa_pengiriman' => $request->jasa_pengiriman,
            'biaya_pengiriman' => 15000,
            'total_harga' => $totalHarga,
            'status' => 'pending',
            
        ]);

        $user = auth()->user();
        $customerDetails = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->telepon,
            'address' => $request->alamat,
            'photo_url' => $request->foto_profil,
        ];

        // Detail item yang akan dibeli
        $itemDetails = [
            [
                'id' => $struk->produk_id,
                'price' => $struk->harga_produk,
                'quantity' => $struk->qty,
                'name' => $struk->nama_produk,
            ],
            [
                'id' => 'shipping',
                'price' => 15000,
                'quantity' => 1,
                'name' => 'Shipping Fee: ' . $request->jasa_pengiriman,
            ]
        ];
        
        // Detail Transaksi
        $transactionDetails = [
            'order_id' => $struk->id,
            'gross_amount' => $totalHarga,
        ];

        // Kirim data transaksi ke Midtrans
        $paymentRequest =[
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'item_details' => $itemDetails
        ];

        try {
            // Dapatkan snap token dari Midtrans
            $snapToken = Snap::getSnapToken($paymentRequest);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    // fungsi untuk menangani notifikasi pembayaran dari midtrans
    public function notification(Request $request)
    {
        // Inisialisasi objek notifikasi
        $notification = new Notification();
        $status = $notification->transaction_status;
        $orderId = $notification->order_id;

        // Ambil data struk berdasarkan order_id
        $struk = Struk::find($orderId);
        if (!$struk) {
            return response()->json(['error' => 'Struk not found.'], 404);
        }

        // Update status transaksi sesuai dengan status yang dikirim oleh Midtrans
        switch($status) {
            case 'settlement':
                // Pembayaran Berhasil
                $struk->status = 'paid';
                $struk->save();
                break;
            case 'pending':
                // Pembayaran sedang menunggu
                $struk->status = 'pending';
                $struk->save();
                break;
            case 'cancel':
                // Pembayaran dibatalkan
                $struk->status = 'failed';
                $struk->save();
                break;
            default:
                // Status lainnya
                $struk->status = 'failed';
                $struk->save();
                break;
        }

        // Kembalikan response untuk notifikasi Midrans
        return response()->json(['status' => 'success']);
    }
}
