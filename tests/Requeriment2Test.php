<?php

class Requirement2Test extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    private $expected = [
        [
            "body" => [
                "modelYear" => "2015",
                "manufacturer" => "Audi",
                "model" => "A3",
            ],
            "output" => [
                "Count" => 4,
                "Results" => [
                    [
                    "Description" => "2015 Audi A3 4 DR AWD",
                    "VehicleId" => 9403
                    ],
                    [
                    "Description" => "2015 Audi A3 4 DR FWD",
                    "VehicleId" => 9408
                    ],
                    [
                    "Description" => "2015 Audi A3 C AWD",
                    "VehicleId" => 9405
                    ],
                    [
                    "Description" => "2015 Audi A3 C FWD",
                    "VehicleId" => 9406
                    ]
                ]
            ]
        ],
        [
            "body" => [
                "modelYear" => "2015",
                "manufacturer" => "Toyota",
                "model" => "Yaris",
            ],
            "output" => [
                "Count" => 2,
                "Results" => [
                    [
                    "Description" => "2015 Toyota Yaris 3 HB FWD",
                    "VehicleId" => 9791
                    ],
                    [
                    "Description" => "2015 Toyota Yaris Liftback 5 HB FWD",
                    "VehicleId" => 9146
                    ]
                ]
            ]
        ],
        [
            "body" => [
                "manufacturer" => "Honda",
                "model" => "Accord",
            ],
            "output" => [
                "Count" => 0,
                "Results" => []
            ]
        ]
    ];

    public function test()
    {
        foreach ($this->expected as $expected) {
            $body = $expected["body"];
            $this->json('POST', "/vehicles", $body);
            $this->assertEquals(
                json_encode($expected["output"]),
                $this->response->getContent()
            );
        }
    }
}
