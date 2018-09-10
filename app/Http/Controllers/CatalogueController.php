<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Akhamatvarokah\Rentbro\Models\Mysql\Catalogue;
use App\Transformers\CatalogTransformer;

class CatalogueController extends ApiController
{
	public function index()
	{
		$Catalogue = Catalogue::get();
		return $this->response()->success($Catalogue);
	}

	public function show($id)
	{
		$catalogue = Catalogue::find($id);
		return $this->response()->success($catalogue, [] , 200, new CatalogTransformer(), 'item', null, ['catalogueCategory']);

	}
}
