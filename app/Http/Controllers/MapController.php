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

    public function getDetailMap(Request $request)
    {
        $idDesa = (int) $request->idDesa;

        $geoJsonRaw = file_get_contents(storage_path('app') . DIRECTORY_SEPARATOR . 'jambi_villages_restored.geojson');  
        $geojson = \json_decode($geoJsonRaw, true);     

        $location = [];
        foreach($geojson as $json) {
            if($json["sub_district"] === 'TABIR SELATAN') {
                $location[$json['id']] = [
                    'id' => $json['id'], 
                    "province" => $json['province'],
                    "district" => $json['district'],
                    "sub_district" => $json['sub_district'],
                    "village" => $json['village']
                ];  
            }
        }

        

        $semuaPasien = Pasien::where('lokasi_desa', $idDesa)->get();
        $result = [];
        foreach ($semuaPasien as $pasien) {
            $result[] = [
                'id' => $pasien['id'],
                'nama_pasien' => $pasien['nama'],
                'jenis_kelamin' => $pasien['jenis_kelamin'],
                'tanggal_periksa' => $pasien['tanggal_ditambahkan'],
                'umur' => $pasien->umur, 
                'lokasi' => $location[$pasien['lokasi_desa']]['sub_district']
            ];
        }

        return response()->json($result, 200);
    }

    public function getChartSeries(Request $request) 
    {
        $tahun = $request->tahun;
        $idDesa = $request->idDesa;

        $pasienSebulan = [];

        for($a = 1; $a <= 12; $a++) {
            
            $pasienSebulan[] =  Pasien::whereYear('tanggal_ditambahkan', $tahun)
                                ->whereMonth('tanggal_ditambahkan', $a)
                                ->where('lokasi_desa', $idDesa)                                
                                ->count();
        }        

        $bulanSeries = [
            'Januari', 
            'Februari', 
            'Maret', 
            'April',
            'Mei', 
            'Juni', 
            'Juli',
            'Agustus',
            'September', 
            'Oktober', 
            'November',
            'Desember'
        ];  

        $result = [
            'chartXSeries' => $bulanSeries, 
            'chartSeries' => $pasienSebulan
        ];
        
        return response()->json($result, 200);
    }
}
