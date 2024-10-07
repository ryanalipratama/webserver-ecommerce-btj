<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function saveImages($foto_profil, $path = 'public')
    {
        if(!$foto_profil)
        {
            return null;
        }

        $filename = time(). '.' . $foto_profil->getClientOriginalExtension();


        Storage::disk($path)->putFileAs('', $foto_profil, $filename);

        return URL::to('/').'/storage/'.$path.'/'.$filename;

    }
}
