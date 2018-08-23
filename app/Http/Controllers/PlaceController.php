<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Akhamatvarokah\Rentbro\Models\Mysql\Province;
use Akhamatvarokah\Rentbro\Models\Mysql\Regency;
use Akhamatvarokah\Rentbro\Models\Mysql\District;

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
			$province = Regency::select('id', 'name', 'type')->where('province_id', $province_id)->get();
		else
			$province = Regency::select('id', 'name', 'type')->get();

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