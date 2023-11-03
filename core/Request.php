<?php

namespace app\core;

class Request
{
    private array $body = [];
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

    public function setBody(array $data): void
    {
        $this->getBody();
        foreach ($data as $key => $value){
            $this->body[$key] = $value;
        }
    }

    public function getBody(): array
    {
//        if($this->getMethod() === 'get'){
//            foreach ($_GET as $key => $value){
//                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//            }
//        }
        if($this->getMethod() === 'post'){

            $post_data = json_decode(file_get_contents("php://input"), true);
                foreach ($post_data as $key => $value) {
                    $this->body[$key] = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                }
        }
        return $this->body;
    }

    public function toArray(): array
    {
        return $this->body;
    }
}