<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use File;


class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banner = Banner::all();
        return response()->json([
            'status' => true, 
            'data' => $banner
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gambar_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $banner = new Banner();
        $banner->gambar_banner = $request->gambar_banner;

        if ($request->hasFile('gambar_banner')){
            $gambar_banner = $request->file('gambar_banner');
            $nama_gambar_banner = time() . '_' . $gambar_banner->getClientOriginalName();
            $path = $gambar_banner->move(public_path('uploads/banner_image'), $nama_gambar_banner);
            $banner->gambar_banner = 'uploads/banner_image/' . $nama_gambar_banner;

            $banner->save();

            return response()->json([
                'status' => true, 
                'message' => 'Banner berhasil ditambahkan', 
                'data' => $banner
            ], 201);
        }
    }


    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'gambar_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $banner = Banner::find($id);
        if(!$banner){
            return response()->json([
                'status' => false,
                'message' => 'Banner tidak ditemukan'
            ], 404);
        }

        $banner->gambar_banner = $request->gambar_banner;

        if($request->hasFile("gambar_banner")){
            if ($banner->gambar_banner){
                $oldImagePath = public_path().'/uploads/banner_image/'.$banner->gambar_banner;
                if(File::exists($oldImagePath)){
                    File::delete($oldImagePath);
                }
            }
            $gambar_banner = $request->file('gambar_banner');
            $nama_gambar_banner = time() . '_' . $gambar_banner->getClientOriginalName();
            $path = $gambar_banner->move(public_path('uploads/banner_image'), $nama_gambar_banner);
            $banner->gambar_banner = 'uploads/banner_image/' . $nama_gambar_banner;
        }
        $banner->save();

        return response()->json([
            'status' => true, 
            'message' => 'Produk berhasil diupdate', 
            'data' => $banner
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::find($id);
        if (!$banner) {
            return response()->json([
                'status' => false, 
                'message' => 'Banner tidak ditemukan'
            ], 404);
        }
        $banner->delete();
        return response()->json([
            'status' => true, 'message' => 
            'Banner berhasil dihapus'
        ], 200);
    }
}
