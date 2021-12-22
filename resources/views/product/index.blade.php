@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-left">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">商品検索</div>

                    <div class="card-body">
                        @if(count($products) == 0)
                            条件に該当する商品は０件です。
                        @endif
                        <form method="GET" action="{{ route('product') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="categoru" class="col-md-4 col-form-label text-md-right">商品カテゴリ</label>

                                <div class="col-md-6">
                                    <select name="category" id="category" class="form-control">
                                        <option value="ALL" @if( $category == "ALL" || $category == null ) selected @endif>全て</option>
                                        <option value="1" @if( $category == 1 ) selected @endif>スナック</option>
                                        <option value="2" @if( $category == 2 ) selected @endif>チョコレート</option>
                                        <option value="3" @if( $category == 3 ) selected @endif>飴</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="PRODUCT_NAME" class="col-md-4 col-form-label text-md-right">商品名</label>

                                <div class="col-md-6">
                                    <input id="PRODUCT_NAME" type="text" class="form-control @error('PRODUCT_NAME') is-invalid @enderror" name="PRODUCT_NAME" value="{{ $PRODUCT_NAME }}" autocomplete="PRODUCT_NAME" autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="MAKER" class="col-md-4 col-form-label text-md-right">販売元</label>

                                <div class="col-md-6">
                                    <input id="MAKER" type="text" class="form-control @error('MAKER') is-invalid @enderror" name="MAKER" value="{{ $MAKER }}" autocomplete="MAKER" autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="max" class="col-md-4 col-form-label text-md-right">金額上限</label>

                                <div class="col-md-6">
                                    <input id="max" type="text" class="form-control @error('max') is-invalid @enderror" name="max" value="{{ $max }}" autocomplete="max" autofocus style="text-align:right">

                                    @error('max')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="min" class="col-md-4 col-form-label text-md-right">金額下限</label>

                                <div class="col-md-6">
                                    <input id="min" type="text" class="form-control @error('min') is-invalid @enderror" name="min" value="{{ $min }}" autocomplete="min" autofocus style="text-align:right">

                                    @error('min')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" name="search" value="search" class="btn btn-primary">
                                        検索
                                    </button>

                                    <button type="button" onclick="cleare()" class="btn btn-light">
                                        クリア
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="justify-content-center">
            <form method="POST" action="{{ route('product') }}">
            @csrf
                <div class="col-md-16">
                    @if(isset($erred))
                        {{ $erred }}
                    @endif
                    <div class="card">
                        <div class="card-header">商品一覧</div>
                        <div class="card-body">

                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col" class="col-md-1">選択</th>
                                    <th scope="col" class="col-md-2">商品コード</th>
                                    <th scope="col" class="col-md-2">商品名</th>
                                    <th scope="col" class="col-md-2">販売元</th>
                                    <th scope="col" class="col-md-2">金額(単価)</th>
                                    <th scope="col" class="col-md-2">メモ</th>
                                    <th scope="col" class="col-md-1">購入数</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td scope="row">
                                                <input type="checkbox" name="check[]" value="{{ $product->PRODUCT_CODE }}" />
                                            </td>
                                            <td>{{ $product->PRODUCT_CODE }}</td>
                                            <td>{{ $product->PRODUCT_NAME }}</td>
                                            <td>{{ $product->MAKER}}</td>
                                            <td style="text-align: right">￥{{ number_format($product->UNIT_PRICE)}}</td>
                                            <td>{{ mb_strimwidth( $product->MEMO, 0, 40, '・・・', 'UTF-8' )}}</td>
                                            <td>
                                                <input type="number" name="{{ $product->PRODUCT_CODE }}Quantity" style="text-align:right" />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row justify-content-center">
                                {{ $products->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                    @if (count($products) > 0)
                        <button type="submit" style="display:block; margin: 10px auto 0;" name="search" value="search" class="btn btn-primary">
                            お買い物かごに入れる
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
