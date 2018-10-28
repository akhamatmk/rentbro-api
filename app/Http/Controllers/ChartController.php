<?php
namespace App\Http\Controllers;

use Rentalbro\Models\Mysql\Chart;
use App\Transformers\ChartTransformer;
use Tymon\JWTAuth\JWTAuth;

class ChartController extends ApiController
{
	public function ajaxList(JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$token = $JWTAuth->getToken();
		$chart = Chart::where('user_ecommerce_id', $user->id)->get();
		return $this->response()->success(
			$chart, ['meta.token' => (string) $token]
		);
	}

	public function list(JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$token = $JWTAuth->getToken();
		$chart = Chart::where('user_ecommerce_id', $user->id)->get();
		return $this->response()->success(
			$chart, [] , 200, new ChartTransformer(), 'collection', null, 
			['product']
		);
	}

	public function checkout(JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$token = $JWTAuth->getToken();		
		return $this->response()->success($_POST);
	}
}