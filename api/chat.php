<?php
header('Content-Type: application/json');

// Get the sent data
$data = json_decode(file_get_contents('php://input'), true);
$message = $data['messages'][0]['content'] ?? '';

// Simulate a response (replace with an API call to an AI service)
$responses = [
    'hello' => 'Hello! How can I help you with your shopping today?',
    'price' => 'Our prices are very competitive. Which product are you particularly interested in?',
    'shipping' => 'Shipping is free for all orders over 50 DT. Delivery usually takes 2-3 business days.',
    'payment' => 'We accept credit cards, D17 and .',
    'phone' => 'We have a wide range of smartphones from the best brands. Are you looking for a particular brand?',
    'computer' => 'Our laptops are available in different configurations. Do you have a specific budget?',
    'return' => 'You can return a product within 14 days of receipt for a full refund.',
    'available' => 'All products displayed on our website are generally available in stock.',
    'thank' => 'You\'re welcome! Feel free to ask if you have any other questions.'
];

$response = 'Thank you for your message. How can I further assist you with your shopping?';

foreach ($responses as $keyword => $reply) {
    if (stripos($message, $keyword) !== false) {
        $response = $reply;
        break;
    }
}

echo json_encode(['response' => $response]);
?>