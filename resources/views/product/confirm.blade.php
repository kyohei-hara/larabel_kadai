@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <form method="POST" action="{{ route('product.purchase') }}">
            @csrf
                <div class="col-md-16">
                    <div class="card">
                        <div class="card-header">商品一覧</div>
                        @if(session('message'))
                            <div class="text-danger" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col" class="col-md-2">商品コード</th>
                                    <th scope="col" class="col-md-2">商品名</th>
                                    <th scope="col" class="col-md-2">販売元</th>
                                    <th scope="col" class="col-md-2">価格</th>
                                    <th scope="col" class="col-md-1">購入数</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{ $product["info"]->PRODUCT_CODE }}</td>
                                            <td>{{ $product["info"]->PRODUCT_NAME }}</td>
                                            <td>{{ $product["info"]->MAKER}}</td>
                                            <td style="text-align: right">￥{{ number_format($product["info"]->UNIT_PRICE)}}</td>
                                            <td style="text-align: right">{{ $product["quantity"] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-18">
                    <div class="card">
                        <div class="card-header">料金</div>
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="col" class="col-md-2" style="text-align: center">小計</th>
                                        <td scope="col" class="col-md-6" style="text-align: right">￥{{ number_format($cartInfo["subtotal"])}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col" class="col-md-2" style="text-align: center">消費税</th>
                                        <td scope="col" class="col-md-6" style="text-align: right">￥{{ number_format($cartInfo["tax"])}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col" class="col-md-2" style="text-align: center">合計金額</th>
                                        <td scope="col" class="col-md-6" style="text-align: right">￥{{ number_format($cartInfo["subtotal"] + $cartInfo["tax"])}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="form-group row mb-0" style="display: block; text-align:right;">
                                <div>
                                    <button style="margin: 0 5px;" type="submit" name="delete" value="delete" class="btn btn-danger">
                                        買い物をやめる
                                    </button>
                                    <button style="margin: 0 5px;"type="submit" class="btn btn-primary">
                                        注文する
                                    </button>
                                    <a href="{{ route("product.cart") }}">
                                        <button style="margin: 0 5px;" type="button" class="btn btn-light">
                                            戻る
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
