<?php
namespace App\Transformers;

use Rentalbro\Models\Mysql\ProductCategory;
use League\Fractal\TransformerAbstract;

class ProductCategoryTransformer extends TransformerAbstract
{
	public function transform(ProductCategory $data)
   {
   	$data =  [
			'id'			=> (int) $data->id,
			'category'	=> $data->category->name ? $data->category->name : "",
   	];
        
      return $data;
   }
}