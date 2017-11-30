<?php
include './vendor/autoload.php';
include 'source/pipe.php';

$function = $_GET['function'];

/**
 * $params
 * set all static parameters in here
 */
$params = [
    'generate_token_method' => 'POST',
    'generate_token_url' => 'https://fulfillmentcpms-acommerce.mockable.io/identity/token',
    'get_order_method' => 'POST',
    'get_order_url' => 'https://etc-acommerce.mockable.io/shopee/api/v1/orders/basics',
    'detail_order_method' => 'POST',
    'detail_order_url' => 'https://etc-acommerce.mockable.io/shopee/api/v1/orders/detail',
    'create_order_username' => 'your_username',
    'create_order_api_key' => 'your_api_key',
    'create_order_method' => 'PUT',
    'create_order_url' => 'https://fulfillmentcpms-acommerce.mockable.io/channel/shopee_test/order/160707183487980',
];

switch ($function) {
    case 'get_order' :
        echo pipe::get_order($params['get_order_method'], $params['get_order_url'], []);
        break;
    case 'detail_order' :
        echo pipe::detail_order($params['detail_order_method'], $params['detail_order_url'], []);
        break;
    case 'create_order' :
        echo pipe::create_order($params['create_order_method'], $params['create_order_url'], []);
        break;
    default :
        $error = [
            'message' => 'please set url function (?function=...)',
            'available_function' => ['get_order', 'set_order', 'create_order']
        ];
        echo json_encode($error);
}