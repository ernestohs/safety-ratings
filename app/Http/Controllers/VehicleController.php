<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    protected $baseUrl = "https://one.nhtsa.gov/webapi/api/SafetyRatings";

    public function getWithPathParams($year, $manufacturer, $model)
    {
        return $this->getVehicles($year, $manufacturer, $model);
    }

    public function post(Request $request)
    {
        if ($request->isJson()) {
            $parameters = $request->json()->all();
            $year = $request->json()->get("modelYear");
            $manufacturer = $request->json()->get("manufacturer");
            $model = $request->json()->get("model");
            return $this->getVehicles($year, $manufacturer, $model);
        } else {
            return $this->getVehicles();
        }
    }

    protected function getVehicles($year = "", $manufacturer = "", $model = "")
    {
        $fullUrl = $this->baseUrl.
            "/modelyear/$year".
            "/make/$manufacturer".
            "/model/$model?format=json";

        $rawData = Curl::to($fullUrl)
            ->get();

        $content = json_decode($rawData);

        $output = [
            "Count" => 0,
            "Results" => []
        ];

        if (isset($content->Count)) {
            $output["Count"] = $content->Count;
        }

        if (isset($content->Results)) {
            foreach ($content->Results as $contentResult) {
                $output["Results"][] = [
                    "Description" => $contentResult->VehicleDescription,
                    "VehicleId" => $contentResult->VehicleId,
                ];
            }
        }

        return response(json_encode($output))
            ->header('Content-Type', 'application/json');
    }
}
