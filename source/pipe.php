<?php
include $_SERVER['DOCUMENT_ROOT'].'/source/helper.php';
include $_SERVER['DOCUMENT_ROOT'].'/source/transformer.php';
include $_SERVER['DOCUMENT_ROOT'].'/config.php';

/**
 * Class pipe
 * Collections of pipe lining functions
 */
class pipe
{
    /**
     * @return \Psr\Http\Message\StreamInterface
     *
     * This function is to get orders from Shopee or detail order
     */
    static function get_or_detail_order($method, $url, $body)
    {
        $res = helper::setClient([], $method, $url, $body);
        return $res->getBody();
    }

    /**
     * @return string
     *
     * This is the main function to get orders from Shopee and send to aCommerce API
     */
    static function create_order()
    {
        global $params;
        /**
         * STEP 1:
         * Get order from Shopee
         */
        $orders = self::get_or_detail_order($params['get_order_method'], $params['get_order_url'], []);
        $orders = json_decode($orders, true);
        /**
         * STEP 2:
         * Iterate over items and transform to aCommerce format
         */
        $result = [];
        foreach ($orders['orders'] as $order) {
            $result[] = self::send_order_to_acommerce($order['ordersn']);
        }

        return json_encode($result);
    }

    /**
     * @param $order_id
     * @return mixed
     *
     * Iteration function from Shopee order ID send to aCommerce API
     */
    private static function send_order_to_acommerce($order_id)
    {
        global $params;
        /**
         * STEP 3:
         * Get detail order from Shopee
         * And transform into aCommerce json API format
         */
        $detail_id = empty($order_id) ? [] : ['ordersn_list' => $order_id];
        $detail_order = pipe::get_or_detail_order($params['detail_order_method'], $params['detail_order_url'], $detail_id);
        $transform = transformer::jsonTransform($detail_order);

        /**
         * STEP 4:
         * Generate token to access API
         */
        $token = helper::generateToken($params['generate_token_method'], $params['generate_token_url'], $params['generate_token_username'], $params['generate_token_api_key']);

        /**
         * STEP 5:
         * FINAL Step to send to aCommerce API to create order
         */
        $res = helper::setClient([
            'headers' => [
                'X-Subject-Token' => $token
            ]
        ], $params['create_order_method'], $params['create_order_url'] . $order_id, $transform);
        return json_decode($res->getBody());
    }
}