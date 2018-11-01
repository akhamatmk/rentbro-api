<?php
namespace App\Http\Controllers;

use Rentalbro\Models\Mysql\Chart;
use Rentalbro\Models\Mysql\Transaction;
use Rentalbro\Models\Mysql\ProductTransaction;
use App\Transformers\ChartTransformer;
use Tymon\JWTAuth\JWTAuth;
use DB;

class TransactionController extends ApiController
{
	public function invoice($inv, JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$token = $JWTAuth->getToken();
		$transaction = Transaction::where('user_ecommerce_id', $user->id)->where('code_trans', $inv)->first();
		return $this->response()->success(
			$transaction, ['meta.token' => (string) $token]
		);
	}
}