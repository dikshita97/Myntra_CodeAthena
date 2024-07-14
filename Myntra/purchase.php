<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $productName = htmlspecialchars($_POST['product_name']);
    $upiCode = htmlspecialchars($_POST['upi_code']);

    // Check if the product data is set
    if (empty($productName) || empty($upiCode)) {
        echo "Product data is missing.";
        exit;
    }

    // Initialize the cart session variable if not already set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add product to cart session variable
    $product = [
        'product_name' => $productName,
        'upi_code' => $upiCode,
        // Additional product details can be added here if needed
    ];

    switch ($action) {
        case 'buy':
            // Directly process the purchase (for simplicity, this can be enhanced)
            header('Location: cart.php?action=buy&product=' . urlencode(json_encode($product)));
            exit;

        case 'add_to_bag':
            // Add to cart and redirect to the cart page
            $_SESSION['cart'][] = $product;
            header('Location: cart.php?action=add_to_bag');
            exit;

        default:
            echo "Invalid action.";
            exit;
    }
} else {
    echo "Invalid request method.";
    exit;
}
?>
