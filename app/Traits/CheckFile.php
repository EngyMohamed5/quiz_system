<?php

namespace App\Traits;

trait CheckFile
{
    public function checkFile($request,$field_name)
    {
        if ($request->hasFile($field_name)) {
            return true;
        }
        else return false;
    }
}
