<?php

namespace app\helper;

class Helper
{
    public function getAttributesFromObject($object): array
    {
        $attributes = [];

        foreach ($object as $key => $value) {
            $attributes[] = $key;
        }

        return $attributes;
    }
}