<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploadsDir = 'uploads/';
    $photos = [];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    
    // Handle file uploads
    foreach ($_FILES['product_photos']['tmp_name'] as $key => $tmpName) {
        $fileType = mime_content_type($tmpName);
        if (in_array($fileType, $allowedTypes)) {
            $fileName = basename($_FILES['product_photos']['name'][$key]);
            $targetFilePath = $uploadsDir . $fileName;
            if (move_uploaded_file($tmpName, $targetFilePath)) {
                $photos[] = $targetFilePath;
            }
        }
    }
    
    // Get form data
    $productName = htmlspecialchars($_POST['product_name']);
    $materialDetails = htmlspecialchars($_POST['material_details']);
    $size = htmlspecialchars($_POST['size']);
    $price = htmlspecialchars($_POST['price']);
    $upiCode = htmlspecialchars($_POST['upi_code']);
    
    // Store product data
    $productData = [
        'product_name' => $productName,
        'photos' => $photos,
        'material_details' => $materialDetails,
        'size' => $size,
        'price' => $price,
        'upi_code' => $upiCode
    ];
    
    $productsFile = 'products.json';
    $products = [];
    
    if (file_exists($productsFile)) {
        $products = json_decode(file_get_contents($productsFile), true);
    }
    
    $products[] = $productData;
    file_put_contents($productsFile, json_encode($products));
    
    header('Location: browse.php');
    exit;
}
?>


