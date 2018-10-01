<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rentalbro\Models\Mysql\Province;
use Rentalbro\Models\Mysql\Regency;
use Rentalbro\Models\Mysql\District;

class PlaceController extends ApiController
{
	public function province()
	{
		$province = Province::select('id', 'name')->get();

		return $this->response()->success($province);
	}

	public function regency()
	{
		$province_id = isset($_GET['province_id']) ? $_GET['province_id'] : null;
		if($province_id)
			$province = Regency::select('id', 'name', 'type', 'city_rajaongkir_id')->where('province_id', $province_id)->get();
		else
			$province = Regency::select('id', 'name', 'type', 'city_rajaongkir_id')->get();

		return $this->response()->success($province);
	}

	public function district()
	{
		$regency_id = isset($_GET['regency_id']) ? $_GET['regency_id'] : null;
		if($regency_id)
			$district = District::select('id', 'name')->where('regency_id', $regency_id)->get();
		else
			$district = District::select('id', 'name')->get();

		return $this->response()->success($district);
	}
	
}