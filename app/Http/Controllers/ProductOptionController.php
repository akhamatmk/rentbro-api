<?php
namespace App\Http\Controllers;

use App\Transformers\CatalogTransformer;
use Illuminate\Http\Request;
use Rentalbro\Models\Mysql\ProductOption;
use Rentalbro\Models\Mysql\ProductOptionValue;

class ProductOptionController extends ApiController
{
	public function index()
	{
		$productOption = ProductOption::with('value')->orderBy('order', 'ASC')->get();
		return $this->response()->success($productOption);
	}

	public function show($name)
	{
		$productOption = ProductOption::whereRaw('LOWER(name) = "'.strtolower($name).'"')->with('value')->first();
		return $this->response()->success($productOption);
	}

	public function multiple()
	{
		$result = ProductOptionValue::whereIn('product_option_id', $_POST['data'])->get();
		return $this->response()->success($result);
	}
}
