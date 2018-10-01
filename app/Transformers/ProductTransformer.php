<?php
namespace App\Transformers;

use Rentalbro\Models\Mysql\Product;
use Rentalbro\Models\Mysql\ProductOptionXref;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
   protected $availableIncludes = [
      'price', 'other_image', 'category', 'option', 'vendor'
   ];

	public function transform(Product $product)
   {
      $data =  [
         'id'              => (int) $product->id,
         'name'            => $product->name,
         'alias'			   => $product->alias,
         'image'		      => get_image_s3_url($product->image, 'product'),
         'description'     => $product->description,
         'price'           => $product->price,
         'minimum_deposit' => $product->minimum_deposit,
         'catalog'         => $product->catalog,
         'weight'         => (double) $product->weight,
         'vendor'          => $product->vendor,
      ];

      return $data;
   }

   public function includeVendor(Product $product)
   {
      if(isset($product->vendor))
         return $this->item($product->vendor, new VendorTransformer);
      else
         $this->null();
   }

   public function includePrice(Product $product)
   {
      if(isset($product->price))
         return $this->collection($product->price, new ProductPriceTransformer);
      else
         $this->null();
   }

   public function includeOtherImage(Product $product)
   {
      if(isset($product->media))
         return $this->collection($product->media, new MediaTransformer);
      else
         $this->null();
   }

   public function includeCategory(Product $product)
   {
      if(isset($product->category))
         return $this->collection($product->category, new ProductCategoryTransformer);
      else
         $this->null();
   }

   public function includeOption(Product $product)
   {
      $data = [];
      $result = [];
      foreach ($product->xref as $key => $value) {
         $temp = [
            "option_id"          => $value->product_option_id,
            "option_value_id"    => $value->product_option_value_id,
            "option_name"        => $value->option->name,
            "option_value_name"  => $value->optionValue->value,
         ];
         
         $data[] = $temp;
      }
      $no = 0;
      foreach ($data as $key => $value) {
         $temp = $this->check_array($result, 'option_id', $value['option_id']);

         if(! $temp)
         {
            $result[$no]['option_id'] = $value['option_id'];
            $result[$no]['option_name'] = $value['option_name'];
            $now = $no;
            $no++;
         }

         $child = [
            'option_value_id' => $value['option_value_id'],
            'option_value_name' => $value['option_value_name']
         ];

         $result[$now]['value'][] = $child;
      }

      if(count($result) == 0)
         return $this->null();

      return $this->item($result, function($result) {      
         return $result ? $result : $this->null();
     });
   }

   protected function check_array($array, $keySearch, $valueSearch)
   {
      foreach ($array as $key => $value) {
         if($value[$keySearch] == $valueSearch)
            return true;
      }

      return false;
   }
}