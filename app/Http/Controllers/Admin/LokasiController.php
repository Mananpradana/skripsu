<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LokasiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

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
        $data['lokasi'] = self::getAllLocation();
        return view('lokasi.index_lokasi', $data);
    }

    public function tambahLokasi()
    {
        return view('lokasi.tambah_lokasi');
    }

    public function contohJsonLokasi()
    {
        $json_coordinate_example = file_get_contents(\public_path('json_coordinate_example.json'));
        echo $json_coordinate_example;
    }

    public static function getAllLocation()
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

                $feature["coordinates"] = [$json["border"]];

                $location[] = $feature;
            }
                        
        }    

        return $location;
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

                $feature["coordinates"] = [$json["border"]];

                $location[$json["id"]] = $feature;
            }
                        
        }    

        return $location;
    }


}
