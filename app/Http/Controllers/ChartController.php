<?php
namespace App\Http\Controllers;

use Rentalbro\Models\Mysql\Chart;
use Rentalbro\Models\Mysql\Transaction;
use Rentalbro\Models\Mysql\ProductTransaction;
use App\Transformers\ChartTransformer;
use Tymon\JWTAuth\JWTAuth;
use DB;

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
		$count_trans = Transaction::get()->count() + 1;
		
    	$transaction = new Transaction;
    	$transaction->user_ecommerce_id = (int) $user->id;
    	$transaction->code_trans = "INV".$count_trans."".date('Ymdhis');
    	$transaction->summary_shipping = (int) str_replace(",", "", $_POST['summary_shipping'] );
    	$transaction->summary_price = (int) str_replace("," , "", $_POST['summary_price']);
    	$transaction->summary_deposit = (int) str_replace( ",", "", $_POST['summary_deposit']);
    	$transaction->summary_all = (int) str_replace( ",", "", $_POST['summary_all']);
    	$transaction->save();

    	foreach ($_POST['item_id'] as $key => $value) {
    		$ProductTransaction = new ProductTransaction;
    		$ProductTransaction->transaction_id =  $transaction->id;
    		$ProductTransaction->item_id =  $value;
    		$ProductTransaction->item_name =  $_POST['item_name'][$key];
    		$ProductTransaction->item_image =  $_POST['item_image'][$key];
    		$ProductTransaction->price_item =  $_POST['price_item'][$key];
    		$ProductTransaction->place_id =  $_POST['place_id'][$key];
    		$ProductTransaction->courier =  $_POST['courier'][$key];
    		$ProductTransaction->shipping =  $_POST['shipping'][$key];
    		$ProductTransaction->price =  $_POST['price'][$key];
    		$ProductTransaction->full_address =  $_POST['full_address'][$key];
    		$ProductTransaction->time_rent =  $_POST['time_rent'][$key];
    		$ProductTransaction->start_date =  $_POST['start_date'][$key];
    		$ProductTransaction->end_date =  $_POST['end_date'][$key];
    		$ProductTransaction->save();
    	}

    	DB::table('charts')->where('user_ecommerce_id', $user->id )->delete(); 

		return $this->response()->success(
			$transaction , ['meta.token' => (string) $token]
		);
	}

	public function destroy($chart, JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$token = $JWTAuth->getToken();

		$data_chart = Chart::where('id', $chart)->where('user_ecommerce_id', $user->id)->first();
		if($data_chart)
			$data_chart->delete();
		
		return $this->response()->success(
			true , ['meta.token' => (string) $token]
		);
	}
}