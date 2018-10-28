<?php
namespace App\Transformers;

use Rentalbro\Models\Mysql\Chart;
use Rentalbro\Models\Mysql\ProductOptionXref;
use League\Fractal\TransformerAbstract;

class ChartTransformer extends TransformerAbstract
{
   protected $availableIncludes = [
      'product'
   ];

	public function transform(Chart $chart)
   {
      $data =  [
         'id'					=> (int) $chart->id,
         'product_id'			=> $chart->product_id,
         'place_id'				=> $chart->place_id,
         'user_ecommerce_id'	=> $chart->user_ecommerce_id,
         'start_date'			=> $chart->start_date,
         'end_date'				=> $chart->end_date,
         'valid_until'			=> $chart->valid_until,
      ];

      return $data;
   }

   public function includeProduct(Chart $chart)
   {
      if(isset($chart->product))
         return $this->item($chart->product, new ProductTransformer);
      else
         $this->null();
   }
}