<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Functions
{

    public static function is_empty($var){
        return empty($var) || is_null($var);
    }

    public static function not_empty($var){
        return !Functions::is_empty($var);
    }

    public static function filtered_request_data(Request $request){
        $data = $request->all();
        foreach ($data as $i => $d){
            if ($d === "null" || $d === ""){
                $data[$i] = null;
            }
        }
        return $data;
    }
}
