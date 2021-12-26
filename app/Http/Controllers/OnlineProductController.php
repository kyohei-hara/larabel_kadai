<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OnlineProduct;
use App\Models\OnlineOrder;
use App\Models\OnlineOrderList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class OnlineProductController extends Controller
{


    public $MSG006 = '商品を選択してください。';
    public $MSG007 = '購入数は1～999の数値で入力してください。';
    public $tax = 0.1;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $has_session = $request->session()->has("cart");
        if(!$has_session){
            $request ->session()->put("cart", array());
        }
        $search = $request->input('search');
        $query = OnlineProduct::Select('PRODUCT_CODE', 'CATEGORY_ID', 'PRODUCT_NAME', 'MAKER', 'UNIT_PRICE' , 'MEMO');
        $name = null;
        $maker = null;
        $max = null;
        $min = null;
        $category = null;
        if($search !== null){
            $name = $request->input('PRODUCT_NAME');
            $maker = $request->input('MAKER');
            $max = $request->input('max');
            $min = $request->input('min');
            $category = $request->input('category');
            $this->validator($request->all())->validate();

            if($category !== "ALL") {
                $query->where('CATEGORY_ID',$category);
            }
            if($name !== null) {
                $query->where('PRODUCT_NAME','like','%'.$name.'%');
            }
            if($maker !== null) {
                $query->where('MAKER','like','%'.$maker.'%');
            }
            if($max !== null){
                $query->where('UNIT_PRICE','<', $max + 1);
            }
            if($min !== null){
                $query->where('UNIT_PRICE','>',$min - 1);
            }

        }
        $products = $query->where('DELETE_FLG', 0)->paginate(10);

        return view('product.index', compact('products'))->with([
            'category'=>$category,
            'PRODUCT_NAME'=>$name,
            'MAKER'=>$maker,
            'min'=>$min,
            'max'=>$max,
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'min' => ['null_numeric', 'positive'],
            'max' => ['null_numeric', 'positive', 'comparison:min'],
        ]);
    }


    public function stock (Request $request) {
        function returnView (Request $request, $message) {
            if($message != null) {
                return redirect('product/index')->with(['erred'=>$message])->withInput();
            }
        }
        $productsChecked = $request->input('check');


        $query = OnlineProduct::Select("*");
        /**
         * １件も選択されていない場合早期return
         */
        if($productsChecked == null || count($productsChecked) == 0) {
            return returnView($request,$this->MSG006);
        };
        /**
         * チェックした商品一覧に個数が入っていないものをチェック
         */
        $getQuantityList = array();
        foreach($productsChecked as $key => $value) {
            $name = $value."Quantity";
            $getQuantity = $request->input($name);
            if($getQuantity == null || !is_numeric($getQuantity) || $getQuantity == 0 || $getQuantity > 999) {
               return returnView($request, $this->MSG007);
            }
            $getQuantityList[$value] = $getQuantity;
        };
        $purchaseList = array();
        /**
         * 商品一覧が購入できるか判定
         */
        $sessionCart = $request->session()->get("cart");
        if($sessionCart != null && $sessionCart["products"] != null) {
            $purchaseList = $sessionCart["products"];
        }
        foreach($getQuantityList as $key => $value) {
            $quantity = 0;

            if(isset($purchaseList[$key])) {
                $quantity = $purchaseList[$key]["value"];
            };
            $quantity = $quantity + $value;
            $query = OnlineProduct::select("*");

            $result = $query->where('PRODUCT_CODE', $key)->where('STOCK_COUNT', ">" , $quantity)->get();

            if(count($result) == 0) {
               return returnView($request,"商品コード". $key . "の購入数が在庫数量を超えています。");
            };
            $purchaseList[$key] = ["value" =>$quantity];
        };
        $request->session()->put("cart", ["id"=>Auth::check() ? Auth::user()->MEMBER_NO: 0,"products"=>$purchaseList]);

        return redirect()->action("OnlineProductController@cart");
    }


    public function show(Request $request, $id)
    {
        $has_session = $request->session()->has("cart");
        if(!$has_session){
            $request ->session()->put("cart", array());
        }
        $product = OnlineProduct::find($id);
        return view('product.show', compact('product'));

    }

    public function add(Request $request, $id)
    {
        $query = OnlineProduct::select("*");
        $value = $request->input("quantity");
        if($value == null || !is_numeric($value) || $value == 0 || $value > 999) {
             return redirect("product/show/".$id)->with([
                 "message"=>$this->MSG007
             ])->withInput();
        }
        $purchaseList = array();
        /**
         * 商品一覧が購入できるか判定
         */
        $sessionCart = $request->session()->get("cart");
        if($sessionCart != null && $sessionCart["products"] != null) {
            $purchaseList = $sessionCart["products"];
        }
        $quantity = 0;

        if(isset($purchaseList[$id])) {
            $quantity = $purchaseList[$id]["value"];
        };
        $quantity = $quantity + $value;
        $result = $query->where('PRODUCT_CODE', $id)->where('STOCK_COUNT', ">" , $quantity)->get();

        if(count($result) == 0) {
            return redirect("product/show/".$id)->with([
                 "message"=>"購入数が在庫数量を超えています。"
             ])->withInput();
        };
        $purchaseList[$id] = ["value" =>$quantity];

        $request->session()->put("cart", ["id"=>Auth::check() ? Auth::user()->MEMBER_NO: 0,"products"=>$purchaseList]);
        return redirect()->action("OnlineProductController@cart");
    }

    public function cart(Request $request){
        $product = array();
        $cart = $request->session()->get("cart");
        $products = array();
        if($cart != null && $cart != []) {
            $products = $cart["products"];
            if(isset($products) && count($products) > 0){
                foreach($products as $key => $value){
                    $query = OnlineProduct::select("*");
                    $product = $query->where('PRODUCT_CODE', $key)->get();
                    $value["info"] = $product[0];
                    $products[$key] = $value;
                }
            }
        }
        $cart["products"] = $products;
        $request->session()->put("cart", ["id"=>Auth::check() ? Auth::user()->MEMBER_NO: 0,"products"=>$products]);

        return view('product.cart', compact("products"));
    }

    public function cartPost(Request $request){
        $clear = $request->input('clear');
        $delete = $request->input('delete');
        $productsChecked = $request->input('check');
        $cart = $request->session()->get("cart");
        $products = $cart["products"];
        /**
         * クリア押下時
         */
        if($clear != null) {
            if($productsChecked == null || count($productsChecked) == 0) {
                return redirect()->action("OnlineProductController@cart")->with([
                    "message"=>"取り消し対象の商品を選択してください。"
                ]);
            };
            foreach($productsChecked as $key => $value) {
                unset($products[$value]);
            };
            $request->session()->put("cart", ["id"=>Auth::check() ? Auth::user()->MEMBER_NO: 0,"products"=>$products]);
            return redirect()->action("OnlineProductController@cart");
        }
        if($delete != null){
            session()->put("cart",["id"=>Auth::check() ? Auth::user()->MEMBER_NO: 0,"products"=>[]]);
            return view("home");
        }
        /**
         * １件も選択されていない場合早期return
         */
        if($productsChecked == null || count($productsChecked) == 0) {
            return redirect()->action("OnlineProductController@cart")->with([
                "message"=>$this->MSG006
            ])->withInput();
        };

        /**
         * 購入できるか
         */
        $buyProducts = array();
        foreach($productsChecked as $key => $value) {
            $name = $value."Quantity";
            $quantity = $request->input($name);
            if($quantity == null || !is_numeric($quantity) || $quantity == 0 || $quantity > 999) {
              return redirect()->action("OnlineProductController@cart")->with([
                    "message"=>"商品コード". $value . $this->MSG007
                ])->withInput();
            };
            $query = OnlineProduct::select("*");

            $result = $query->where('PRODUCT_CODE', $value)->where('STOCK_COUNT', ">" , $quantity)->get();
            if(count($result) == 0) {
                return redirect()->action("OnlineProductController@cart")->with([
                    "message"=>"商品コード". $value . "在庫が足りません。購入数を変更してください。"
                ])->withInput();
            };
            $buyProducts[$value] = $quantity;
        };
        $request->session()->put("cartConfirm",$buyProducts);
        return redirect()->action("OnlineProductController@confirm");
    }

    public function confirm(Request $request){
        $cart = $request->session()->get("cartConfirm");
        $query = OnlineProduct::select("*");

        $subtotal = 0;
        $cartList = array();
            foreach($cart as $key => $value){
                $query = OnlineProduct::select("*");

                $products = $query->where('PRODUCT_CODE', $key)->get();
                $product = ["info" =>  $products[0], "quantity" => $value];
                $cartList[$key] = $product;
                $subtotal +=  ($products[0]->UNIT_PRICE) * $value;
            }
        $tax = $subtotal * $this->tax;
        $cartInfo = [
            "subtotal"=>$subtotal,
            "tax"=>floor($tax),
            "products"=>$cartList
        ];
        $request->session()->put("cartInfo",$cartInfo);
        return view("product.confirm")->with([
            "cartInfo"=>$cartInfo,
            "products"=>$cartInfo["products"]
        ]);
    }
    function viewConfirm(Request $request){
        $cartInfo = $request->session()->get("cartInfo");
         return view("product.confirm")->with([
            "cartInfo"=>$cartInfo,
            "products"=>$cartInfo["products"]
        ]);
    }

    function purchase(Request $request){
        $delete = $request->input('delete');
        if($delete != null) {
            session()->put('cart',array());
            return view('home');
        }
        if(!Auth::check()){
            return view("auth.login");
        }
        $cartInfo = $request->session()->get("cartInfo");

        DB::transaction(function () use($cartInfo){
            $orderDB = new OnlineOrder;
            $orderListDB = new OnlineOrderList;
            $productDB = new OnlineProduct;
            $no = $orderDB->getId();
            $products = $cartInfo["products"];
            $orderDB->add(Auth::user()->MEMBER_NO,$cartInfo["subtotal"],$cartInfo["tax"], $no);
            foreach($products as $key =>$value){
                $orderListDB = new OnlineOrderList;
                $productDB = new OnlineProduct;
                $product = $products[$key];
                $orderListDB->add($no, $key, $value["quantity"], $product["info"]->UNIT_PRICE);
                $productDB->reduce($key, $value["quantity"]);
            }
        });
        $request->session()->put("cart", []);
        $request->session()->put("cartInfo", []);

        return redirect()->action("OnlineProductController@viewComplete");
    }

    public function viewComplete() {
        if(!Auth::check()){
            return view("home");
        }
        return view("product.complete");
    }
}