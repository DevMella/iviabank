<?php
function transferToOpay($recipientAccount, $amount) {
    $apiKey = 'YOUR_OPAY_API_KEY';
    $apiUrl = 'https://api.opay.com/transfer';
    $data = [
        'recipientAccount' => $recipientAccount,
        'amount' => $amount,
        'currency' => 'NGN',
        'description' => 'Transfer to Opay account'
    ];

    $response = sendApiRequest($apiUrl, $apiKey, $data);
    return handleApiResponse($response);
}

function sendApiRequest($apiUrl, $apiKey, $data) {
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}




?>