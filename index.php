<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

include $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
include $_SERVER['DOCUMENT_ROOT'].'/config.php';
include $_SERVER['DOCUMENT_ROOT'].'/source/pipe.php';

$function = isset($_GET['function']) ? $_GET['function'] : '';

switch ($function) {
    case 'get_order' :
        echo pipe::get_or_detail_order($params['get_order_method'], $params['get_order_url'], []);
        break;
    case 'detail_order' :
        $detail_id = isset($_GET['id']) ? ['ordersn_list' => $_GET['id']] : [];
        echo pipe::get_or_detail_order($params['detail_order_method'], $params['detail_order_url'], $detail_id);
        break;
    case 'create_order' :
        echo pipe::create_order();
        break;
    default :
        $error = [
            'message' => 'please set url function (?function=...)',
            'available_function' => ['get_order', 'detail_order', 'create_order']
        ];
        echo json_encode($error);
}