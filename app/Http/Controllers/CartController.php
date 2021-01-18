<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Http\Requests\AddCartRequest;
use App\Http\Requests\DeleteCartRequest;
use App\Http\Requests\SyncCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Resources\CartItemListResponse;
use App\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web', ['except' => ['checkout']]);
    }

    public function list(Request $request)
    {
        return CartItemListResponse::collection($this->getCartItems());
    }

    public function getCartItems()
    {
        $user = auth()->user();
        $items =  $user->cart()->with( ["product" => function($query) {
            $query->with('ProductImages')   ;
        }])->get();

        return $items;
    }

    public function checkout(Request $request)
    {
        return view('site.checkout')->with('redirectTo' , 'checkout');
    }

    public function store(AddCartRequest $request, Product $product)
    {

        DB::beginTransaction();
        try {

            $user = auth()->user();
            $cart = Cart::firstOrCreate([
                'user_id' => $user->id,
                'product_id' => $product->id
            ]);
            $cart->qty = $request->input('qty');
            $cart->status = true;
            $cart->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            info($e->getMessage());

            return response("Can't Process, Please Contact Admin", 500);
        }

        return CartItemListResponse::collection($this->getCartItems());
    }

    public function update(UpdateCartRequest $request, Product $product)
    {
        DB::beginTransaction();
        try {
            $cart = Cart::where('product_id', $product->id)->first();
            $cart->qty = $request->input('qty');
            $cart->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            info($e->getMessage());

            return response("Can't Process, Please Contact Admin", 500);
        }

        return CartItemListResponse::collection($this->getCartItems());
    }

    public function updateStatus(Request $request, Product $product)
    {
        DB::beginTransaction();

        try {
            $cart = Cart::where('product_id', $product->id)->first();
            $cart->status = $request->input('status') == 'true' ? 1 : 0;
            $cart->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            info($e->getMessage());

            return response("Can't Process, Please Contact Admin", 500);
        }

        return CartItemListResponse::collection($this->getCartItems());
    }

    public function delete(DeleteCartRequest $request, Product $product)
    {
        DB::beginTransaction();
        try {
            $cart = Cart::where('product_id', $product->id)->first();
            $cart->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            info($e->getMessage());

            return response("Can't Process, Please Contact Admin", 500);
        }

        return CartItemListResponse::collection($this->getCartItems());
    }

    public function deleteAll()
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            $user->cart()->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            info($e->getMessage());

            return response("Can't Process, Please Contact Admin", 500);
        }

        return response(['status' => 'Cart was empty'], 200);
    }

    public function syncCart(SyncCartRequest $request)
    {
        DB::beginTransaction();
        try {
            $products = $request->input('items');
            $user = auth()->user();
            foreach($products as $slug  => $cartInfo) {
                $product = Product::where('slug', $slug)->first();
                if($product) {
                    $cart = Cart::firstOrCreate([
                        'user_id' => $user->id,
                        'product_id' => $product->id
                    ]);
                    $cart->qty = $cartInfo['qty'] <= 0 ? 1 : $cartInfo['qty'];
                    $cart->status = $cartInfo['status'] == 'true' ? 1 : 0;
                    $cart->save();
                }
            }
            DB::commit();

            return CartItemListResponse::collection($this->getCartItems());

        } catch (Exception $e) {
            DB::rollback();
            info($e->getMessage());

            return response("Can't Process, Please Contact Admin", 500);
        }

    }
}
