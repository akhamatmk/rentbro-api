<?php
namespace App\Transformers;

use Akhamatvarokah\Rentbro\Models\Mysql\Catalogue;
use League\Fractal\TransformerAbstract;

class CatalogTransformer extends TransformerAbstract
{	 

	public function transform(Catalogue $catalog)
   	{ 

      $data =  [
         'id'				=> (int) $catalog->id,
         'name'				=> $catalog->name,
         'category'			=> $catalog->category,
      ];
        
      return $data;
   	}
}