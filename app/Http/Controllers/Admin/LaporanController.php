<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LaporanController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {
        $bulan = [
            '',
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
        $laporan = [];
        $barisTotal = [];
        $total = [];
        $location = $this->getAllLocationMappedId();                
        foreach($location as $lokasi) {
            
            $tmpLokasi = [];            

            for($a=1; $a<=12; $a++) {
                
                $priaPerBulanTahunIni = Pasien::where('lokasi_desa', $lokasi['id'])
                                        ->whereMonth('tanggal_ditambahkan', $a)
                                        ->whereYear('tanggal_ditambahkan', date('Y'))
                                        ->where('jenis_kelamin', 'Pria')
                                        ->count();
                
                $wanitaPerBulanTahunIni = Pasien::where('lokasi_desa', $lokasi['id'])
                                            ->whereMonth('tanggal_ditambahkan', $a)
                                            ->whereYear('tanggal_ditambahkan', date('Y'))
                                            ->where('jenis_kelamin', 'Wanita')
                                            ->count();

                $priaPerBulanTahunLalu = Pasien::where('lokasi_desa', $lokasi['id'])
                                            ->whereMonth('tanggal_ditambahkan', $a)
                                            ->whereYear('tanggal_ditambahkan', date('Y')-1)
                                            ->where('jenis_kelamin', 'Pria')
                                            ->count();
                    
                $wanitaPerBulanTahunLalu = Pasien::where('lokasi_desa', $lokasi['id'])
                                                ->whereMonth('tanggal_ditambahkan', $a)
                                                ->whereYear('tanggal_ditambahkan', date('Y')-1)
                                                ->where('jenis_kelamin', 'Wanita')
                                                ->count();

                $jml_tahun_ini = $priaPerBulanTahunIni + $wanitaPerBulanTahunIni;
                $jml_tahun_lalu = $priaPerBulanTahunLalu + $wanitaPerBulanTahunLalu;
                $tempLaporan = [
                    'bulan' => $bulan[$a],
                    'pria_tahun_ini' => $priaPerBulanTahunIni,
                    'wanita_tahun_ini' => $wanitaPerBulanTahunIni,
                    'jml_tahun_ini' => $jml_tahun_ini,
                    'pria_tahun_lalu' => $priaPerBulanTahunLalu,
                    'wanita_tahun_lalu' => $wanitaPerBulanTahunLalu,
                    'jml_tahun_lalu' => $jml_tahun_lalu
                ];            
                
                if(isset($total[$a-1]) === true ) {
                    $total[$a-1]['total_pria'] += $priaPerBulanTahunIni;
                    $total[$a-1]['total_wanita'] += $wanitaPerBulanTahunIni;
                    $total[$a-1]['total'] += $jml_tahun_ini;

                    $total[$a-1]['total_pria_tahun_lalu'] += $priaPerBulanTahunLalu;
                    $total[$a-1]['total_wanita_tahun_lalu'] += $wanitaPerBulanTahunLalu;
                    $total[$a-1]['total_tahun_lalu'] += $jml_tahun_lalu;    
                } else {
                    $total[$a-1] = [
                        'bulan' => $bulan[$a],
                        'total_pria' => $priaPerBulanTahunIni, 
                        'total_wanita' => $wanitaPerBulanTahunIni, 
                        'total' => $jml_tahun_ini,
                        'total_pria_tahun_lalu' => $priaPerBulanTahunLalu,
                        'total_wanita_tahun_lalu' => $wanitaPerBulanTahunLalu, 
                        'total_tahun_lalu' => $jml_tahun_lalu
                    ];
                }
                
                $tmpLokasi[] = $tempLaporan;                                  
            }                   
            
            $laporan[] = [                
                'data' => $tmpLokasi, 
                'desa' => $lokasi['Desa']
            ];
        }
        
        $laporan[] = [
            'data' => $total            
        ];
        
        $data['laporan'] = $laporan;

        return view('laporan.index_laporan', $data);
    }


    public static function getAllLocationMappedId() 
    {
        $geoJsonRaw = file_get_contents(storage_path('app') . DIRECTORY_SEPARATOR . 'jambi_villages_restored.geojson');

        $geojson = \json_decode($geoJsonRaw, true);
    
        $location = [];
        foreach($geojson as $json) {
            $feature = [];

            if($json["sub_district"] === 'TABIR SELATAN') {                
            
                $feature = [                    
                    "id" => $json["id"],
                    "Provinsi" => $json["province"],
                    "Kabupaten" => $json["district"],
                    "Kecamatan" => $json["sub_district"], 
                    "Desa" => $json["village"],                    
                    "coordinates" => []                    
                ];                

                $location[$json["id"]] = $feature;
            }
                        
        }    

        return $location;
    }

}
