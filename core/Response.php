<?php

namespace app\core;

class Response
{
    public function setStatusCode($statusCode): int
    {
        return http_response_code($statusCode);
    }
    public function render($status, $dbResponse){
        header('Content-Type: application/json');
        http_response_code($status);

        if($status == 200){
            $response = $dbResponse;
        }else{
            $response['status'] = $status;
            $response['message'] = $dbResponse;
        }
        echo json_encode($response);
        die;
    }

}