<?php
namespace App\Transformers;

use Rentalbro\Models\Mysql\UserEcommerce;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
	public function transform(UserEcommerce $user)
   { 

      $data =  [
         'id'			        => (int) $user->id,
         'username'	       => $user->username,
         'name'		       => $user->name,
         'email'		         => $user->email,
         'phone'		         => $user->phone,
         'image'		         => get_image_s3_url($user->image, 'user/profile'),
         'birth_day'	         => $user->birth_day,
         'gender'		        => $user->gender,         
         'vendor'             => $user->vendor,
         'password_make'		=> $user->password_make,
      ];
        
      return $data;
   }

   protected function image_profile()
   {

   }
}