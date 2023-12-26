<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function getGeoJson(Request $request)
    {
        $yearMonth = $request->date ?? null;        
        $geoJsonRaw = file_get_contents(storage_path('app') . DIRECTORY_SEPARATOR . 'jambi_villages_restored.geojson');                

        $geojson = \json_decode($geoJsonRaw, true);        

        $featureCollection = [
            "type" => "FeatureCollection",
            "features" => []
        ];        
        foreach($geojson as $json) {
            $feature = [];

            if($json["sub_district"] === 'TABIR SELATAN') {
                
                if($yearMonth !== null) {
                    $month = last(explode('-', $yearMonth));
                    $jumlahPasien = Pasien::where('lokasi_desa', $json['id'])->whereMonth('tanggal_ditambahkan', $month)->count();
                } else {
                    $jumlahPasien = Pasien::where('lokasi_desa', $json['id'])->count();
                }
                
                $feature = [
                    "type" => "Feature", 
                    "properties" => [
                        "id" => $json['id'],
                        "Provinsi" => $json["province"],
                        "Kabupaten" => $json["district"],
                        "Kecamatan" => $json["sub_district"], 
                        "Desa" => $json["village"], 
                        "Pasien" => strval($jumlahPasien)
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
