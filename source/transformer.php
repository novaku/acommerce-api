<?php

/**
 * Class transformer
 * Transform json format to fit with aCommerce format
 */
class transformer
{
    /**
     * @param $json
     * @return array
     *
     * Function to convert / transform to aCommerce payload format
     */
    static function jsonTransform($json)
    {
        $json = json_decode($json, true);
        $orders = $json['orders'][0];

        $format = [
            'orderCreatedTime' => date(DATE_ISO8601, $orders['create_time']),
            'customerInfo' =>
                [
                    'addressee' => $orders['recipient_address']['name'],
                    'address1' => $orders['recipient_address']['full_address'],
                    'province' => $orders['recipient_address']['town'],
                    'postalCode' => $orders['recipient_address']['zipcode'],
                    'country' => $orders['recipient_address']['country'],
                    'phone' => $orders['recipient_address']['phone'],
                    'email' => '',
                ],
            'orderShipmentInfo' =>
                [
                    'addressee' => $orders['recipient_address']['name'],
                    'address1' => $orders['recipient_address']['full_address'],
                    'address2' => '',
                    'subDistrict' => '',
                    'district' => $orders['recipient_address']['district'],
                    'city' => $orders['recipient_address']['city'],
                    'province' => $orders['recipient_address']['town'],
                    'postalCode' => $orders['recipient_address']['zipcode'],
                    'country' => $orders['recipient_address']['country'],
                    'phone' => $orders['recipient_address']['phone'],
                    'email' => '',
                ],
            'paymentType' => self::otherTransformer('payment_type', $orders['payment_method']),
            'shippingType' => self::otherTransformer('shipping_type', $orders['days_to_ship']),
            'grossTotal' => floatval($orders['total_amount']),
            'currUnit' => $orders['currency'],
            'orderItems' => self::otherTransformer('items', $orders['items'])
        ];

        return $format;
    }

    /**
     * @param $type
     * @param $value
     * @return mixed
     */
    static function otherTransformer($type, $value)
    {
        switch ($type) {
            case 'payment_type':
                switch ($value) {
                    case 'PAY_COD':
                        return 'COD';
                        break;
                    case 'PAY_BANK_TRANSFER':
                        return 'NON_COD';
                        break;
                    case 'PAY_SHOPEE_WALLET':
                        return 'NON_COD';
                        break;
                    default :
                        return '';
                }
                break;
            case 'shipping_type':
                switch ($value) {
                    case 0:
                        return 'SAME_DAY';
                        break;
                    case 1:
                        return 'NEXT_DAY';
                        break;
                    case 2:
                        return 'EXPRESS_1_2_DAYS';
                        break;
                    case 3:
                        return 'STANDARD_2_4_DAYS';
                        break;
                    case 4:
                        return 'STANDARD_2_4_DAYS';
                        break;
                    case 5:
                        return 'NATIONWIDE_3_5_DAYS';
                        break;
                    default:
                        return 'NATIONWIDE_3_5_DAYS';
                }
                break;
            case 'items':
                $result = [];
                if ($value) {
                    foreach ($value as $val) {
                        $result[] = [
                            'partnerId' => $val['item_name'],
                            'itemId' => $val['item_sku'],
                            'qty' => floatval($val['variation_quantity_purchased']),
                            'subTotal' => floatval($val['variation_discounted_price']),
                        ];
                    }
                    return $result;
                } else {
                    return [];
                }

                break;
        }
    }
}