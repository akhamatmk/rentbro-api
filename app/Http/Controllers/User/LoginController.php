<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Rentalbro\Models\Mysql\UserEcommerce;
use Rentalbro\Models\Mysql\RegisterWithOtherApp;
use Tymon\JWTAuth\JWTAuth;
use Validator;

class LoginController extends ApiController
{
	public function check(JWTAuth $JWTAuth)
	{
		$rules = [
            'email' 	=> 'required|email',
            'password' 	=> 'required|alpha_num|between:6,12',
        ];

    	$validator = Validator::make(
    		$this->request->all(),
    		$rules
		);

        if ($validator->fails())
            return $this->response()->error($validator->errors()->all());
		
        $cek = UserEcommerce::where('email', $this->request->get('email'))->first();
        $password = $this->request->get('password');
        if( ! $cek OR ! (Hash::check($password, $cek->password)))
			return $this->response()->error(["Wrong username or email or password"]);

		$token = $JWTAuth->fromUser($cek);
        return $this->response()->success($cek, ['meta.token' => $token]);
	}

    public function checkOtherApps($provider, JWTAuth $JWTAuth)
    {
        $RegisterWithOtherApp = RegisterWithOtherApp::where('provider_id', $this->request->id)->first();
        if(! $RegisterWithOtherApp)
            return $this->response()->error(['User not found'], 402);

        $user = UserEcommerce::find($RegisterWithOtherApp->user_ecommerce_id);
        if(! $user)
            return $this->response()->error(['User not found'], 401);
        
        $token = $JWTAuth->fromUser($user);
        return $this->response()->success($user, ['meta.token' => $token]);
    }
}
