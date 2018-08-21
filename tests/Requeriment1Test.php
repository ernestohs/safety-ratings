<?php

class Requirement1Test extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    private $expected = [
        [
            "parameters" => [
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
            "parameters" => [
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
            "parameters" => [
                "modelYear" => "2015",
                "manufacturer" => "Ford",
                "model" => "Crown%20Victoria",
            ],
            "output" => [
                "Count" => 0,
                "Results" => []
            ]
        ],
        [
            "parameters" => [
                "modelYear" => "undefined",
                "manufacturer" => "Ford",
                "model" => "Fusion",
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
            $parameters = $expected["parameters"];
            $this->get("/vehicles".
                "/".$parameters["modelYear"].
                "/".$parameters["manufacturer"].
                "/".$parameters["model"]);
    
            $this->assertEquals(
                json_encode($expected["output"]),
                $this->response->getContent()
            );
        }
    }
}
