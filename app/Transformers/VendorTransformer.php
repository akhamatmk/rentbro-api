<?php
namespace App\Transformers;

use Rentalbro\Models\Mysql\Vendor;
use League\Fractal\TransformerAbstract;

class VendorTransformer extends TransformerAbstract
{
   protected $availableIncludes = [
      'addres'
   ];

	public function transform(Vendor $vendor)
   {    
      $data =  [
         'id'           => (int) $vendor->id,
         'nickname'     => $vendor->nickname,
         'logo'         => $vendor->logo,
         'full_name'    => $vendor->full_name,
         'motto'        => $vendor->motto,
         'image'        => get_image_s3_url($vendor->logo, 'vendor'),
         'description'  => $vendor->description,
         'addres'       => $vendor->addres,
      ];
        
      return $data;
   }

   public function includeAddres(Vendor $vendor)
   {
      if(isset($vendor->addres))
         return $this->item($vendor->addres, new VendorLocationTransformer);
      else
         return $this->null();
   }
}