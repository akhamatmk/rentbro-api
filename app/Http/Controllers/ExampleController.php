<?php

namespace App\Http\Controllers;
use Province;
use Cost;
use City;
use Rentalbro\Models\Mysql\Regency;

class ExampleController extends Controller
{
    public function tes()
    {   
        $c = City::all();
        $no = [];
        foreach ($c as $key => $value) {
    		if($value->type == "Kabupaten")
    			$type = 1;
    		else 
    			$type = 2;

    		$Regency = Regency::whereRaw('LOWER(`name`) = "'.strtolower($value->city_name).'"')->where('type', $type)->first();

    		if($Regency){
    			$Regency->city_rajaongkir_id = $value->city_id;
    			$Regency->save();
    		}

    		if(! $Regency){
    			$no[] = $value->type."  ".$value->city_name;
    		}
        }
        
        return $no;
    }
}
