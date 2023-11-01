<?php

namespace app\core;

class Response
{
    public function setStatusCode($statusCode): int
    {
        return http_response_code($statusCode);
    }
    public function render(int $status, bool $success, string $message, array $data=[]): void{
        $response = [];
        http_response_code($status);
        header("Access-Control-Allow-Origin: *", true);
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS", true);
        header("Content-Type: application/json; charset=UTF-8");
        $response['status'] = $status;
        $response['success'] = $success;
        $response['message'] = $message;
        $response['data'] = $data;
        echo json_encode($response);
        die;
    }

}