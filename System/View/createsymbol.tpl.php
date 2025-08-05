<?php
header('Content-Type: application/json');

$response = [
    'error' => isset($this->data['error']) ? $this->data['error'] : false,
    'status' => isset($this->data['status']) ? $this->data['status'] : 'error',
    'data' => [],
];

if (isset($this->data['symbol'])) {
    $response['data']['symbol'] = $this->data['symbol'];
}

if (isset($this->data['symbol_id'])) {
    $response['data']['symbol_id'] = $this->data['symbol_id'];
}

echo json_encode($response, JSON_PRETTY_PRINT);