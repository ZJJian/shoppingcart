<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Shop</title>
        <link href="static/css/styles.css" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
        <header>
            <div class="content-wrapper">
                <h1>Shopping Cart System</h1>
                <div class="link-icons">
                    <a href="index.php?page=cart">
						<i class="fas fa-shopping-cart"></i>
                        @if(Session::has('cart') && isset(Session::get('cart')['count']) && Session::get('cart')['count'] > 0)
                            <span> {{ json_encode(Session::get('cart')['count'])}}</span>
                        @endif
					</a>
                </div>
            </div>
        </header>
        <main>

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
                            <p class="btn-holder buttons"><a href="{{ url('add-to-cart/'.$product['sku']) }}" class="btn btn-warning btn-block text-center" role="button">Add to cart</a> </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
        <footer>
            <div class="content-wrapper">
                <p>&copy; 2022, Shopping Cart System</p>
            </div>
        </footer>
        <script src="static/js/script.js"></script>
    </body>
</html>

