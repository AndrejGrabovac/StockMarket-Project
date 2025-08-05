<?php
header('Content-Type: application/json');
header('HTTP/1.0 404 Not Found');

$response = [
    'status' => isset($this->data['status']) ? $this->data['status'] : 'error',
    'message' => isset($this->data['message']) ? $this->data['message'] : 'Page not found',
];

echo json_encode($response, JSON_PRETTY_PRINT);