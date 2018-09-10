<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Rentalbro\Models\Mysql\Product;
use Rentalbro\Models\Mysql\ProductImage;
use Rentalbro\Models\Mysql\Shop;
use Tymon\JWTAuth\JWTAuth;
use Validator;

class ShopController extends ApiController
{
	public function register(JWTAuth $JWTAuth)
	{
		$rules = [
            'name_shop'	=> 'required',
            'url_shop'	=> 'required',
        ];

    	$validator = Validator::make(
    		$this->request->all(),
    		$rules
		);

        if ($validator->fails())
            return $this->response()->error($validator->errors()->all());

        $user =  $JWTAuth->parseToken()->authenticate();

        $shop = new Shop;

        $shop->name = strtolower($this->request->name_shop);
        $shop->url = strtolower($this->request->url_shop);
        $shop->user_ecommerce_id = $user->id;

        if(! $shop->save())
        	return $this->response()->error(['error at save data']);

        $token = $JWTAuth->fromUser($user);
        return $this->response()->success($user, ['meta.token' => $token]);
	}

    public function product_add(JWTAuth $JWTAuth)
    {
        $user =  $JWTAuth->parseToken()->authenticate();
        $token = $JWTAuth->fromUser($user);

        $product = new Product;
        $product->shop_id = $user->shop->id;
        $product->category_id = $this->request->category;
        $product->name = strtolower($this->request->name);
        $product->alias = str_replace(" ", "-", strtolower($this->request->name)."_".$user->id.date('his')) ;
        $product->kind_of_rent = $this->request->kind_of_rent;
        $product->quantity = (int) $this->request->quantity;
        $product->price = (int) $this->request->price;
        $product->weigth = 1;
        $product->image = $this->request->product_image_primary;
        $product->description = $this->request->description;
        $product->save();

        foreach ($this->request->product_images as $key => $value) {
            $ProductImage = new ProductImage;
            $ProductImage->product_id = $product->id;
            $ProductImage->image = $value;
            $ProductImage->save();
        }

        return $this->response()->success($product, ['meta.token' => $token]);
    }
}
