@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <form method="POST" action="{{ route('product') }}">
            @csrf
                <div class="col-md-16">
                    @if(count($productList) > 0)
                    以下の商品をお買い物かごに追加しました。
                    @else
                    お買い物かごに商品はありません
                    @endif
                    <div class="card">
                        <div class="card-header">商品一覧</div>
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
                                    @foreach($productList as $product)
                                        <tr>
                                            <td>{{ $product->PRODUCT_CODE }}</td>
                                            <input type="hidden" name="code[]" value="{{ $product->PRODUCT_CODE }}" />
                                            <td>{{ $product->PRODUCT_NAME }}</td>
                                            <td>{{ $product->MAKER}}</td>
                                            <td style="text-align: right">￥{{ number_format($product->UNIT_PRICE)}}</td>
                                            <td>{{ $productQuantity[$product->PRODUCT_CODE] }}</td>
                                            <input type="hidden" name="{{ $product->PRODUCT_CODE }}Quantity" value="{{ $productQuantity[$product->PRODUCT_CODE] }}" />
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="form-group row mb-0">
                                <div class="" style="margin: 0 auto;">
                                    @if(count($productList) > 0)
                                    <button style="margin: 0 5px;"type="submit" name="search" value="search" class="btn btn-primary">
                                        お買い物かごに入れる
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
