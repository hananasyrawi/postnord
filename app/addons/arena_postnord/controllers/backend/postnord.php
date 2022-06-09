<?php

use Tygh\Tygh;

defined('BOOTSTRAP') or die('Access denied');


if ($mode == 'manage') {
    $nearestPoint = fn_arena_postnord_find_nearest_service_point();
    fn_print_r($nearestPoint);
}


// Step 1
if ($mode == "step1") {
    $order_id = $_REQUEST['order_id'];
    $order_info = fn_get_order_info($order_id);
    fn_arena_postnord_booking_payload($order_id);
    $view = Tygh::$app['view'];
    $view->assign('order_id', $order_id);
    $view->assign('order_info', $order_info);
}

if ($mode == "step2") {
    fn_print_r($_REQUEST);
    fn_set_notification('N', __('notice'), @json_encode($_REQUEST));
}

if ($mode == "step3") {
    // TODO -- book the shipment
}
