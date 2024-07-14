<?php
session_start();

$action = isset($_GET['action']) ? $_GET['action'] : '';
$product = isset($_GET['product']) ? json_decode(urldecode($_GET['product']), true) : null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="style_browse.css"/>
   
</head>
<body>
    <div class="container">
        <h1>Your Cart</h1>
        <?php
        if ($action === 'buy' && $product) {
            // Display the product being bought directly
            ?>
            <div class="product-details">
                <h2>Buying: <?php echo htmlspecialchars($product['product_name']); ?></h2>
                <p>UPI Code: <?php echo htmlspecialchars($product['upi_code']); ?></p>
                <form action="complete_purchase.php" method="post">
                    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>">
                    <input type="hidden" name="upi_code" value="<?php echo htmlspecialchars($product['upi_code']); ?>">
                    <label for="address">Delivery Address:</label>
                    <textarea id="address" name="address" required></textarea>
                    <button type="submit">Complete Purchase</button>
                </form>
            </div>
            <?php
        } elseif ($action === 'add_to_bag' || !empty($_SESSION['cart'])) {
            // Display the cart contents
            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $cartItem) {
                    ?>
                    <div class="product-details">
                        <h2><?php echo htmlspecialchars($cartItem['product_name']); ?></h2>
                        <p>UPI Code: <?php echo htmlspecialchars($cartItem['upi_code']); ?></p>
                    </div>
                    <?php
                }
                ?>
                <form action="complete_purchase.php" method="post">
                    <label for="address">Delivery Address:</label>
                    <textarea id="address" name="address" required></textarea>
                    <label for="transaction-photo">Transaction Photo:</label>
                    <input type="file" name="transaction-photo" id="transaction-photo" required>
                    <button type="submit" onclick="myFunction()">Complete Purchase</button>
                    <p id="demo"></p>

                </form>
                <?php
            } else {
                echo "<p>Your cart is empty.</p>";
            }
        } else {
            echo "<p>No action specified.</p>";
        }
        ?>
        <script>
function myFunction() {
  document.getElementById("demo").innerHTML = "Hello World";
}
</script>
    </div>
</body>
</html>