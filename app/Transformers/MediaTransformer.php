<?php
namespace App\Transformers;

use Rentalbro\Models\Mysql\Media;
use League\Fractal\TransformerAbstract;

class MediaTransformer extends TransformerAbstract
{
	public function transform(media $media)
   	{
      	$data =  [
			'id'	=> (int) $media->id,
			'image'	=> get_image_s3_url($media->url, 'product'),
      	];
        
      return $data;
   }
}