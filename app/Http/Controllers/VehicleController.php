<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    protected $baseUrl = "https://one.nhtsa.gov/webapi/api/SafetyRatings";

    public function getWithPathParams(Request $request, $year, $manufacturer, $model)
    {
        return $this->getVehicles($request, $year, $manufacturer, $model);
    }

    public function post(Request $request)
    {
        if ($request->isJson()) {
            $parameters = $request->json()->all();
            $year = $request->json()->get("modelYear");
            $manufacturer = $request->json()->get("manufacturer");
            $model = $request->json()->get("model");
            return $this->getVehicles($request, $year, $manufacturer, $model);
        } else {
            return $this->getVehicles($request);
        }
    }

    protected function getVehicles(Request $request, $year = "", $manufacturer = "", $model = "")
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

        $results = array();

        if (isset($content->Results)) {
            foreach ($content->Results as $contentResult) {
                $results[] = [
                    "Description" => $contentResult->VehicleDescription,
                    "VehicleId" => $contentResult->VehicleId,
                ];
            }
        }

        if ($request->get("withRating") == "true") {
            foreach ($results as $key => $result) {
                $fullVehicleUrl = $this->baseUrl.
                    "/VehicleId/{$result['VehicleId']}?format=json";
                
                $rawVehicleData = Curl::to($fullVehicleUrl)
                    ->get();

                $vehicleContent = json_decode($rawVehicleData);
                    
                if (isset($vehicleContent->Results[0]->OverallRating)) {
                    $rating = $vehicleContent->Results[0]->OverallRating;
                } else {
                    $rating = "Not Rated";
                }
                $result["CrashRating"] = $rating;
                $results[$key] = $result;
            }
        }

        $output["Results"] = $results;

        return response(json_encode($output))
            ->header('Content-Type', 'application/json');
    }
}
