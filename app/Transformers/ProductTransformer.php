<?php
namespace App\Transformers;

use Rentalbro\Models\Mysql\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
	public function transform(Product $product)
   {    
      $data =  [
         'id'           => (int) $product->id,
         'name'			=> $product->name,
         'image'		   => get_image_s3_url($product->image, 'product'),
         'description'  => $product->description,
         'price'        => $product->price,

      ];
        
      return $data;
   }

   public function includeCriteria(Product $product)
   {
      if(isset($product->price))
         return $this->collection($product->price, new ProductPriceTransformer);
      else
         return [];
   }
}