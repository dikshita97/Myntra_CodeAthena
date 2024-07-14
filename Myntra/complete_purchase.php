<?php
// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $productName = $_POST['product_name'] ?? '';
    $buyerName = $_POST['buyer_name'] ?? '';
    $buyerAddress = $_POST['buyer_address'] ?? '';
    $buyerUPI = $_POST['buyer_upi'] ?? '';

   
    $sellerEmail = 'seller@example.com';  /
    $subject = 'New Purchase Order';
    $message = "Hello,\n\nYou have a new purchase order for product '$productName'.\n\nBuyer Name: $buyerName\nBuyer Address: $buyerAddress\nBuyer UPI ID: $buyerUPI\n\nPlease proceed with delivery.\n\nRegards,\nYour Store";

    
    require 'vendor/autoload.php';
    $apiKey = 'YOUR_SENDGRID_API_KEY'; 
    $senderEmail = 'sender@example.com'; 
    $senderName = 'Your Store'; 
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom($senderEmail, $senderName);
    $email->setSubject($subject);
    $email->addTo($sellerEmail);
    $email->addContent("text/plain", $message);
    $sendgrid = new \SendGrid($apiKey);
    $response = $sendgrid->send($email);

    header('Location: thank_you.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanks for Shopping!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 30px;
            height: 100%;
            width: 100%;
            margin-left: 2px;
        }
        h2 {
            color: #333;
            margin-bottom: 30px;
            font-size: 36px;
        }
        .button-container {
            margin-top: 20px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Thanks for Shopping!</h2>
        <div>
          
        </div>
        <div class="button-container">
            <a href="browse.php"><button>Continue Shopping</button></a>
        </div>
    </div>
</body>
</html>