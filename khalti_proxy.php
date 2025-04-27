<?php

// Set default values if not provided
$amount = $_POST['amount'] ?? "1000"; // Default amount is 1000
$purchase_order_id = $_POST['purchase_order_id'] ?? "test_order_id"; // Default purchase order ID is "test_order_id"
$purchase_order_name = $_POST['purchase_order_name'] ?? "Test Order"; // Default purchase order name is "Test Order"

// Customer info from request
$customer_name = isset($data['customer_name']) ? $data['customer_name'] : "Test Bahadur";
$customer_email = isset($data['customer_email']) ? $data['customer_email'] : "test@khalti.com";
$customer_phone = isset($data['customer_phone']) ? $data['customer_phone'] : "9800000001";

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://dev.khalti.com/api/v2/epayment/initiate/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode([
        "return_url" => "http://localhost/barebelle/confirm.php",
        "website_url" => "http://localhost/barebelle/",
        "amount" => $amount,
        "purchase_order_id" => $purchase_order_id,
        "purchase_order_name" => $purchase_order_name,
        "customer_info" => [
            "name" => $customer_name,
            "email" => $customer_email,
            "phone" => $customer_phone
        ]
    ]),
    CURLOPT_HTTPHEADER => array(
        'Authorization: key e8dcc9d111c54327a26b318e2b459c61',
        'Content-Type: application/json',
    ),
));

$response = curl_exec($curl);
curl_close($curl);
echo $response;