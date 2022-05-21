@extends('layout')
@section('title', 'Products')
@section('content')

    <div class="products content-wrapper">
        <h1>Products</h1>
        <p>{{count($data)}} Products</p>
        <div class="products-wrapper">
            @foreach($data as $product)
                <div class="product">
                    <img src="static/imgs/{{$product['image']}}" width="200" height="200" alt="{{$product['name']}}">
                    <span class="name">{{$product['name']}}</span>
                    <span class="price">
                        &dollar;{{$product['price']}}
                    </span>
                    <p class="btn-holder buttons">
                        <a href="{{ route('cart.add', ['id' => $product['sku']]) }}" class="btn btn-warning btn-block text-center" role="button">
                            Add to cart
                        </a>
                    </p>
                </div>
            @endforeach
        </div>
    </div>
@endsection

