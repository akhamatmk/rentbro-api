<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Rentalbro\Models\Mysql\Category;
use Rentalbro\Models\Mysql\UserEcommerce;
use Rentalbro\Models\Mysql\RegisterWithOtherApp;
use Tymon\JWTAuth\JWTAuth;
use Validator;

class RegisterController extends ApiController
{
	public function create(JWTAuth $JWTAuth)
	{
		$rules = [
            'email' 	=> 'required|email'
        ];

    	$validator = Validator::make(
    		$this->request->all(),
    		$rules
		);

        if ($validator->fails())
            return $this->response()->error($validator->errors()->all());
		
        $cek = UserEcommerce::where('email', $this->request->get('email'))->first();
        if ($cek)
            return $this->response()->error(['User already exists'], 409);
		
        $user = new UserEcommerce;
        $user->name = $this->request->get('name');	
        $user->username = substr($this->request->get('name'), 0, 5).rand(0,100);
		$user->email	= $this->request->get('email');
		$user->password	= Hash::make($this->request->get('password'));
        $user->phone    = $this->request->get('phone');
        $user->validation_code  = Hash::make($this->request->get('email'));
		$user->password_make	= 1;
        if(! $user->save())
            return $this->response()->error(["failed save data"]);

        // $url = env('MAIN_URL_WEB')."validation/".$user->validation_code;
        // Mail::html('<a href="'.$url.'">Click here to Veryfication</a>', function($msg) { 
        //     $msg->to(['akhamatmkhoir@gmail.com']); 
        //     $msg->from(['admin@rentbro.com']); 
        //     $msg->setBody("<a href='google.com'>sadsa</a>", 'text/html');
        // });		
    	
        $token = $JWTAuth->fromUser($user);
        return $this->response()->success($user, ['meta.token' => $token]);
	}

    public function checkOtherApps($provider, JWTAuth $JWTAuth)
    {
        $RegisterWithOtherApp = RegisterWithOtherApp::where('provider_id', $this->request->id)->first();
        if($RegisterWithOtherApp)
        {
            $user = UserEcommerce::find($RegisterWithOtherApp->user_ecommerce_id);
            if(! $user)
                return $this->response()->error(['User not found'], 401);
            else
            {
                $token = $JWTAuth->fromUser($user);
                return $this->response()->success($user, ['meta.token' => $token]);
            }
        } else {
            $user = UserEcommerce::where('email', $this->request->email)->first();
            if($user)
                return $this->response()->error(['Email Alredy Register'], 402);

            $user = new UserEcommerce;
            $user->name = $this->request->name;
            $user->username = substr($this->request->name, 0, 5).rand(0,100);
            $user->email    = $this->request->email;
            $user->password = Hash::make('admin123456789');
            $user->phone    = 821;
            $user->image    = $this->request->avatar_original;
            $user->validation_code  = Hash::make($this->request->email);
            $user->password_make    = 0;

            if(! $user->save())
                return $this->response()->error(["failed save data"], 403);

            $RegisterWithOtherApp = new RegisterWithOtherApp;
            $RegisterWithOtherApp->user_ecommerce_id = $user->id;
            $RegisterWithOtherApp->provider = $provider;
            $RegisterWithOtherApp->provider_id = $this->request->id;
            
            if(! $RegisterWithOtherApp->save())
                return $this->response()->error(["failed save data"], 404);

            $token = $JWTAuth->fromUser($user);
                return $this->response()->success($user, ['meta.token' => $token]);
        }

        return $this->response()->error(['Procces Terminate'], 409);
    }

    public function mail()
    {
        $code = "asdsadasdas2132131";
        $url = env('MAIN_URL_WEB')."validation/".$code;
        Mail::html('<a href="'.$url.'">Click here to Veryfication</a>', function($msg) { 
            $msg->to(['akhamatmkhoir@gmail.com']); 
            $msg->from(['jancuk@gmail.com']); 
            $msg->setBody("<a href='google.com'>sadsa</a>", 'text/html');
        });
    }
}
