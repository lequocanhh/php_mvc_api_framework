<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;

class SurveyController
{
    public function createNewSurvey(Request $request, Response $response): void
    {
        $req = $request->getBody();
        var_dump($req);exit;
    }
}