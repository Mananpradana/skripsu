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
        $dominan = $request->dominan ?? null;       

        if($dominan !== null) {
            $dominan = explode(',', $dominan);
        }
        
        $geoJsonRaw = file_get_contents(storage_path('app') . DIRECTORY_SEPARATOR . 'jambi_villages_restored.geojson');  

        $geojson = \json_decode($geoJsonRaw, true);        

        $chartTitle = "Grafik Penyakit Diabetes Militus";
        
        $featureCollection = [
            "type" => "FeatureCollection",
            "features" => [], 
            "chartSeries" => [],
            "chartXSeries" => [],
            "chartTitle" => $chartTitle
        ];        
        
        $series = [];
        $xSeries = [];
        foreach($geojson as $json) {
            $feature = [];            
            if($json["sub_district"] === 'TABIR SELATAN') {
                
                if($yearMonth !== null) {
                    $month = last(explode('-', $yearMonth));
                    $jumlahPasien = Pasien::where('lokasi_desa', $json['id'])->whereMonth('tanggal_ditambahkan', $month)->count();
                } else {
                    $jumlahPasien = Pasien::where('lokasi_desa', $json['id'])->count();
                }

                if($dominan !== null) {
                    if(in_array('parah', $dominan) === false && $jumlahPasien > 30 ) {
                        continue;
                    }

                    if(in_array('sedang', $dominan) === false && $jumlahPasien > 15 && $jumlahPasien <= 30 ) {
                        continue;
                    }

                    if(in_array('aman', $dominan) === false && $jumlahPasien <= 15 ) {
                        continue;
                    }
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
                $series[] = $jumlahPasien;
                $xSeries[] = $json["village"];

                $feature["geometry"]["coordinates"] = [$json["border"]];

                $featureCollection["features"][] = $feature;            
            }                        
        }    
        
        $featureCollection['chartSeries'] = $series;
        $featureCollection['chartXSeries'] = $xSeries;            
        
        return response()->json($featureCollection, 200);
    }
}
