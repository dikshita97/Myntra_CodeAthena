<?php
if (isset($_GET['name'])) {
    $productName = htmlspecialchars($_GET['name']);

    // Load the products from the JSON file
    $productsFile = 'products.json';
    if (file_exists($productsFile)) {
        $products = json_decode(file_get_contents($productsFile), true);

        // Find the product by name
        foreach ($products as $product) {
            if ($product['product_name'] === $productName) {
                $productDetails = $product;
                break;
            }
        }

        if (isset($productDetails)) {
            // Display the product details
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title><?php echo htmlspecialchars($productDetails['product_name']); ?></title>
                <link rel="stylesheet" href="style3.css"/>
                <style>
                    .product-details {
                        width: 80%;
                        margin: auto;
                        padding: 20px;
                        border: 1px solid #ddd;
                        border-radius: 5px;
                        text-align: center;
                    }
                    .product-details img {
                        max-width: 100%;
                        height: auto;
                        margin-bottom: 20px;
                    }
                    .popup-overlay {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(0, 0, 0, 0.5);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        visibility: hidden;
                        opacity: 0;
                        transition: visibility 0s, opacity 0.2s;
                    }
                    .popup-content {
                        background: #fff;
                        padding: 20px;
                        border-radius: 5px;
                        width: 80%;
                        max-width: 600px;
                        text-align: center;
                    }
                    .popup-content img {
                        max-width: 100%;
                        height: auto;
                        margin-bottom: 20px;
                    }
                    .popup-close {
                        position: absolute;
                        top: 10px;
                        right: 10px;
                        background: #ccc;
                        border: none;
                        padding: 5px 10px;
                        cursor: pointer;
                        border-radius: 5px;
                    }
                </style>
            </head>
            <body>
            <div class="product-details">
                <h1><?php echo htmlspecialchars($productDetails['product_name']); ?></h1>
                <?php
                foreach ($productDetails['photos'] as $photo) {
                    echo '<img src="' . htmlspecialchars($photo) . '" alt="' . htmlspecialchars($productDetails['product_name']) . '" onclick="showPopup(this)">';
                }
                ?>
                <p>Material: <?php echo htmlspecialchars($productDetails['material_details']); ?></p>
                <p>Size: <?php echo htmlspecialchars($productDetails['size']); ?></p>
                <p>Price: $<?php echo htmlspecialchars($productDetails['price']); ?></p>
                <form action="purchase.php" method="post">
                    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($productDetails['product_name']); ?>">
                    <input type="hidden" name="upi_code" value="<?php echo htmlspecialchars($productDetails['upi_code']); ?>">
                    <button type="submit" name="action" value="buy">Buy</button>
                    <button type="submit" name="action" value="add_to_bag">Add to Bag</button>
                </form>
            </div>

            <div class="popup-overlay" id="popup-overlay">
                <div class="popup-content">
                    <button class="popup-close" onclick="closePopup()">Close</button>
                    <div id="popup-images"></div>
                    <p>Material: <?php echo htmlspecialchars($productDetails['material_details']); ?></p>
                    <p>Size: <?php echo htmlspecialchars($productDetails['size']); ?></p>
                    <p>Price: $<?php echo htmlspecialchars($productDetails['price']); ?></p>
                    <form action="purchase.php" method="post">
                        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($productDetails['product_name']); ?>">
                        <input type="hidden" name="upi_code" value="<?php echo htmlspecialchars($productDetails['upi_code']); ?>">
                        <button type="submit" name="action" value="buy">Buy</button>
                        <button type="submit" name="action" value="add_to_bag">Add to Bag</button>
                    </form>
                </div>
            </div>

            <script>
                function showPopup(image) {
                    const popupOverlay = document.getElementById('popup-overlay');
                    const popupImages = document.getElementById('popup-images');
                    popupImages.innerHTML = ''; // Clear previous images
                    const productImages = <?php echo json_encode($productDetails['photos']); ?>;
                    productImages.forEach(src => {
                        const img = document.createElement('img');
                        img.src = src;
                        popupImages.appendChild(img);
                    });
                    popupOverlay.style.visibility = 'visible';
                    popupOverlay.style.opacity = 1;
                }

                function closePopup() {
                    const popupOverlay = document.getElementById('popup-overlay');
                    popupOverlay.style.visibility = 'hidden';
                    popupOverlay.style.opacity = 0;
                }
            </script>
            </body>
            </html>
            <?php
        } else {
            echo "Product not found.";
        }
    } else {
        echo "Products file not found.";
    }
} else {
    echo "No product specified.";
}
?>
