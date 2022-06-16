<?php

use Arena\Shipment\PostnordShipment;
use Tygh\Tygh;

defined('BOOTSTRAP') or die('Access denied');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($mode === 'generate_pdf') {
        $base64Pdf = $_REQUEST['label_base64'];
        $pdf = fn_arena_postnord_generate_pdf_file($base64Pdf);
        header('Content-Type: application/pdf');
        echo $pdf;
    }
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
            // Use Item Id as Tracking Number
            'tracking_number' => explode("-", $itemId)[1],
            "urls" => $urls,
            "labelPrintout" => "data:image/png;base64, {$LabelInformation->printout->data}"
        ];

        // Save Into Database if not exist will create one
        PostnordShipment::generateOrderShipment($order_id, $mapPostnord);
        // Update Order Data From Payload
        PostnordShipment::updateOrderShipment($order_id, $mapPostnord);
        // Create Shipment
        PostnordShipment::createShipment($order_id, $mapPostnord);

        $view->assign('postnord', $mapPostnord);
        $view->assign('postnord_method', $postnord_method);
    }

    if ($postnord_method === 'edi_with_label') {
        $postnord = fn_arena_postnord_booking_payload($order_id, $postnord_method);
        $idInformation = reset($postnord->bookingResponse->idInformation);
        $shipment =  $idInformation->references->shipment[0]->referenceType . "-" . $idInformation->references->shipment[0]->referenceNo;
        $itemId = $idInformation->ids[0]->idType . "-" . $idInformation->ids[0]->value;
        $urls = $idInformation->urls[0];
        $LabelInformation = reset($postnord->labelPrintout);

        $mapPostnord = [
            'bookingId' => $postnord->bookingResponse->bookingId,
            'shipment' => $shipment,
            'returnId' => $returnId,
            'itemId' => $itemId,
            // Use Item Id as Tracking Number
            'tracking_number' => explode("-", $itemId)[1],
            "urls" => $urls,
            "labelPrintout" => $LabelInformation->printout->data
        ];

        // Save Into Database if not exist will create one
        PostnordShipment::generateOrderShipment($order_id, $mapPostnord);
        // Update Order Data From Payload
        PostnordShipment::updateOrderShipment($order_id, $mapPostnord);
        // Create Shipment
        PostnordShipment::createShipment($order_id, $mapPostnord);

        $view->assign('postnord', $mapPostnord);
        $view->assign('postnord_method', $postnord_method);
    }

    if ($postnord_method == 'pickups') {
        $postnord = fn_arena_postnord_booking_payload($order_id, $postnord_method);
        fn_print_die("Pickups");
    }

    $view->assign('order_id', $order_id);
}
