<?php
header('Content-Type: application/json');

$response = [
        'error' => isset($this->data['error']) ? $this->data['error'] : false,
        'status' => isset($this->data['status']) ? $this->data['status'] : null,
        'message' => isset($this->data['message']) ? $this->data['message'] : null,
        'data' => isset($this->data['dailyData']) ? $this->data['dailyData'] : [],
];
echo json_encode($response, JSON_PRETTY_PRINT);