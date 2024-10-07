<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Cart;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    // index
    public function index()
    {
        try{
            $user_id = Auth::id();
            $cartItems = Cart::where('user_id', $user_id)->with('produk')->get();
            return response()->json($cartItems);
        }catch(\Exception $e){
            Log::error('Error occurred while fetching cart items: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch cart items'], 500);
        }
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|integer',
            'quantity' => 'required|integer|min:1', // Memastikan quantity minimal 1
        ]);

        $user_id = auth()->user()->id;
        $produk_id = $request->produk_id;
        $quantity = (int) $request->quantity;

        // Cek apakah produk sudah ada dalam keranjang
        $existingCartItem = Cart::where('user_id', $user_id)
                                ->where('produk_id', $produk_id)
                                ->first();

        if ($existingCartItem) {
            // Jika produk sudah ada, tambahkan kuantitasnya
            $existingCartItem->quantity += $quantity;
            $existingCartItem->save();
        } else {
            // Jika produk belum ada, tambahkan produk baru ke keranjang
            $cart = new Cart;
            $cart->user_id = $user_id;
            $cart->produk_id = $produk_id;
            $cart->quantity = $quantity;
            $cart->save();
        }

        return response()->json(['message' => 'Product added to cart successfully'], 201);
    }

    // Update quantity
    public function update(Request $request, $id)
    {
        try {
            // Validasi request
            $request->validate([
                'quantity' => 'required|integer|min:1',
            ]);

            // Temukan item keranjang berdasarkan ID
            $cartItem = Cart::findOrFail($id);

            // Pastikan user yang mengirim permintaan adalah pemilik item keranjang
            if ($cartItem->user_id !== Auth::id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            // Update kuantitas item
            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            return response()->json(['message' => 'Cart item quantity updated successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error updating cart item quantity: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update cart item quantity'], 500);
        }
    }

    // Destroy
    public function destroy($id)
    {
        try {
            $user_id = Auth::id();
            $cartItem = Cart::where('user_id', $user_id)
                            ->where('id', $id)
                            ->first();

            if ($cartItem) {
                // Kurangi kuantitas jika lebih dari 1, atau hapus jika 1
                if ($cartItem->quantity > 1) {
                    $cartItem->quantity -= 1;
                    $cartItem->save();
                } else {
                    $cartItem->delete();
                }

                return response()->json(['message' => 'Item removed from cart']);
            } else {
                return response()->json(['message' => 'Item not found'], 404);
            }
        } catch (\Exception $e) {
            Log::error('Error occurred while removing item from cart: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to remove item from cart'], 500);
        }
    }
}


