<?php
namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use Rentalbro\Models\Mysql\Product;
use Rentalbro\Models\Mysql\Wishlist;
use App\Transformers\ProductTransformer;
use Tymon\JWTAuth\JWTAuth;
use Validator;

class WishlistController extends ApiController
{
	public function add(JWTAuth $JWTAuth)
	{		
		$product = 	Product::select('products.*')
					->Join('vendors', 'vendors.id', 'products.vendor_id')
					->where('vendors.nickname', $_POST['vendor'])
					->where('products.alias', $_POST['product'])
					->first();
		if(! $product)
			return $this->response()->error('Product Not Found', 400);

		$user =  $JWTAuth->parseToken()->authenticate();
		$token = $JWTAuth->getToken();

		$wishlist = Wishlist::where('product_id', $product->id)->where('user_id', $user->id)->first();
		if(! $wishlist)
		{
			$wishlist = new Wishlist;
			$wishlist->product_id = $product->id;
			$wishlist->user_id = $user->id;
			$wishlist->save();
		}

		return $this->response()->success(
			$wishlist, ['meta.token' => (string) $token]
		);
	}

	public function list(JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$token = $JWTAuth->getToken();
		$wishlist = Wishlist::where('user_id', $user->id)->get();		
		
		if(count($wishlist) < 1){				
			return $this->response()->success(
				null, ['meta.token' => (string) $token]
			);
		}

		$product_id = [];
		$product = [];
		foreach ($wishlist as $key => $value) {
			$product_id[] = $value->product_id;
		}

		$product = 	Product::select('products.*')->whereIn('id', $product_id)->get();

		return $this->response()->success(
			$product, [] , 200, new ProductTransformer(), 'collection', null, 
			['price', 'vendor',]
		);

		return $this->response()->success(
			$product, ['meta.token' => (string) $token]
		);
	}
}