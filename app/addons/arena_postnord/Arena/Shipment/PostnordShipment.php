<?php

namespace Arena\Shipment;

class PostnordShipment
{
    public static function generateOrderShipment($orderId)
    {
        // Need Check First if order_id Has Exists
        $ship = db_get_field("select id from ?:postnord_order_ids where order_id = ?i and service_order_id=?s", $orderId, $orderId);
        // If Has Create With Same Order Just Return
        if (!empty($ship)) {
            return;
        }
        // Insert To database
        db_query("INSERT INTO ?:postnord_order_ids ?e ", ["order_id" => $orderId, "service_order_id" => $orderId]);
    }

    /**
     * If Transaction Has Created Save Transaction Data on
     * @param $orderId
     * @param $transactionData
     */
    public static function updateOrderShipment($orderId, $transactionData)
    {
        // Update Information About Shipping
        db_query("UPDATE ?:postnord_order_ids SET order_data=?s where service_order_id=?s ", @json_encode($transactionData), $orderId);
    }

    //Create Shipment In Here
    public static function createShipment($orderId, $payload)
    {
        $order_info = fn_get_order_info($orderId);
        $shippingId = reset($order_info['shipping']);

        $shipment_data = array(
            "shipping_id" => $shippingId['shipping_id'],
            "tracking_number" => $payload['tracking_number'],
            "timestamp" => time(),
            "carrier" => 'postnord',
            "postnord_order_id" => $orderId,
        );

        $shipmentId = db_query("INSERT INTO ?:shipments ?e ", $shipment_data);

        foreach ($order_info['products'] as $k => $product) {
            $items = array(
                "item_id" => $k,
                "shipment_id" => $shipmentId,
                "order_id" => $order_info['order_id'],
                "product_id" => $product['product_id'],
                "amount" => $product['amount']
            );

            db_query("INSERT INTO ?:shipment_items ?e", $items);
        }
    }
}
