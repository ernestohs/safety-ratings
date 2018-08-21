<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Ixudra\Curl\Facades\Curl;

class VehicleController extends Controller
{
    protected $baseUrl = "https://one.nhtsa.gov/webapi/api/SafetyRatings";

    public function getWithPathParams($year, $manufacturer, $model)
    {
        $fullUrl = $this->baseUrl.
            "/modelyear/$year".
            "/make/$manufacturer".
            "/model/$model?format=json";

        $content = Curl::to($fullUrl)
            ->get();

        dd($content);
    }
}
