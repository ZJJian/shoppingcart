@extends('layout')
@section('title', 'Checkout')
@section('content')

    <div class="cart content-wrapper">
        <h1>Checkout</h1>
        <div class="flex-container">
            <div class="item" id="DIV1">
                <form method="POST" action="{{ route('checkout.submit') }}">
                    @csrf

                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                        <div class="col-md-6">
                            <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" required>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="phone" class="col-md-4 col-form-label text-md-end">Phone</label>

                        <div class="col-md-6">
                            <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" required>

                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="address" class="col-md-4 col-form-label text-md-end">Address</label>

                        <div class="col-md-6">
                            <textarea id="address" type="address" class="form-control @error('address') is-invalid @enderror" name="address" required></textarea>
                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="buttons" style="text-align: left;">
{{--                        <a href="{{ route('cart.checkout') }}" class="btn btn-warning btn-block text-center" role="button">--}}
                            <input type="submit" value="Place Order" name="placeorder">
{{--                        </a>--}}
                    </div>
                </form>
            </div>
            <div class="item" id="DIV2">
                <table>
                    <thead>
                    <tr>
                        <td>Product</td>
                        <td>Price</td>
                        <td>Quantity</td>
                        <td>Total</td>
                    </tr>
                    </thead>
                    <tbody>
                    @if(empty($data))
                        <tr>
                            <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
                        </tr>
                    @else
                        <?php
                        $total_price = 0;
                        ?>
                        @foreach ($data as $key=>$product)
                            <tr>
{{--                                <td class="img">--}}
{{--                                    <a>--}}
{{--                                        <img src="static/imgs/{{$product['image']}}" width="50" height="50" alt="{{$product['name']}}">--}}
{{--                                    </a>--}}
{{--                                </td>--}}
                                <td>
                                    <a>{{$product['name']}}</a>
{{--                                    <br>--}}
{{--                                    <a class="remove" name="{{$key}}" onclick="remove(this)">Remove</a>--}}
                                </td>
                                <td class="price">&dollar;{{$product['price']}}</td>
                                <td class="quantity">{{$product['quantity']}}</td>
                                <td class="line_price">&dollar;{{$product['price'] * $product['quantity']}}</td>
                                <?php
                                $total_price += ($product['price'] * $product['quantity']);
                                ?>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                <div class="subtotal">
                    <span class="text">Subtotal</span>
                    <span class="price">&dollar; {{$total_price ?? 0}}</span>
                </div>
            </div>
        </div>
    </div>

@endsection
