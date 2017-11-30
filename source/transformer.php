<?php

/**
 * Class transformer
 * Transform json format to fit with aCommerce format
 */
class transformer
{
    /**
     * @param $json
     * @return mixed
     *
     * Function to convert / transform to acommerce payload format
     */
    static function jsonTransform($json)
    {
        $json = json_decode($json);
        return $json;
    }
}