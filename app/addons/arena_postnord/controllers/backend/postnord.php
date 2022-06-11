<?php

use Tygh\Tygh;

defined('BOOTSTRAP') or die('Access denied');


if ($mode == 'manage') {
}


// Step 1
if ($mode == "step1") {
    $order_id = $_REQUEST['order_id'];
    $mode = $_REQUEST['mode'];
    $view = Tygh::$app['view'];
    $view->assign('order_id', $order_id);
    $view->assign('mode', $mode);
}

if ($mode == "step2") {
    $view = Tygh::$app['view'];
    $order_id = $_REQUEST['order_id'];
    $postnord_method = $_REQUEST['postnord_method'];

    if ($postnord_method === 'edi') {
        $postnord = fn_arena_postnord_booking_payload($order_id, $postnord_method);
        // Booking Information
        $idInformation = reset($postnord->bookingResponse->idInformation);
        $references = $idInformation->references->item[0]->referenceType . "-" . $idInformation->references->item[0]->referenceNo;
        $shipment =  $idInformation->references->shipment[0]->referenceType . "-" . $idInformation->references->shipment[0]->referenceNo;
        $returnId = $idInformation->ids[0]->idType . "-" . $idInformation->ids[0]->value;
        $itemId = $idInformation->ids[1]->idType . "-" . $idInformation->ids[1]->value;
        $urls = $idInformation->urls[0];

        // Label Information
        $LabelInformation = reset($postnord->labelPrintout);

        $mapPostnord = [
            'bookingId' => $postnord->bookingResponse->bookingId,
            'references' => $references,
            'shipment' => $shipment,
            'returnId' => $returnId,
            'itemId' => $itemId,
            "urls" => $urls,
            "labelPrintout" => "data:image/png;base64, {$LabelInformation->printout->data}"
        ];

        $view->assign('postnord', $mapPostnord);
        $view->assign('postnord_method', $postnord_method);
    }

    if ($postnord_method === 'edi_with_label') {
        $postnord = fn_arena_postnord_booking_payload($order_id, $postnord_method);
        fn_print_die("EDI with label");
    }


    if ($postnord_method == 'pickups') {
        $postnord = fn_arena_postnord_booking_payload($order_id, $postnord_method);
        fn_print_die("Pickups");
    }

    $view->assign('order_id', $order_id);
}
