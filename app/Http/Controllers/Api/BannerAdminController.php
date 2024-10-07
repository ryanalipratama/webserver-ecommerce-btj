<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Validator;
use File;

class BannerAdminController extends Controller
{
    public function getBanner()
    {
        $banner = Banner::get();

        return view('getbanner', compact('banner'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createbanner(){
        return view('createbanner');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function banner_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gambar_banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, 
                'message' => 'Validation error', 
                'errors' => $validator->errors()
            ], 422);
        }

        $banner = new Banner();

        if ($request->hasFile('gambar_banner')){
            $gambar_banner = $request->file('gambar_banner');
            $nama_gambar_banner = time() . '_' . $gambar_banner->getClientOriginalName();
            $path = $gambar_banner->move(public_path('uploads/banner_image'), $nama_gambar_banner);
            $banner->gambar_banner = 'uploads/banner_image/' . $nama_gambar_banner;
        }
        $banner->save();

        return redirect()->route('getbanner');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function banner_edit(string $id)
    {
        $banner = Banner::find($id);

        return view('editbanner', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function banner_update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'gambar_banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, 
                'message' => 'Validation error', 
                'errors' => $validator->errors()
            ], 422);
        }

        $banner = Banner::find($id);
        if (!$banner) {
            return response()->json([
                'status' => false, 
                'message' => 'Kategori tidak ditemukan'
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

        return redirect()->route('getbanner');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function banner_delete(Request $request, $id){
        $banner = Banner::find($id);
        if($banner){
            $banner->delete();
        }
        
        return redirect ()->route('getbanner');
    }
}
