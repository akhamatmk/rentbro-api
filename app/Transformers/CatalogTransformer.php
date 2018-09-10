<?php
namespace App\Transformers;

use Akhamatvarokah\Rentbro\Models\Mysql\Catalogue;
use League\Fractal\TransformerAbstract;

class CatalogTransformer extends TransformerAbstract
{
	
	protected $availableIncludes = [
        'catalogueCategory'
    ];
	 

	public function transform(Catalogue $catalog)
   	{ 

     $data =  [
         'id'					=> (int) $catalog->id,
         'name'					=> $catalog->name,
     ];
        
      return $data;
   	}

   	public function includeCatalogueCategory(Catalogue $catalog)
    {
        if(isset($catalog->catalogueCategory))
            return $this->collection($catalog->catalogueCategory, new CategoryCatalogTransformer);
        else
            return [];
    }
}