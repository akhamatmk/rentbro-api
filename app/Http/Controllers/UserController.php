<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Akhamatvarokah\Rentbro\Models\Mysql\UserEcommerce;
use Akhamatvarokah\Rentbro\Models\Mysql\UserEcommerceAddres;
use Illuminate\Support\Facades\Hash;
use App\Transformers\UserTransformer;

class UserController extends ApiController
{
	public function info(JWTAuth $JWTAuth)
	{
        $user =  $JWTAuth->parseToken()->authenticate();
        $token = $JWTAuth->getToken();
        return $this->response()->success($user, ['meta.token' => (string) $token] , 200, new UserTransformer(), 'item');
	}

	public function profile_edit(JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$user->name = $this->request->name;
		$user->username = $this->request->username;
		$user->gender = $this->request->gender;
		$user->birth_day = $this->request->birth;
		$user->save();
        
        $token = $JWTAuth->getToken();
		return $this->response()->success($user, ['meta.token' => (string) $token]);
	}

	public function address_add(JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$address = new UserEcommerceAddres();
		$address->user_ecommerce_id = $user->id;
		$address->province_id = $this->request->province;
		$address->regency_id = $this->request->regency;
		$address->district_id = $this->request->district;
		$address->name = $this->request->name;
		$address->phone = $this->request->phone;
		$address->postal_code = $this->request->postal_code;
		$address->full_address = $this->request->full_address;
		$address->primary = $this->request->primary;
		$address->save();

        $token = $JWTAuth->getToken();
		return $this->response()->success($address, ['meta.token' => (string) $token]);
	}

	public function list_address(JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$address = UserEcommerceAddres::select('user_ecommerce_address.*', 
					'provinces.name as provincy_name', 'regencies.name as regency_name', 'districts.name as district_name')
					->leftJoin('provinces', 'provinces.id', 'user_ecommerce_address.province_id')
					->leftJoin('regencies', 'regencies.id', 'user_ecommerce_address.regency_id')
					->leftJoin('districts', 'districts.id', 'user_ecommerce_address.district_id')
					->where('user_ecommerce_id', $user->id)
					->get();
        $token = $JWTAuth->getToken();
		return $this->response()->success($address, ['meta.token' => (string) $token]);
	}

	public function profile_image_change(JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$user->image = $this->request->image;
		$user->save();

		$token = $JWTAuth->getToken();
		return $this->response()->success($user, ['meta.token' => (string) $token]);
	}

	public function profile_edit_validation(JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$user->name = $this->request->name;
		$user->phone = $this->request->phone;
		$user->gender = $this->request->gender;
		$user->image = $this->request->image;
		$user->birth_day = $this->request->birth;
		$user->password = Hash::make($this->request->password);
		$user->save();
        
        $token = $JWTAuth->getToken();
		return $this->response()->success($user, ['meta.token' => (string) $token]);
	}

	public function check_email()
	{
		$UserEcommerce = UserEcommerce::where('email', $this->request->email)->first();

		if($UserEcommerce)
			return $this->response()->success(['exist' => true]);
		else
			return $this->response()->success(['exist' => false]);
	}

	public function validation()
    {
        $UserEcommerce = UserEcommerce::where('validation_code', $this->request->validation_code)->first();

		if($UserEcommerce)
			return $this->response()->success($UserEcommerce);
		else
			return $this->response()->error(['User already exists'], 400);
    }
}
