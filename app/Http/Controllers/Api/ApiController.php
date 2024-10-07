<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use File;

class ApiController extends Controller
{
    public function register(Request $request){
        try{
            $validateUser = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'telepon' => 'required',
                'password' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation eror', 
                    'errors' => $validateUser->errors()
                ],401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'password' => $request->password,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Akun berhasil dibuat', 
                'token' => $user->createToken('API TOKEN')->plainTextToken
            ],200);

        }catch(Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(), 
            ],500);
        }
    }

    public function login(Request $request){
        try{
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation eror', 
                    'errors' => $validateUser->errors()
                ],401);
            }
            
            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password tidak cocok',
                ],401);
            }

            $user = User::where('email',$request->email)->first();
            return response()->json([
                'status' => true,
                'message' => 'Login Berhasil', 
                'token' => $user->createToken('API TOKEN')->plainTextToken,
                'userId' => $user->id
            ],200);

        }catch(Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(), 
            ],500);
        }
    }

    public function profile(){
        $userData = auth()->user();
        return response()->json([
            'status' => true,
            'message' => 'Informasi Profile', 
            'data' => $userData, 
            'id' => auth()->user()->id
        ],200);
    }

    public function updateProfile(Request $request){
        \Log::info($request->all());
            // Validasi input
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . auth()->user()->id,
                'telepon' => 'required',
                'alamat' => 'nullable|string',
                'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Dapatkan pengguna yang sedang login
            $user = $request->user();

            // Perbarui data pengguna
            $user->name = $request->name;
            $user->email = $request->email;
            $user->telepon = $request->telepon;
            $user->alamat = $request->alamat;

            if ($request->hasFile('foto_profil')){
                // Hapus foto lama jika ada
                if ($user->foto_profil) {
                    $oldFilePath = public_path().'/uploads/profile_image/' . $user->foto_profil;
                    if (File::exists($oldFilePath)) {
                        File::delete($oldFilePath);
                    }
                }
                $foto_profil = $request->file('foto_profil');
                $image_name ='uploads/profile_image/'.time() . '_' . $foto_profil->getClientOriginalName();
                $path = $foto_profil->move(public_path('uploads/profile_image'), $image_name);
                $user->foto_profil = $image_name;
            }else{
                $image_name=$user->foto_profil;
            }
    
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
                'foto_profil' => $user->foto_profil
            ]);

            $user->foto_profil_url = $user->foto_profil ? url('uploads/profile_image/' . $user->foto_profil) : null;

            return response()->json([
                'status' => true,
                'message' => 'Profile berhasil di update',
                'data' => $user
            ], 200);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Logged out', 
            'data' => [], 
        ],200);
    }
}

// Register, Login, Profile and Logout
