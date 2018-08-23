<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Akhamatvarokah\Rentbro\Models\Mysql\Catalogue;

class CatalogueController extends ApiController
{
	public function index()
	{
		$Catalogue = Catalogue::get();
		return $this->response()->success($Catalogue);
	}
}
