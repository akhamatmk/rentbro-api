<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Akhamatvarokah\Rentbro\Models\Mysql\Category;

class CategoryController extends ApiController
{
	public function index()
	{
		$category = Category::get();
		return $this->response()->success($category);
	}
}
