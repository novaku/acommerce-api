<?php
include 'helper.php';
include 'transformer.php';

/**
 * Class pipe
 * Collections of pipe lining functions
 */
class pipe
{

    /**
     * @return \Psr\Http\Message\StreamInterface
     *
     * This function is to get orders from Shopee
     */
    static function get_order($method, $url, $body)
    {
        $res = helper::setClient($method, $url, $body);
        return $res->getBody();
    }

    /**
     * @param $method
     * @param $url
     * @param $body
     * @return \Psr\Http\Message\StreamInterface
     *
     * This function is to get from shopee and transform to acommerce json format
     */
    static function detail_order($method, $url, $body)
    {
        $res = helper::setClient($method, $url, $body);
        return $res->getBody();
    }

    static function create_order($method, $url, $body)
    {
        $res = helper::setClient($method, $url, $body);
        return $res->getBody();
    }
}