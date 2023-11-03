<?php

namespace app\core;

class Response
{
    public function setStatusCode($statusCode): int
    {
        return http_response_code($statusCode);
    }

    public function render(int $status, string $message, array $data = []): void
    {
        $response = [];
        http_response_code($status);
        $response['status'] = $status;
        $response['message'] = $message;
        $response['data'] = $data;
        echo json_encode($response);
        die;
    }

}