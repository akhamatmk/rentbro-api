<?php
namespace App\Transformers;

use Akhamatvarokah\Rentbro\Models\Mysql\CatalogueCategory;
use League\Fractal\TransformerAbstract;

class CategoryCatalogTransformer extends TransformerAbstract
{	
	public function transform(CatalogueCategory $CatalogueCategory)
   	{ 

     $data =  [
         'id' 		=> (int) $CatalogueCategory->id,
         'category' => isset($CatalogueCategory->category->name) ? $CatalogueCategory->category->name : "",
     ];
        
      return $data;
   	}
}