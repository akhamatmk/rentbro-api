<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rentalbro\Models\Mysql\Category;

class CategoryController extends ApiController
{
	public function index()
	{
		$category = Category::whereNull('parent_id')->get();

		foreach ($category as $key => $value) {
			$child = Category::where('parent_id', $value->id)->get();
			$category[$key]->child = $child;
		}
		return $this->response()->success($category);
	}
}
