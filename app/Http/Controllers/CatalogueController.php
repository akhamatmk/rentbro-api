<?php
namespace App\Http\Controllers;

use App\Transformers\CatalogTransformer;
use Illuminate\Http\Request;
use Rentalbro\Models\Mysql\Catalogue;

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
