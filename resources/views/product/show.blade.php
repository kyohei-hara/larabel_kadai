@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">商品詳細</div>
                        <div class="card-body">

                            <form method="POST" action="{{ route('product.add', ['id' => $product->PRODUCT_CODE ] ) }}">
                            @csrf
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th scope="col" class="col-md-2" style="text-align: center">商品名</th>
                                            <td scope="col" class="col-md-6">{{ $product->PRODUCT_NAME }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col" class="col-md-2" style="text-align: center">画像</th>
                                            <td scope="col" class="col-md-6"><img src="{{ $product->PICTURE_NAME }}" width="500px" height="auto"/></td>
                                        </tr>
                                        <tr>
                                            <th scope="col" class="col-md-2" style="text-align: center">商品説明</th>
                                            <td scope="col" class="col-md-6">{{ $product->MEMO }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col" class="col-md-2" style="text-align: center">価格</th>
                                            <td scope="col" class="col-md-6" style="text-align: right">￥{{ number_format($product->UNIT_PRICE)}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col" class="col-md-2" style="text-align: center">購入数</th>
                                            <td scope="col" class="col-md-6" style="text-align: right">
                                                <input type="number" name="quantity" style="text-align:right" value="{{ old('quantity') }}" />個
                                                <br>
                                                @if(session('message'))
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ session('message') }}</strong>
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="form-group row mb-0">
                                    <div style="margin-left: auto">
                                        <input type="hidden" name="code" value="{{ $product->PRODUCT_CODE }}" />
                                        <button type="submit" class="btn btn-primary">
                                            お買い物かごに入れる
                                        </button>
                                        <a href="{{ route("product") }}">
                                            <button type="button" class="btn btn-light">
                                                戻る
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
