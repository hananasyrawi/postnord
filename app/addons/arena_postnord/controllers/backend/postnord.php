<?php

use Tygh\Tygh;

defined('BOOTSTRAP') or die('Access denied');


if ($mode == 'manage') {
    $nearestPoint = fn_arena_postnord_booking_payload(112);
    fn_print_r($nearestPoint);
}


// Step 1
if ($mode == "step1") {
    $order_id = $_REQUEST['order_id'];
    $order_info = fn_get_order_info($order_id);
    $postnord = fn_arena_postnord_booking_payload($order_id);

    $view = Tygh::$app['view'];
    $view->assign('order_id', $order_id);
    $view->assign('order_info', $order_info);
}

if ($mode == "step2") {
    $order_id = $_REQUEST['order_id'];
    $order_info = fn_get_order_info($order_id);
    $postnord = fn_arena_postnord_booking_payload($order_id);

    $view = Tygh::$app['view'];
    $view->assign('order_id', $order_id);
    $view->assign('order_info', $order_info);
}

if ($mode == "step3") {
    // TODO -- book the shipment
}
