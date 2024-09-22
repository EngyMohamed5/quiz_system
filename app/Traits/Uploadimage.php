<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait Uploadimage
{
    public function uploadimage(Request $request,$name, $folder){
        if ($request->hasFile($name)) {
            $image = $request->file($name)->getClientOriginalName();
            $final_name = time().'.'.str_replace(' ','-',$image);
            $path=$request->file($name)->storeAs($folder,$final_name,'public_folder');
            return $path;
        }
    }
}
