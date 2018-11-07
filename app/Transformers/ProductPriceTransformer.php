<?php
namespace App\Transformers;

use Rentalbro\Models\Mysql\ProductPrice;
use League\Fractal\TransformerAbstract;

class ProductPriceTransformer extends TransformerAbstract
{
	public function transform(ProductPrice $price)
   	{
      	$data =  [
				'id'           => (int) $price->id,
				'type'			=> (int) $price->type,
				'amount'			=> (int) $price->amount,
				'price'			=> (int) $price->price,
      	];
        
      return $data;
   }
}