<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Controller;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/produk');
        }

        return redirect()->back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

    public function changePassword($adminId)
    {
        $admin = Admin::find($adminId);

        if ($admin) {
            $newPassword = 'new_password'; // Ganti 'new_password' dengan password baru yang diinginkan
            $hashedPassword = Hash::make($newPassword);

            $admin->password = $hashedPassword;
            $admin->save();

            return "Password admin berhasil diubah.";
        } else {
            return "Admin tidak ditemukan.";
        }
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6',
        ]);

        $admin = new Admin();
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();

        return "Admin berhasil didaftarkan.";
    }
}

