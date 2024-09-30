<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\ProfileController;
use App\Models\Pasien;
use App\Models\Range;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function getGeoJson(Request $request)
    {
        $yearMonth = $request->date ?? null;
        $dominan = $request->dominan ?? null;
        $periode = $request->yearPeriod ?? null;
        $choosendDesa = $request->id_desa ?? null;
        $range = ProfileController::getConfigRange();

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
        $seriesPasienBaru = [];
        $seriesPasienLama = [];
        $seriesPasienSembuh = [];
        $seriesPasienMeninggal = [];
        $seriesTotal = [];
        $jumlahPasienPenderitaBaru = 0;
        $jumlahPasienPenderitaLama = 0;
        $jumlahPasienSembuh = 0;
        $jumlahPasienMininggal = 0;
        foreach($geojson as $json) {            
            $feature = [];            
            if($json["sub_district"] === 'TABIR SELATAN') {
                
                if ($choosendDesa !== null) {
                    if ($json['id'] !== $choosendDesa) continue;
                    $yearMonth = null;
                }

                if ($yearMonth !== null) {
                    $month = last(explode('-', $yearMonth));
                    $year = explode('-', $yearMonth)[0];
                    $jumlahPasien = Pasien::where('lokasi_desa', $json['id'])
                                    ->whereMonth('tanggal_ditambahkan', $month)
                                    ->whereYear('tanggal_ditambahkan', $year)
                                    ->count();
                    
                    $jumlahPasienPenderitaBaru = Pasien::where('lokasi_desa', $json['id'])
                                    ->whereMonth('tanggal_ditambahkan', $month)
                                    ->whereYear('tanggal_ditambahkan', $year)
                                    ->where('keterangan', 'Penderita Baru')
                                    ->count();

                    $jumlahPasienPenderitaLama = Pasien::where('lokasi_desa', $json['id'])
                                    ->whereMonth('tanggal_ditambahkan', $month)
                                    ->whereYear('tanggal_ditambahkan', $year)
                                    ->where('keterangan', 'Penderita Lama')
                                    ->count();
                    
                    $jumlahPasienSembuh = Pasien::where('lokasi_desa', $json['id'])
                                    ->whereMonth('tanggal_ditambahkan', $month)
                                    ->whereYear('tanggal_ditambahkan', $year)
                                    ->where('keterangan', 'Pasien Sembuh')
                                    ->count();

                    $jumlahPasienMininggal = Pasien::where('lokasi_desa', $json['id'])
                                    ->whereMonth('tanggal_ditambahkan', $month)
                                    ->whereYear('tanggal_ditambahkan', $year)
                                    ->where('keterangan', 'Meninggal Dunia')
                                    ->count();

                                        
                } else {
                    if ($periode === null) {
                        $jumlahPasien = Pasien::where('lokasi_desa', $json['id'])->count();
                        $jumlahPasienPenderitaBaru = Pasien::where('lokasi_desa', $json['id'])                            
                            ->where('keterangan', 'Penderita Baru')
                            ->count();

                        $jumlahPasienPenderitaLama = Pasien::where('lokasi_desa', $json['id'])                            
                            ->where('keterangan', 'Penderita Lama')
                            ->count();
            
                        $jumlahPasienSembuh = Pasien::where('lokasi_desa', $json['id'])                            
                            ->where('keterangan', 'Pasien Sembuh')
                            ->count();

                        $jumlahPasienMininggal = Pasien::where('lokasi_desa', $json['id'])                            
                            ->where('keterangan', 'Meninggal Dunia')
                            ->count();

                    } else {
                        $jumlahPasien = Pasien::where('lokasi_desa', $json['id'])
                            ->whereYear('tanggal_ditambahkan', $periode)
                            ->count();

                        $jumlahPasienPenderitaBaru = Pasien::where('lokasi_desa', $json['id'])
                            ->whereYear('tanggal_ditambahkan', $periode)
                            ->where('keterangan', 'Penderita Baru')
                            ->count();

                        $jumlahPasienPenderitaLama = Pasien::where('lokasi_desa', $json['id'])
                            ->whereYear('tanggal_ditambahkan', $periode)
                            ->where('keterangan', 'Penderita Lama')
                            ->count();
            
                        $jumlahPasienSembuh = Pasien::where('lokasi_desa', $json['id'])
                            ->whereYear('tanggal_ditambahkan', $periode)
                            ->where('keterangan', 'Pasien Sembuh')
                            ->count();

                        $jumlahPasienMininggal = Pasien::where('lokasi_desa', $json['id'])
                            ->whereYear('tanggal_ditambahkan', $periode)
                            ->where('keterangan', 'Meninggal Dunia')
                            ->count();
                    }
                }                

                if($dominan !== null) {
                    if(in_array('parah', $dominan) === false && $jumlahPasien > $range['parah'] ) {
                        continue;
                    }

                    if (in_array('sedang', $dominan) === false && $jumlahPasien > $range['sedang'] && $jumlahPasien <= $range['parah']) {
                        continue;
                    }

                    if (in_array('aman', $dominan) === false && $jumlahPasien <= $range['sedang']) {
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
                        "Pasien" => strval($jumlahPasien), 
                        "PasienBaru" =>  strval($jumlahPasienPenderitaBaru), 
                        "PasienLama" =>  strval($jumlahPasienPenderitaLama), 
                        "PasienSemuh" =>  strval($jumlahPasienSembuh),
                        "PasienMeninggal" => strval($jumlahPasienMininggal)
                    ],
                    "geometry" => [
                        "type" => "Polygon",
                        "coordinates" => []
                    ]
                ];

                $seriesPasienBaru[] = $jumlahPasienPenderitaBaru;
                $seriesPasienLama[] = $jumlahPasienPenderitaLama;
                $seriesPasienSembuh[] = $jumlahPasienSembuh;
                $seriesPasienMeninggal[] = $jumlahPasienMininggal;
                $seriesTotal[] = $jumlahPasien;
                
                $xSeries[] = $json["village"];

                $feature["geometry"]["coordinates"] = [$json["border"]];

                $featureCollection["features"][] = $feature;
            }            
        }

        $series[] = [
            'name' => 'Pasien Baru', 
            'data' => $seriesPasienBaru
        ];
        $series[] = [
            'name' => 'Pasien Lama',
            'data' => $seriesPasienLama
        ];
        $series[] = [
            'name' => 'Pasien Sembuh',
            'data' => $seriesPasienSembuh
        ];
        $series[] = [
            'name' => 'Pasien Meninggal',
            'data' => $seriesPasienMeninggal
        ];
        $series[] = [
            'name' => 'Total',
            'data' => $seriesTotal
        ];

        $featureCollection['chartSeries'] = $series;
        $featureCollection['chartXSeries'] = $xSeries;

        return response()->json($featureCollection, 200);
    }

    public function getDetailMap(Request $request)
    {
        $request = $request->all();

        $date = null;
        $periode = null;
        $idDesa = (int) $request['idDesa'];

        if (isset($request['date']) && $request['date'] !== null) $date = $request['date'];
        if (isset($request['yearPeriode']) && $request['yearPeriode'] !== null) $periode = $request['yearPeriode'];

        $geoJsonRaw = file_get_contents(storage_path('app') . DIRECTORY_SEPARATOR . 'jambi_villages_restored.geojson');
        $geojson = \json_decode($geoJsonRaw, true);

        $location = [];
        foreach ($geojson as $json) {
            if ($json["sub_district"] === 'TABIR SELATAN') {
                $location[$json['id']] = [
                    'id' => $json['id'],
                    "province" => $json['province'],
                    "district" => $json['district'],
                    "sub_district" => $json['sub_district'],
                    "village" => $json['village']
                ];
            }
        }

        if ($date !== null) {
            $month = last(explode('-', $date));
            $year = explode('-', $date)[0];
            $semuaPasien = Pasien::where('lokasi_desa', $idDesa)
                ->whereMonth('tanggal_ditambahkan', $month)
                ->whereYear('tanggal_ditambahkan', $year)
                ->get();
        } else {
            if ($periode === null) {
                $semuaPasien = Pasien::where('lokasi_desa', $idDesa)->get();
            } else {
                $semuaPasien = Pasien::where('lokasi_desa', $idDesa)
                    ->whereYear('tanggal_ditambahkan', $periode)
                    ->get();
            }
        }

        $result = [];
        foreach ($semuaPasien as $pasien) {
            $result[] = [
                'id' => $pasien['id'],
                'nama_pasien' => $pasien['nama'],
                'jenis_kelamin' => $pasien['jenis_kelamin'],
                'tanggal_periksa' => $pasien['tanggal_ditambahkan'],
                'umur' => $pasien->umur,
                'lokasi' => $location[$pasien['lokasi_desa']]['sub_district'],
                'keterangan' => $pasien['keterangan']
            ];
        }

        return response()->json($result, 200);
    }

    public function getChartSeries(Request $request)
    {
        $tahun = $request->tahun;
        $idDesa = $request->idDesa;        
        $series = [];
        $pasienSebulan = [];
        $seriesPasienBaru = [];
        $seriesPasienLama = [];
        $seriesPasienSembuh = [];
        $seriesPasienMeninggal = [];

        for ($a = 1; $a <= 12; $a++) {

            $querySebulan  =  Pasien::whereYear('tanggal_ditambahkan', $tahun)
                ->whereMonth('tanggal_ditambahkan', $a);                
            if($idDesa !== null) $querySebulan->where('lokasi_desa', $idDesa);                
            $pasienSebulan[] = $querySebulan->count();

            $queryPasienBaru =  Pasien::whereYear('tanggal_ditambahkan', $tahun)
                ->whereMonth('tanggal_ditambahkan', $a)
                ->where('keterangan', 'Penderita Baru');
            if($idDesa !== null) $queryPasienBaru->where('lokasi_desa', $idDesa);
            $seriesPasienBaru[] = $queryPasienBaru->count();
            
            $queryPasienLama =  Pasien::whereYear('tanggal_ditambahkan', $tahun)
                ->whereMonth('tanggal_ditambahkan', $a)
                ->where('keterangan', 'Penderita Lama');
            if($idDesa !== null) $queryPasienLama->where('lokasi_desa', $idDesa);            
            $seriesPasienLama[] = $queryPasienLama->count();
            

            $queryPasienSembuh =  Pasien::whereYear('tanggal_ditambahkan', $tahun)
                ->whereMonth('tanggal_ditambahkan', $a)
                ->where('keterangan', 'Pasien Sembuh');
            if($idDesa !== null) $queryPasienSembuh->where('lokasi_desa', $idDesa);                
            $seriesPasienSembuh[] = $queryPasienSembuh->count();

            $queryPasienMeninggal =  Pasien::whereYear('tanggal_ditambahkan', $tahun)
                ->whereMonth('tanggal_ditambahkan', $a)
                ->where('keterangan', 'Meninggal Dunia');            
            if($idDesa !== null) $queryPasienMeninggal->where('lokasi_desa', $idDesa);                
            $seriesPasienMeninggal[] = $queryPasienMeninggal->count();
                        
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



        $series[] = [
            'name' => 'Pasien Baru', 
            'data' => $seriesPasienBaru
        ];
        $series[] = [
            'name' => 'Pasien Lama',
            'data' => $seriesPasienLama
        ];
        $series[] = [
            'name' => 'Pasien Sembuh',
            'data' => $seriesPasienSembuh
        ];
        $series[] = [
            'name' => 'Pasien Meninggal',
            'data' => $seriesPasienMeninggal
        ];
        $series[] = [
            'name' => 'Total',
            'data' => $pasienSebulan
        ];

        $result = [
            'chartXSeries' => $bulanSeries,
            'chartSeries' => $series
        ];

        if($idDesa !== null){
            $lokasi = LokasiController::getAllLocationMappedId();

            $feature = [];
            foreach($lokasi as $lok) {

                if($lok['id'] !== $idDesa) continue;

                $feature = [
                    "type" => "Feature",
                    "properties" => [
                        "id" => $lok['id'],
                        "Provinsi" => $lok["Provinsi"],
                        "Kabupaten" => $lok["Kabupaten"],
                        "Kecamatan" => $lok["Kecamatan"],
                        "Desa" => $lok["Desa"],
                        // "Pasien" => strval($pasienSebulan), 
                        // "PasienBaru" =>  strval($seriesPasienBaru), 
                        // "PasienLama" =>  strval($seriesPasienLama), 
                        // "PasienSemuh" =>  strval($seriesPasienSembuh),
                        // "PasienMeninggal" => strval($seriesPasienMeninggal)
                    ],
                    "geometry" => [
                        "type" => "Polygon",
                        "coordinates" => $lok['coordinates']
                    ]
                ];
            }

            $result['features'] = $feature;
        }
        
        return response()->json($result, 200);
    }

    public function getConfigRangeJson()
    {
        $range = Range::find(1);

        return response()->json([
            'parah' => $range->parah,
            'sedang' => $range->sedang,
            'rendah' => $range->rendah,
        ]);
    }
}
