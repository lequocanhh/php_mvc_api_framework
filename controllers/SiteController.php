<?php

namespace app\controllers;
use app\core\Application;
use app\core\Request;
use app\core\Response;

class SiteController
{
    public function contact(Request $request)
    {
        $body = $request->getBody();
        return json_encode($body);
    }

    public function user()
    {
        $name = 'user a';
        return json_encode($name);
    }
}