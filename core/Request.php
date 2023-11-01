<?php

namespace app\core;

class Request
{
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?') ;
        if($position === false){
            return $path;
        }
        return substr($path, 0, $position);
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getBody(): array
    {
        $body = [];
//        if($this->getMethod() === 'get'){
//            foreach ($_GET as $key => $value){
//                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//            }
//        }
        if($this->getMethod() === 'post'){
            $post_data = json_decode(file_get_contents("php://input"), true);
                foreach ($post_data as $key => $value) {
                    $body[$key] = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                }
        }
        return $body;
    }


}