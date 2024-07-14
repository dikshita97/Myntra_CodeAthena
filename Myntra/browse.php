<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Products</title>
    <link rel="stylesheet" href="style_browse.css"/>
    <style>
        .product {
            display: inline-block;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 200px;
            text-align: center;
        }
        .product img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Browse Products</h1>
    <div class="product-list">
        <?php
        $productsFile = 'products.json';
        if (file_exists($productsFile)) {
            $products = json_decode(file_get_contents($productsFile), true);
            foreach ($products as $product) {
                echo '<div class="product">';
                echo '<a href="product.php?name=' . urlencode($product['product_name']) . '">';
                echo '<img src="' . htmlspecialchars($product['photos'][0]) . '" alt="' . htmlspecialchars($product['product_name']) . '">';
                echo '<p>' . htmlspecialchars($product['product_name']) . '</p>';
                echo '</a>';
                echo '</div>';
            }
        }
        ?>
    </div>
</div>

</body>
</html>
