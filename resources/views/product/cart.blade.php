@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <form method="POST" action="{{ route('product.cartPost') }}">
            @csrf
                <div class="col-md-16">
                    @if(count($products) > 0)
                    以下の商品をお買い物かごに追加しました。
                    @else
                    お買い物かごに商品はありません
                    @endif
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
                                    <th scope="col" class="col-md-1">選択</th>
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
                                            <td scope="row">
                                                <input type="checkbox" name="check[]" value="{{ $product["info"]->PRODUCT_CODE }}" {{ is_array(old("check")) && in_array($product["info"]->PRODUCT_CODE, old("check"), true)? 'checked="checked"' : '' }}/>
                                            </td>
                                            <td>{{ $product["info"]->PRODUCT_CODE }}</td>
                                            <td>{{ $product["info"]->PRODUCT_NAME }}</td>
                                            <td>{{ $product["info"]->MAKER}}</td>
                                            <td style="text-align: right">￥{{ number_format($product["info"]->UNIT_PRICE)}}</td>
                                            <td>
                                                <input type="number" name="{{ $product["info"]->PRODUCT_CODE }}Quantity" style="text-align:right" @if(old($product["info"]->PRODUCT_CODE."Quantity") != null) value="{{ old($product["info"]->PRODUCT_CODE."Quantity") }}" @endif value="{{ $product["value"] }}"/>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="form-group row mb-0">
                                <div style="margin: 0 auto;">
                                    <button style="margin: 0 5px;" type="submit" name="clear" value="clear" class="btn btn-warning">
                                        取り消し
                                    </button>
                                    <button style="margin: 0 5px;" type="submit" name="delete" value="delete" class="btn btn-danger">
                                        買い物をやめる
                                    </button>
                                    @if(count($products) > 0)
                                    <button style="margin: 0 5px;"type="submit" class="btn btn-primary">
                                        注文する
                                    </button>
                                    @endif
                                    <a href="{{ route("home") }}">
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
