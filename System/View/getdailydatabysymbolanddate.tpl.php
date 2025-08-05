<?php
header('Content-Type: application/json');

$response = [
    'status' => isset($this->data['status']) ? $this->data['status'] : 'error',
    'message' => isset($this->data['message']) ? $this->data['message'] : 'No message provided',
    'data' => isset($this->data['dailyData']) ? $this->data['dailyData'] : []
];

echo json_encode($response, JSON_PRETTY_PRINT);