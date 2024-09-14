<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class PasienController extends Controller
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
        $pasien = new Pasien();
        $listPasien = $pasien->all()->toArray();
        $location = LokasiController::getAllLocationMappedId();
        $data = [];

        $data['pasien'] = $listPasien;
        $data['lokasi'] = $location;

        return view('pasien.index_pasien', $data);
    }

    public function tambahPasien()
    {
        $location = LokasiController::getAllLocation();
        $data['lokasi'] = $location;
        return view('pasien.tambah_pasien', $data);
    }

    public function savePasien(Request $request)
    {
        $pasienRequest = $request->all();

        $pasien = new Pasien();
        $pasien->nama = $pasienRequest['name'];
        $pasien->jenis_kelamin = $pasienRequest['jenis_kelamin'];
        $pasien->umur = (int) $pasienRequest['umur'];
        $pasien->lokasi_desa = $pasienRequest['lokasi_desa'];
        $pasien->tanggal_ditambahkan = Carbon::parse($pasienRequest['tanggal'])->toDateTimeString();
        $pasien->keterangan = $request['keterangan'];

        $pasien->save();

        return redirect('pasien');
    }    

    function editPasien(string $idPasien) 
    {
        $pasien = Pasien::find($idPasien);

        $location = LokasiController::getAllLocation();
        $data['lokasi'] = $location;
        $data['pasien'] = $pasien;
        return view('pasien.edit_pasien', $data);
    }

    function updatePasien(Request $request) 
    {
        $pasienRequest = $request->all();

        $pasien = Pasien::find($pasienRequest['id']);
        $pasien->nama = $pasienRequest['name'];
        $pasien->jenis_kelamin = $pasienRequest['jenis_kelamin'];
        $pasien->umur = (int) $pasienRequest['umur'];
        $pasien->lokasi_desa = $pasienRequest['lokasi_desa'];
        $pasien->tanggal_ditambahkan = Carbon::parse($pasienRequest['tanggal'])->toDateTimeString();
        $pasien->keterangan = $request['keterangan'];

        $pasien->save();

        return redirect('pasien');
    }
}
