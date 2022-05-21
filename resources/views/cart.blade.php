@extends('layout')
@section('title', 'Cart')
@section('content')

    <div class="cart content-wrapper">
        <h1>Shopping Cart</h1>
        <form action="index.php?page=cart" method="post">
            <table>
                <thead>
                <tr>
                    <td colspan="2">Product</td>
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
                    @foreach ($data as $key=>$product)
                        <tr>
                            <td class="img">
                                <a>
                                    <img src="static/imgs/{{$product['image']}}" width="50" height="50" alt="{{$product['name']}}">
                                </a>
                            </td>
                            <td>
                                <a>{{$product['name']}}</a>
                                <br>
                                <a class="remove">Remove</a>
                            </td>
                            <td class="price">&dollar;{{$product['price']}}</td>
                            <td class="quantity">
                                <input type="number" name="quantity-{{$key}}" value="{{$product['quantity']}}" min="1"
                                       max="10" placeholder="Quantity" required>
                            </td>
                            <td class="price">&dollar;{{$product['price'] * $product['quantity']}}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
            <div class="subtotal">
                <span class="text">Subtotal</span>
                <span class="price">&dollar; 100</span>
            </div>
            <div class="buttons">
                <input type="submit" value="Update" name="update">
                <input type="submit" value="Place Order" name="placeorder">
            </div>
        </form>
    </div>

@endsection
