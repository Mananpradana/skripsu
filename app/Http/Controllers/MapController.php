<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    public function getGeoJson()
    {
        $geoJsonRaw = file_get_contents(storage_path('app') . DIRECTORY_SEPARATOR . 'jambi_villages_restored.geojson');

        $geojson = \json_decode($geoJsonRaw, true);
        // dump('data total (' . count($geojson) . ')');

        $featureCollection = [
            "type" => "FeatureCollection",
            "features" => []
        ];        
        foreach($geojson as $json) {
            $feature = [];

            if($json["sub_district"] === 'TABIR SELATAN') {
                // dump($json);
            
                $feature = [
                    "type" => "Feature", 
                    "properties" => [
                        "Provinsi" => $json["province"],
                        "Kabupaten" => $json["district"],
                        "Kecamatan" => $json["sub_district"], 
                        "Desa" => $json["village"]
                    ],
                    "geometry" => [
                        "type" => "Polygon", 
                        "coordinates" => []
                    ]
                ];

                $feature["geometry"]["coordinates"] = [$json["border"]];

                $featureCollection["features"][] = $feature;            
            }
            
            
        }    
        
        return response()->json($featureCollection, 200);
    }
}
