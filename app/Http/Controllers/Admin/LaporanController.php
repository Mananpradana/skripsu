<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

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

    public function index(Request $request)
    {
        $formData = $request->all();
        
        $data = $this->getDataLaporan($formData['tahun'] ?? 'all', $formData['bulan'] ?? 'all');        
        $data['option'] = ['tahun' => $formData['tahun'] ?? '', 'bulan' => $formData['bulan'] ?? '' ];
        
        return view('laporan.index_laporan', $data);


    }

    public function exportPdf(Request $request)
    {
        $formData = $request->all();
        $data = $this->getDataLaporan($formData['tahun'] ?? 'all', $formData['bulan'] ?? 'all');
        $view = view('laporan.laporan-pdf', $data);

        $pdf = Pdf::loadHTML($view->render())->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

    private function getDataLaporan(string $tahunPilihan, string $bulanPilihan)
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
               
        

        $getYears = Pasien::selectRaw("YEAR(tanggal_ditambahkan)")->distinct()->get()->toArray();
        $years = [];
        $aStart = 1;
        $aMax = 12;

        foreach($getYears as $indexYears =>$tahun) {
            $years[] = array_values($tahun)[0];
        }        
        
        if($tahunPilihan !== 'all') {
            $years = [intVal($tahunPilihan)];
            $aStart = 1;
            $aMax = 12;
        }
        if($bulanPilihan !== 'all') {
            $aStart = intVal($bulanPilihan);
            $aMax = intVal($bulanPilihan);
        }

        $location = $this->getAllLocationMappedId();                
        
        $tmpTahun = [];
        foreach($years as $year) {            
            $laporan = [];                    
            $tmpTotal = [];

            foreach($location as $indexLokasi=>$lokasi) {
                
                $tmpLokasi = [];                  

                for($a=$aStart; $a<=$aMax; $a++) {
                    
                    $priaPerBulanTahunIni = Pasien::where('lokasi_desa', $lokasi['id'])
                                            ->whereMonth('tanggal_ditambahkan', $a)
                                            ->whereYear('tanggal_ditambahkan', $year)
                                            ->where('jenis_kelamin', 'Pria')
                                            ->count();
                    
                    $wanitaPerBulanTahunIni = Pasien::where('lokasi_desa', $lokasi['id'])
                                                ->whereMonth('tanggal_ditambahkan', $a)
                                                ->whereYear('tanggal_ditambahkan', $year)
                                                ->where('jenis_kelamin', 'Wanita')
                                                ->count();                    

                    $jml_tahun_ini = $priaPerBulanTahunIni + $wanitaPerBulanTahunIni;
                    
                    $tempLaporan = [
                        'bulan' => $bulan[$a],
                        'pria' => $priaPerBulanTahunIni,
                        'wanita' => $wanitaPerBulanTahunIni,
                        'jml' => $jml_tahun_ini,                        
                    ];                                
                    
                    $tmpLokasi[] = $tempLaporan;      
                    
                    if(isset($tmpTotal[$bulan[$a]]) === true ) {
                        
                        $tmpTotal[$bulan[$a]] = [
                            'pria' => $tmpTotal[$bulan[$a]]['pria'] + $priaPerBulanTahunIni, 
                            'wanita' => $tmpTotal[$bulan[$a]]['wanita'] + $wanitaPerBulanTahunIni, 
                            'jml' => $tmpTotal[$bulan[$a]]['jml'] + $jml_tahun_ini
                        ];
                    } else {
                        
                        $tmpTotal[$bulan[$a]] = [
                            'pria' => $priaPerBulanTahunIni, 
                            'wanita' => $wanitaPerBulanTahunIni, 
                            'jml' => $jml_tahun_ini
                        ];
                    }
                    
                }                                                                                   
                
                $laporan[] = [                
                    'data' => $tmpLokasi, 
                    'desa' => $lokasi['Desa']
                ];

                if($indexLokasi === count($location)) {
                    $laporan[] = [                
                        'data' => $tmpTotal, 
                        'desa' => 'TOTAL'
                    ];
                }
                
            }   
                        
            
            $tmpTahun[$year] = $laporan;
        }
        
        $data['laporan'] = $tmpTahun;
        return $data;
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
