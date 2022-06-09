<?php

use Arena\Aditional\BasicServiceCode;
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
    $payload = generatePayload($order_info);
    fn_print_r(@json_encode($payload));
}


function generatePayload($order_info)
{

    $customer_info = [];
    $customer_info['messageDate'] = Date('Y-m-d H:i:s');
    $customer_info['messageFunction'] = 'Instruction';
    $customer_info['updateIndicator'] = 'Original';
    $customer_info['shipment'] = [
        [
            'shipmentIdentification' => ['shipmentId' => 1],
            'dateAndTimes'           => ['loadingDate' => Date('Y-m-d H:i:s')],
            'service'                => ['serviceCode' => ''],
            "numberOfPackages"       => ['value' => 1], // TODO change into qty
            "totalGrossWeight"       => ['unit' => 'KGM', 'value' => 1], // TODO need change into shipment information for getting weight and unit
            'parties'                => [
                // Default Get information from setting addons on vendor pages
                'consignor'          => [
                    'issuerCode'        => 'Z10',
                    'partyIdentification' => [
                        'partyId' => '1111111111',
                        'partyIdType' => '160',
                    ],
                    'party'             => [
                        'nameIdentification' => [
                            'name'              => $order_info['firstname'] . " " . $order_info['lastname'],
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
                'consignee'          => [
                    'issuerCode'        => 'Z10',
                    'partyIdentification' => [
                        'partyId' => '1111111111',
                        'partyIdType' => '160',
                    ],
                    'party'             => [
                        'nameIdentification' => [
                            'name'              => $order_info['firstname'] . " " . $order_info['lastname'],
                        ],
                        'address'           => [
                            'streets'       => [
                                $order_info['s_address'],
                            ],
                            'postalCode'        => $order_info['s_zipcode'],
                            'city'              => $order_info['s_city'],
                            'countryCode'       => $order_info['s_country'],
                        ],
                        'contact'           => [
                            'email'             => $order_info['email'],
                            'phoneNumber'       => phone_number_clear($order_info['phone']),
                            'contactPerson'     => $order_info['firstname'] . " " . $order_info['lastname'],
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
                                'itemId' => 1,
                                'itemIdType' => 1,
                            ],
                            'grossWeight' => [
                                'value' => 1.2,
                                'unit' => 'KGM',
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
