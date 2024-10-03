<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait Uploadimage
{
    public function uploadImage($data, $name, $folder) {
        if (isset($data[$name]) && $data[$name]->isValid()) {
            $image = $data[$name]->getClientOriginalName();
            $final_name = time() . '.' . str_replace(' ', '-', $image);
            $path = $data[$name]->storeAs($folder, $final_name, 'public_folder');
            return $path;
        }
        return null;
    }

}
