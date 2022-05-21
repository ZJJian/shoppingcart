<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
        <link href="/styles.css" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
        <header>
            <div class="content-wrapper">
                <h1>Shopping Cart System</h1>
{{--                <nav>--}}
{{--                    <a href="index.php">Home</a>--}}
{{--                    <a href="index.php?page=products">Products</a>--}}
{{--                </nav>--}}
                <div class="link-icons">
                    <a href="index.php?page=cart">
						<i class="fas fa-shopping-cart"></i>
					</a>
                </div>
            </div>
        </header>
        <main>

            <div class="products content-wrapper">
                <h1>Products</h1>
                <p><?=count($data)?> Products</p>
                <div class="products-wrapper">
                    <?php foreach ($data as $product): ?>
                    <a class="product">
                        <img src="imgs/<?=$product['image']?>" width="200" height="200" alt="<?=$product['name']?>">
                        <span class="name"><?=$product['name']?></span>
                        <span class="price">
                &dollar;<?=$product['price']?>
<!--                            --><?php //if ($product['rrp'] > 0): ?>
{{--                <span class="rrp">&dollar;<?=$product['rrp']?></span>--}}
<!--                --><?php //endif; ?>
                        </span>
                    </a>
                    <?php endforeach; ?>
                </div>
{{--                <div class="buttons">--}}
{{--                    <?php if ($current_page > 1): ?>--}}
{{--                    <a href="index.php?page=products&p=<?=$current_page-1?>">Prev</a>--}}
{{--                    <?php endif; ?>--}}
{{--                    <?php if ($total_products > ($current_page * $num_products_on_each_page) - $num_products_on_each_page + count($products)): ?>--}}
{{--                    <a href="index.php?page=products&p=<?=$current_page+1?>">Next</a>--}}
{{--                    <?php endif; ?>--}}
{{--                </div>--}}
            </div>
        </main>
        <footer>
            <div class="content-wrapper">
                <p>&copy; 2022, Shopping Cart System</p>
            </div>
        </footer>
        <script src="script.js"></script>
    </body>
</html>

