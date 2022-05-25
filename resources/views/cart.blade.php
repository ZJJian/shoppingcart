@extends('layout')
@section('title', 'Cart')
@section('content')

    <div class="cart content-wrapper">
        <h1>Shopping Cart</h1>
        <form action="{{ route('checkout.index') }}" method="get">
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
                    <?php
                        $total_price = 0;
                    ?>
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
                                <a class="remove" name="{{$key}}" onclick="remove(this)">Remove</a>
                            </td>
                            <td class="price">&dollar;{{$product['price']}}</td>
                            <td class="quantity">
                                <select name="{{$key}}"  onchange="qtyOnChange(this)">
                                    @for($i = 1; $i<=$product['qty'] ; $i++)
                                        <option <?php if($product["quantity"]==$i) echo "selected";?>
                                                value="{{$i}}">{{$i}}</option>
                                    @endfor

                                </select>
                            </td>
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
            @if(!empty($data))
                <div class="buttons">
                    <a href="{{ route('checkout.index') }}" class="btn btn-warning btn-block text-center" role="button">
                        <input value="Place Order" name="placeorder">
                    </a>
                </div>
            @endif
        </form>
    </div>

@endsection

<script>
    function qtyOnChange(selectObject) {
        var sku = selectObject.name
        var value = selectObject.value;
        console.log(selectObject.name);
        console.log(selectObject.value);
        updateQty(sku,value);
    }

    function remove(selectObject) {
        var sku = selectObject.name;
        console.log(selectObject.name);
        updateQty(sku, 0);
    }

    function updateQty(sku, value) {
        $.ajaxSetup({
            headers:
                {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

        $.ajax({
            type: 'put',
            url: '{{ route('cart.update', false) }}/',
            data: {
                "id": sku,
                "quantity": value
            },
            dataType: 'json',
            success: function (response) {
                // alert(JSON.stringify(response.results));
                location.reload(true);
            },

            error: function (XMLHttpRequest) {
                alert(JSON.stringify(XMLHttpRequest));
            }
        });
    }

</script>
