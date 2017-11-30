<?php

/**
 * $params
 * set all static parameters in here
 */
$params = [
    'generate_token_method' => 'POST',
    'generate_token_url' => 'https://fulfillmentcpms-acommerce.mockable.io/identity/token',
    'generate_token_username' => 'your_username',
    'generate_token_api_key' => 'your_api_key',
    'get_order_method' => 'POST',
    'get_order_url' => 'https://etc-acommerce.mockable.io/shopee/api/v1/orders/basics',
    'detail_order_method' => 'POST',
    'detail_order_url' => 'https://etc-acommerce.mockable.io/shopee/api/v1/orders/detail',
    'create_order_method' => 'PUT',
    'create_order_url' => 'https://fulfillmentcpms-acommerce.mockable.io/channel/shopee_test/order/', //ex ID = 160707183487980
];