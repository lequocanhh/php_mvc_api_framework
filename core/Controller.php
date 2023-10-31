<?php

namespace app\core;

class Controller
{
    public Request $request;
    public Response $response;
    public function __construct()
    {
        $this->request = $GLOBALS['request'];
    }

}