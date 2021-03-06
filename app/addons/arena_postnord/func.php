<?php

use Arena\Aditional\BasicServiceCode;
use Arena\Booking\BookingEdi;
use Arena\Booking\BookingEdiReturn;
use Arena\Booking\PickupPostnord;
use Arena\ServicePoint\ServicePoint;
use Tygh\Registry;

defined('BOOTSTRAP') or die('Access denied');

define('API_KEY', Registry::get('addons.arena_postnord.API_KEY'));

function fn_arena_postnord_find_nearest_service_point()
{
    $servicePoint = new ServicePoint(API_KEY);

    $servicePoint->setCountryCode("SE")
        ->setStreetName('Holmengatan')
        ->setStreetNumber("10")
        ->setPostalCode("33234");

    $response = $servicePoint->call();

    return $response->getBody();
}

function fn_arena_postnord_basic_service_code()
{
    $basicService = new BasicServiceCode(API_KEY);
    $response =  $basicService->call();
    return $response->getBody();
}

/**
 * @param $order_id
 * @param $request_method
 * @return mixed
 */
function fn_arena_postnord_booking_payload($order_id, $request_method)
{
    // Prepare Data
    $order_info = fn_get_order_info($order_id);
    $package = reset($order_info['product_groups']);
    $packageInfo = $package['package_info']['packages'];
    $company_id = $order_info['company_id'];
    $companyVendorAddress = fn_arena_postnord_get_vendor_address($company_id);
    $payload = generatePayload($order_info, reset($packageInfo), $companyVendorAddress);

    if ($request_method === 'edi') {
        $booking = new BookingEdiReturn(API_KEY);
        $booking->setBody(@json_encode($payload));
        $response = $booking->call();
        handle_error_request($response->getInfo(), $response->getBody());
        return $response->getBody();
    } elseif ($request_method === 'edi_with_label') {
        $booking = new BookingEdi(API_KEY);
        $booking->setBody(@json_encode($payload));
        $response = $booking->call();
        handle_error_request($response->getInfo(), $response->getBody());
        return $response->getBody();
    } elseif ($request_method === 'pickups') {
        $booking = new PickupPostnord(API_KEY);
        $booking->setBody(@json_encode($payload));
        return;
    }
}


function generatePayload($order_info, $packageInfo, $vendorAddress)
{
    $customer_info = [];
    $customer_info['messageDate'] = date('c', time());
    $customer_info['messageFunction'] = 'Instruction';
    $customer_info['updateIndicator'] = 'Original';
    $customer_info['shipment'] = [
        [
            'shipmentIdentification' => ['shipmentId' => "0"],
            'dateAndTimes'           => ['loadingDate' => date('c', time())],
            'service'                => [
                "basicServiceCode" => "87",
            ],
            "numberOfPackages"       => ['value' =>  $packageInfo['amount']],
            "totalGrossWeight"       => ['unit' => 'LBS', 'value' => $packageInfo['weight']],
            'parties'                => [
                // Default Get information from setting addons on vendor pages
                'consignor'          => [
                    'issuerCode'        => 'Z12',
                    'partyIdentification' => [
                        'partyId' => $vendorAddress['company_id'], // Need changes into UUID4
                        'partyIdType' => '160',
                    ],
                    'party'             => [
                        'nameIdentification' => [
                            'name'              => 'Consignor',
                        ],
                        'address'           => [
                            'streets'       => [
                                $vendorAddress['postnord_address']
                            ],
                            'postalCode'         => $vendorAddress['postnord_postal_code'],
                            'city'               => $vendorAddress['postnord_city'],
                            'countryCode'        => $vendorAddress['postnord_country'],
                        ],
                        'contact'                => [
                            'contactName'        => $vendorAddress['company'],
                            'emailAddress'       => $vendorAddress['email'],
                            'smsNo'              => $vendorAddress['postnord_phone'],
                        ],
                    ],
                ],
                'consignee'          => [
                    'issuerCode'        => 'Z12',
                    'partyIdentification' => [
                        'partyId' => "11111",
                        'partyIdType' => '160',
                    ],
                    'party'             => [
                        'nameIdentification' => [
                            'name'           => 'Consignee',
                        ],
                        'address'           => [
                            'streets'       => [
                                $order_info['s_address'],
                            ],
                            'postalCode'         => $order_info['s_zipcode'],
                            'city'               => $order_info['s_city'],
                            'countryCode'        => $order_info['s_country'],
                        ],
                        'contact'                => [
                            'contactName'        => $order_info['firstname'] . " " . $order_info['lastname'],
                            'emailAddress'       => $order_info['email'],
                            'smsNo'              => phone_number_clear($order_info['phone']),
                        ],
                    ],
                ],
            ],
            'goodsItem' => [
                [
                    'packageTypeCode' => 'PC',
                    'items' => [
                        [
                            'itemIdentification' => [
                                'itemId' => "0",
                                'itemIdType' => "SSCC",
                            ],
                            'grossWeight' => [
                                'value' => $packageInfo['amount'],
                                'unit' => 'LBS',
                            ]
                        ]
                    ]
                ]
            ],
        ]
    ];

    return $customer_info;
}


function phone_number_clear($phone)
{
    $phone_number = explode('-', $phone);
    $after_phone_explode = implode("", $phone_number);
    return $after_phone_explode;
}


function fn_arena_postnord_get_vendor_address($companyId)
{
    $row = db_get_row("select * from ?:companies where company_id=?i", $companyId);
    return $row;
}


function generate_pdf_from_base64(string $pdfBase64)
{
    $bin = base64_decode($pdfBase64, true);
    return $bin;
}

function handle_error_request($message, $data)
{
    if (isset($message) && $message['http_code'] === 400) {
        fn_set_notification("E", "Error", $data->message);
        exit;
    }
}

function fn_arena_postnord_generate_pdf_file($base64)
{
    $pdf_decode = base64_decode($base64);
    return $pdf_decode;
}
/**
 * Param Will Contains Base64 Encodes Will Check if data contains PNG return bool
 * @param string $string
 */
function fn_arena_postnord_contains_some_image($string): bool
{
    $out = stripos($string, 'png');
    return $out;
}

