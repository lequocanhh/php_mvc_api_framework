<?php

namespace app\exception;

class SurveyException extends \Exception
{
    public static function invalidTitleLength(): SurveyException
    {
        return new static("Invalid title length!");
    }
    public static function invalidDescriptionLength(): SurveyException
    {
        return new static("Invalid description length!");
    }
    public static function surveyNotFound(): SurveyException
    {
        return new static("This survey is not found, please try again!");
    }

}