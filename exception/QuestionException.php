<?php

namespace app\exception;

class QuestionException extends \Exception
{
    public static function questionNotFound(): QuestionException
    {
        return new static("Cannot find any question in this survey");
    }



}