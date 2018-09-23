<?php
namespace App\Transformers;

use Rentalbro\Models\Mysql\ProductPrice;
use League\Fractal\TransformerAbstract;

class ProductPriceTransformer extends TransformerAbstract
{
	public function transform(ProductPrice $price)
   	{    
      $data =  [
         'id'           => (int) $product->id,
         'name'			=> $product->name,

      ];
        
      return $data;
   }
}