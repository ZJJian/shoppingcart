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
                        <a name="{{$product['sku']}}" onclick="addOnClick(this)" class="btn btn-warning btn-block text-center" role="button">
                            Add to cart
                        </a>
                    </p>
                </div>
            @endforeach
        </div>
    </div>
@endsection


<script>
    function addOnClick(selectObject) {
        var sku = selectObject.name;
        console.log(selectObject.name);
        addItem(sku);
    }

    function addItem(sku) {
        $.ajaxSetup({
            headers:
                {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

        $.ajax({
            type: 'post',
            url: '{{ route('cart.add', false) }}/',
            data: {
                "id": sku
            },
            dataType: 'json',
            success: function (response) {
                if(response.results.status !== 200){
                    alert(response.results.msg);
                }
                location.reload(true);
            },

            error: function (XMLHttpRequest) {
                alert(JSON.stringify(XMLHttpRequest));
            }
        });
    }

</script>
