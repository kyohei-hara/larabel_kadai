<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OnlineProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class OnlineProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $has_session = $request->session()->has(Auth::user()->MEMBER_NO);
        if(!$has_session){
            $request ->session()->put(Auth::user()->MEMBER_NO, array());
        }
        $search = $request->input('search');
        $query = DB::table('online_product');
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
        $products = $query->select('PRODUCT_CODE', 'CATEGORY_ID', 'PRODUCT_NAME', 'MAKER', 'UNIT_PRICE' , 'MEMO')->where('DELETE_FLG', 0)->paginate(10);
        $request->session()->put("products", $products);
        $request->session()->put("category", $category);
        $request->session()->put("name", $name);
        $request->session()->put("MAKER", $maker);
        $request->session()->put("min", $min);
        $request->session()->put("max", $max);

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

            /**
             * 検索結果を残しとくため取得
             */
            $products = $request->session()->get("products");
            $category = $request->session()->get("category");
            $name = $request->session()->get("name");
            $maker = $request->session()->get("MAKER");
            $min = $request->session()->get("min");
            $max = $request->session()->get("max");
            if($message != null) {
                return view('product.index', compact("products"))->with([
                    'category'=>$category,
                    'PRODUCT_NAME'=>$name,
                    'MAKER'=>$maker,
                    'min'=>$min,
                    'max'=>$max,
                    'erred'=>$message
                ]);
            }
            return view('product.index', compact("products"))->with([
                'category'=>$category,
                'PRODUCT_NAME'=>$name,
                'MAKER'=>$maker,
                'min'=>$min,
                'max'=>$max,
            ]);
        }
        $productsChecked = $request->input('check');


        $query = DB::table('online_product');
        /**
         * １件も選択されていない場合早期return
         */
        if($productsChecked == null || count($productsChecked) == 0) {
            return returnView($request,"商品を選択してください。");
        };
        /**
         * チェックした商品一覧に個数が入っていないものをチェック
         */
        $getQuantityList = array();
        foreach($productsChecked as $key => $value) {
            $name = $value."Quantity";
            $getQuantity = $request->input($name);
            if($getQuantity == null || !is_numeric($getQuantity) || $getQuantity == 0 || $getQuantity > 999) {
               return returnView($request,"購入数は1～999の数値で入力してください。");
            }
            $getQuantityList[$value] = $getQuantity;
        };
        $purchaseList = array();
        /**
         * 商品一覧が購入できるか判定
         */
        $userSession = $request->session()->get(Auth::user()->MEMBER_NO);
        if($userSession != null) {
            $purchaseList = $userSession;
        }
        foreach($getQuantityList as $key => $value) {
            $quantity = 0;

            if(isset($purchaseList[$key])) {
                $quantity = $purchaseList[$key];
            };
            $quantity = $quantity + $value;
            $query = DB::table('online_product');
            $result = $query->where('PRODUCT_CODE', $key)->where('STOCK_COUNT', ">" , $quantity)->get();

            if(count($result) == 0) {
               return returnView($request,"商品コード". $key . "の購入数が在庫数量を超えています。");
            };
            $purchaseList[$key] = $quantity;
        };
        $request->session()->put(Auth::user()->MEMBER_NO, $purchaseList);
        return redirect()->action("OnlineProductController@confirm");
    }

    public function confirm(Request $request, $redirectPurchaseList = array()){
        $query = DB::table('online_product');
        $productList = array();
        $products = $request->session()->get(Auth::user()->MEMBER_NO);
        if(isset($products) && count($products) > 0){
            foreach($products as $key => $value){
                $query = DB::table('online_product');
                $product = $query->where('PRODUCT_CODE', $key)->get();
                $productList[$key] = $product[0];
            }
        }

        return view('product.cart', compact("productList"))->with([
            'productQuantity'=>$products,
        ]);

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $contact = ContactForm::find($id);
        // $contact->delete();

        return redirect('contact/index');

    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
