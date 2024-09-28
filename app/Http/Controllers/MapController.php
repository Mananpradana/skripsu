<?php

namespace App\Http\Controllers;

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
        foreach ($geojson as $json) {
            $feature = [];
            if ($json["sub_district"] === 'TABIR SELATAN') {

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
                } else {
                    if ($periode === null) {
                        $jumlahPasien = Pasien::where('lokasi_desa', $json['id'])->count();
                    } else {
                        $jumlahPasien = Pasien::where('lokasi_desa', $json['id'])
                            ->whereYear('tanggal_ditambahkan', $periode)
                            ->count();
                    }
                }

                if ($dominan !== null) {
                    if (in_array('parah', $dominan) === false && $jumlahPasien > $range['parah']) {
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

        $pasienSebulan = [];

        for ($a = 1; $a <= 12; $a++) {

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
