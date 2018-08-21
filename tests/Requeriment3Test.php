<?php

class Requirement3Test extends TestCase
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
            "ratingOutput" => [
                "Count" => 4,
                "Results" => [
                    [
                    "Description" => "2015 Audi A3 4 DR AWD",
                    "VehicleId" => 9403,
                    "CrashRating" => "5"
                    ],
                    [
                    "Description" => "2015 Audi A3 4 DR FWD",
                    "VehicleId" => 9408,
                    "CrashRating" => "5"
                    ],
                    [
                    "Description" => "2015 Audi A3 C AWD",
                    "VehicleId" => 9405,
                    "CrashRating" => "Not Rated"
                    ],
                    [
                    "Description" => "2015 Audi A3 C FWD",
                    "VehicleId" => 9406,
                    "CrashRating" => "Not Rated"
                    ]
                ]
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
            "ratingOutput" => [
                "Count" => 2,
                "Results" => [
                    [
                    "Description" => "2015 Toyota Yaris 3 HB FWD",
                    "VehicleId" => 9791,
                    "CrashRating" => "Not Rated"
                    ],
                    [
                    "Description" => "2015 Toyota Yaris Liftback 5 HB FWD",
                    "VehicleId" => 9146,
                    "CrashRating" => "4"
                    ]
                ]
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
            "ratingOutput" => [
                "Count" => 0,
                "Results" => []
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
            "ratingOutput" => [
                "Count" => 0,
                "Results" => []
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
                "/{$parameters['modelYear']}".
                "/{$parameters['manufacturer']}".
                "/{$parameters['model']}".
                "?withRating=true");
    
            $this->assertEquals(
                json_encode($expected["ratingOutput"]),
                $this->response->getContent()
            );

            $this->get("/vehicles".
                "/{$parameters['modelYear']}".
                "/{$parameters['manufacturer']}".
                "/{$parameters['model']}".
                "?withRating=false");
    
            $this->assertEquals(
                json_encode($expected["output"]),
                $this->response->getContent()
            );

            $this->get("/vehicles".
                "/{$parameters['modelYear']}".
                "/{$parameters['manufacturer']}".
                "/{$parameters['model']}".
                "?withRating=bananas");
    
            $this->assertEquals(
                json_encode($expected["output"]),
                $this->response->getContent()
            );
        }
    }
}
