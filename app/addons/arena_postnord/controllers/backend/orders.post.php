<?php

use Tygh\Tygh;

defined('BOOTSTRAP') or die('Access denied');

if ($mode == 'details') {
    $order_id = $_REQUEST['order_id'];

    $shipments = db_get_array("SELECT DISTINCT s.* FROM ?:shipments s 
      LEFT JOIN ?:shipment_items si ON s.shipment_id=si.shipment_id 
      WHERE si.order_id=?i AND s.carrier='postnord'", $order_id);

    if ($shipments) {
        foreach ($shipments as $idx => $shipment) {
            $shipments[$idx]['order_data'] = [];
            $row = db_get_row("select * from ?:postnord_order_ids where service_order_id=?s", $shipment['postnord_order_id']);
            if ($row) {
                $shipments[$idx]['order_data'] = json_decode($row['order_data'], true);
            }
        }
    }
    Tygh::$app['view']->assign('shippo_shipment_data', $shipments);
}
