<?php
namespace App\Http\Controllers;

use App\Transformers\ProductTransformer;
use Illuminate\Http\Request;
use Rentalbro\Models\Mysql\Product;

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

	public function list()
	{
		$product = 	Product::select('products.*')->get();

		return $this->response()->success(
			$product, [] , 200, new ProductTransformer(), 'collection', null, 
			['price', 'vendor',]
		);
	}
}