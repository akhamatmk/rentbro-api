<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Tymon\JWTAuth\JWTAuth;
use Akhamatvarokah\Rentbro\Models\Mysql\Vendor;
use Akhamatvarokah\Rentbro\Models\Mysql\Product;
use Akhamatvarokah\Rentbro\Models\Mysql\ProductImage;
use Akhamatvarokah\Rentbro\Models\Mysql\VendorLocation;
use Akhamatvarokah\Rentbro\Models\Mysql\ProductPrice;
use Validator;

class VendorController extends ApiController
{
	public function nicknameCheck()
	{
		$rules = [
            'nick_name'	=> 'required',
        ];

    	$validator = Validator::make(
    		$this->request->all(),
    		$rules
		);

        if ($validator->fails())
            return $this->response()->error($validator->errors()->all());

        $vendor = Vendor::where('nickname', $this->request->nick_name)->first();

        if($vendor)
        	return $this->response()->error(['Nickname Already exist'], 401);

        return $this->response()->success(true);
	}

	public function profile($nickname, JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$vendor = Vendor::where('nickname', $nickname)->where('user_ecommerce_id', $user->id)->first();
		if(! $vendor)
			return $this->response()->error(['Vendor Not Found'], 400);

		$token = $JWTAuth->getToken();
		return $this->response()->success($vendor, ['meta.token' => (string) $token]);
	}

	public function create(JWTAuth $JWTAuth)
	{
		$rules = [
            'nick_name'	=> 'required',
            'full_name'	=> 'required',
        ];

    	$validator = Validator::make(
    		$this->request->all(),
    		$rules
		);

        if ($validator->fails())
            return $this->response()->error($validator->errors()->all());
		
		$user =  $JWTAuth->parseToken()->authenticate();
		$vendor = new Vendor;
		$vendor->user_ecommerce_id = $user->id;
		$vendor->nickname = $this->request->nick_name;
		$vendor->full_name = $this->request->full_name;
		$vendor->motto = $this->request->motto;
		$vendor->description = $this->request->description;
		$vendor->logo = $this->request->logo;
		$vendor->save();		

		$vendorLocation = new VendorLocation;
		$vendorLocation->vendor_id = $vendor->id;
		$vendorLocation->district_id = $this->request->district;
		$vendorLocation->zip_code = $this->request->zip_code;
		$vendorLocation->detail_location = $this->request->detail_location;
		$vendorLocation->save();

		return $this->response()->success($vendor);
	}

	public function product_add($vendor_id, JWTAuth $JWTAuth)
    {
    	$user =  $JWTAuth->parseToken()->authenticate();
        $token = $JWTAuth->fromUser($user);
    	$vendor = Vendor::where('id', $vendor_id)->where('user_ecommerce_id', $user->id)->first();
		if(! $vendor)
			return $this->response()->error(['Vendor Not Found'], 400);
        
        $price_type = $this->request->price_type;

        $amount = $this->request->amount;
        $price = $this->request->price;

        $product = new Product;
        $product->vendor_id = $vendor_id;
        $product->category_id = $this->request->category;
        $product->name = strtolower($this->request->name);
        $product->alias = str_replace(" ", "-", strtolower($this->request->name)."_".$user->id.date('his')) ;
        $product->quantity = (int) $this->request->quantity;
        $product->weight = $this->request->weight;
        $product->image = $this->request->product_image_primary;
        $product->description = $this->request->description;        
        $product->save();

        if(isset($_POST['product_images'])){
            foreach ($this->request->product_images as $key => $value) {
                $ProductImage = new ProductImage;
                $ProductImage->product_id = $product->id;
                $ProductImage->image = $value;
                $ProductImage->save();
            }    
        }
        
        foreach ($price_type as $key => $value) {
            if($value != "" AND $amount[$key] != "" AND $price[$key] != "")
            {
                $ProductPrice = new ProductPrice;
                $ProductPrice->product_id = $product->id;
                $ProductPrice->type = $value;
                $ProductPrice->amount = $amount[$key];
                $ProductPrice->price = $price[$key];
                $ProductPrice->save();    
            }            
        }

        return $this->response()->success($product, ['meta.token' => $token]);
    }
}
