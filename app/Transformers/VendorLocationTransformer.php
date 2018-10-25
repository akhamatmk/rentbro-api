<?php
namespace App\Transformers;

use Rentalbro\Models\Mysql\VendorLocation;
use League\Fractal\TransformerAbstract;

class VendorLocationTransformer extends TransformerAbstract
{
	public function transform(VendorLocation $vendor)
   	{
      	$data =  [
			'id'           			=> (int) $vendor->id,
			'vendor_id'    			=> (int) $vendor->vendor_id,
			'district_id'  			=> $vendor->district_id,
			'regency'				=> $vendor->district->regency ? $vendor->district->regency : null,
			'alias_name'			=> $vendor->alias_name,
			'zip_code'    			=> $vendor->zip_code,
			'detail_location'		=> $vendor->detail_location,
			'fax'  					=> $vendor->fax,
			'phone'       			=> $vendor->phone,
			'longitude'				=> $vendor->longitude,
			'latitude'				=> $vendor->latitude,
      	];
      	return $data;
   	}
}