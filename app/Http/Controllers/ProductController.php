<?php
namespace App\Http\Controllers;

use App\Transformers\ProductTransformer;
use Illuminate\Http\Request;
use Rentalbro\Models\Mysql\Product;
use Rentalbro\Models\Mysql\Category;
use Rentalbro\Models\Mysql\Chart;
use Rentalbro\Models\Mysql\ProductCategory;
use Tymon\JWTAuth\JWTAuth;

class ProductController extends ApiController
{
	public function detail($vendor, $product)
	{		
		$product = 	Product::select('products.*')
					->Join('vendors', 'vendors.id', 'products.vendor_id')
					->where('vendors.nickname', $vendor)
					->where('products.alias', $product)
					->first();
		
		return $this->response()->success(
			$product, [] , 200, new ProductTransformer(), 'item', null, 
			['price', 'other_image', 'category', 'option', 'vendor', 'vendor.addres']
		);
	}

	public function chart($vendor, $product, JWTAuth $JWTAuth)
	{
		$product = 	Product::select('products.*')
					->Join('vendors', 'vendors.id', 'products.vendor_id')
					->where('vendors.nickname', $vendor)
					->where('products.alias', $product)
					->first();
		
		if(! $product)
			return $this->response()->error('Product Not Found', 400);

		$user =  $JWTAuth->parseToken()->authenticate();
		$token = $JWTAuth->getToken();
		$chart = Chart::where('product_id', $this->request->product_id)->first();

		if(! $chart)
			$chart = new Chart;

		$chart->product_id = $this->request->product_id;
		$chart->place_id = $this->request->place_id;
		$chart->user_ecommerce_id = $user->id;
		$chart->start_date = $this->request->start_date;
		$chart->end_date = $this->request->end_date;
		$chart->valid_until = date('Y-m-d', strtotime("+7 day"));
		$chart->save();

		return $this->response()->success(
			$chart, ['meta.token' => (string) $token]
		);
	}

	public function list()
	{
		$product = 	Product::select('products.*')->get();

		return $this->response()->success(
			$product, [] , 200, new ProductTransformer(), 'collection', null, 
			['price', 'vendor',]
		);
	}

	public function byCategory($alias)
	{
		$category = Category::select('id', 'parent_id')->where('alias', $alias)->first();
		if(! $category)
			return $this->response()->success([]);
		
		$c[] = $category->id;
		if($category->parent_id == null)
		{
			$category = Category::select('id')->where('parent_id', $category->id)->get();
			foreach ($category as $key => $value) {
				$c[] = $value->id;
			}
		}

		$ProductCategory = ProductCategory::whereIn('category_id', $c)->get();
		if(count($ProductCategory) < 1)
			return $this->response()->success([]);	

		foreach ($ProductCategory as $key => $value) {
			$p[] = $value->product_id;
		}

		$product = Product::whereIn('id', $p)->get();

		return $this->response()->success(
			$product, [] , 200, new ProductTransformer(), 'collection', null, 
			['price', 'vendor',]
		);
		
	}

	public function search()
	{
		$product = 	Product::select('products.*')
				->where('name', 'like', '%' . $_GET['q'] . '%')
				->get();

		return $this->response()->success(
			$product, [] , 200, new ProductTransformer(), 'collection', null, 
			['price', 'vendor',]
		);
	}
}