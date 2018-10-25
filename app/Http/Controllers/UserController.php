<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Rentalbro\Models\Mysql\Regency;
use Rentalbro\Models\Mysql\District;
use Rentalbro\Models\Mysql\UserEcommerce;
use Rentalbro\Models\Mysql\UserEcommerceAddres;
use Rentalbro\Models\Mysql\VerificationCode;
use Illuminate\Support\Facades\Hash;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Mail;

class UserController extends ApiController
{
	public function info(JWTAuth $JWTAuth)
	{
        $user =  $JWTAuth->parseToken()->authenticate();
        $token = $JWTAuth->getToken();
        return $this->response()->success($user, ['meta.token' => (string) $token] , 200, new UserTransformer(), 'item');
	}

	public function delete_address($id, JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$address = UserEcommerceAddres::where('user_ecommerce_id', $user->id)
										->where('id', $id)
										->first();
		if($address)
			$address->delete();

		$token = $JWTAuth->getToken();
        return $this->response()->success($address, ['meta.token' => (string) $token] );
	}

	public function send_code_new_password(JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$token = $JWTAuth->getToken();

		$code = VerificationCode::where('user_ecommerce_id', $user->id)->where('type',  $this->request->type)->first();
		if($code)
			$code->delete();
		

		$code = new VerificationCode;
		$code->user_ecommerce_id = $user->id;
		$code->type = $this->request->type;
		$code->code = md5($user->id.date('Y-m-d h:i:s'));
		$code->save();

		$url = env('MAIN_URL_WEB')."set/newPassword/".$code->code ;
        Mail::html('<a href="'.$url.'">Click here to Veryfication</a>', function($msg) { 
            $msg->to(['akhamatmkhoir@gmail.com']); 
            $msg->from(['admin@rentbro.com']); 
            $msg->setBody("<a href='google.com'>sadsa</a>", 'text/html');
        });

		return $this->response()->success('succes', ['meta.token' => (string) $token] );	
	}

	public function check_code_new_password(JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$token = $JWTAuth->getToken();
		$code = VerificationCode::where('user_ecommerce_id', $user->id)->where('code',  $this->request->code)->first();

		if($code)
			return $this->response()->success('succes', ['meta.token' => (string) $token] );	

		return $this->response()->error($_GET, 400);
	}

	public function make_new_password(JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$user->password = Hash::make($this->request->password);
		$user->password_make    = 1;
		$user->save();
		$token = $JWTAuth->getToken();

		return $this->response()->success($user, ['meta.token' => (string) $token] );	
	}

	public function change_new_password(JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();

		if(! (Hash::check($this->request->old_password, $user->password)))
			return $this->response()->error(["Wrong  password"]);

		$user->password = Hash::make($this->request->password);
		$user->password_make    = 1;
		$user->save();
		$token = $JWTAuth->getToken();
		return $this->response()->success($user, ['meta.token' => (string) $token] );	
	}

	public function edit_address($id, JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$address = UserEcommerceAddres::where('user_ecommerce_id', $user->id)
										->where('id', $id)
										->first();
		if($address)
		{
			$address->user_ecommerce_id = $user->id;
			$address->province_id = $this->request->province;
			$address->regency_id = $this->request->regency;
			$address->district_id = $this->request->district;
			$address->name = $this->request->name;
			$address->phone = $this->request->phone;
			$address->postal_code = $this->request->postal_code;
			$address->full_address = $this->request->full_address;

			$address->map_street = $this->request->map_street;
			$address->long = $this->request->long;
			$address->lat = $this->request->lat;


			$address->save();
		}

		$token = $JWTAuth->getToken();
        return $this->response()->success($address, ['meta.token' => (string) $token] );
	}

	public function detail_address($id, JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$address = UserEcommerceAddres::where('user_ecommerce_id', $user->id)
										->where('id', $id)
										->first();
		$data = [];

		if($address)
		{
			$data['address'] = $address;
			$data['regency'] = Regency::select('id', 'name', 'type')->where('province_id', $address->province_id)->get();
			$data['district'] = District::select('id', 'name')->where('regency_id', $address->regency_id)->get();
		}

		$token = $JWTAuth->getToken();
        return $this->response()->success($data, ['meta.token' => (string) $token] );
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
		$address->map_street = $this->request->map_street;
		$address->long = $this->request->long;
		$address->lat = $this->request->lat;
		$address->save();

        $token = $JWTAuth->getToken();
		return $this->response()->success($address, ['meta.token' => (string) $token]);
	}

	public function list_address(JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$address = UserEcommerceAddres::select('user_ecommerce_address.*', 
					'provinces.name as provincy_name', 'regencies.name as regency_name', 'regencies.city_rajaongkir_id', 'districts.name as district_name')
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

	public function check_username(JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$UserEcommerce = UserEcommerce::where('username', $this->request->username)->first();
		if(! $UserEcommerce)
			return $this->response()->success(true);

		if($UserEcommerce->id == $user->id)
			return $this->response()->success(true);

		return $this->response()->error(['username already exists'], 400);
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
