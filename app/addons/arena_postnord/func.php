<?php

use Arena\Aditional\BasicServiceCode;
use Arena\Booking\BookingEdiReturn;
use Arena\ServicePoint\ServicePoint;

defined('BOOTSTRAP') or die('Access denied');


function fn_arena_postnord_find_nearest_service_point()
{
    // TODO: Must Get Api Key From Addons Settings
    $api_key = "7cb4cd700f036ce7912b90f7fc69fc08";

    $servicePoint = new ServicePoint($api_key);

    $servicePoint
        ->setCountryCode("SE")
        ->setStreetName('Holmengatan')
        ->setStreetNumber("10")
        ->setPostalCode("33234");

    $response = $servicePoint->call();

    return $response->getBody();
}

function fn_arena_postnord_basic_service_code()
{
    $api_key = "7cb4cd700f036ce7912b90f7fc69fc08";
    $basicService = new BasicServiceCode($api_key);
    $response =  $basicService->call();
    return $response->getBody();
}


function fn_arena_postnord_booking_payload($order_id)
{
    $order_info = fn_get_order_info($order_id);
    $package = reset($order_info['product_groups']);
    $packageInfo = $package['package_info']['packages'];

    $payload = generatePayload($order_info, reset($packageInfo));
    $api_key = "7cb4cd700f036ce7912b90f7fc69fc08";
    // fn_print_die(@json_encode($payload));
    $booking = new BookingEdiReturn($api_key);
    $booking->setBody(@json_encode($payload));
    $respnse = $booking->call();
    fn_print_r($respnse->getBody());
}


function generatePayload($order_info, $packageInfo)
{
    $customer_info = [];
    $customer_info['messageDate'] = date('c',time());
    $customer_info['messageFunction'] = 'Instruction';
    $customer_info['updateIndicator'] = 'Original';
    $customer_info['shipment'] = [
        [
            'shipmentIdentification' => ['shipmentId' => "0"],
            'dateAndTimes'           => ['loadingDate' => date('c',time())],
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
                        'partyId' => $order_info['order_id'],
                        'partyIdType' => '160',
                    ],
                    'party'             => [
                        'nameIdentification' => [
                            'name'              => 'Consignor',                        ],
                        'address'           => [
                            'streets'       => [
                                 "Terminalvägen 14",
                            ],
                            'postalCode'         => "17173",
                            'city'               => "Solna", 
                            'countryCode'        => "SE", 
                        ],
                        'contact'                => [
                            'contactName'        => 'sameer', 
                            'emailAddress'       => 'hasyrawi@gmail.com', 
                            'smsNo'              => phone_number_clear($order_info['phone']),
                        ],
                    ],
                ],
                'consignee'          => [
                    'issuerCode'        => 'Z12',
                    'partyIdentification' => [
                        'partyId' => '1111111111',
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
