@extends('layouts.app')

@section('style')

<style>
    th {
        text-align: center;
    }

    td {
        text-align: center;
    }

    .align-middle .colom-align-left {
        text-align: left !important;
    }
</style>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Laporan </h3>

                    <div class="float-end">
                        <form action="{{ url('laporan') }}" method="GET">
                            <select class="form-select" name="tahun">
                                <option value="">- Semua Tahun -</option>
                                <option value="2022" @if($option['tahun']==='2022' ) {{'selected'}} @endif>2022</option>
                                <option value="2023" @if($option['tahun']==='2023' ) {{'selected'}} @endif>2023</option>
                                <option value="2024" @if($option['tahun']==='2024' ) {{'selected'}} @endif>2024</option>
                            </select>

                            <select class="form-select my-1" name="bulan">
                                <option value="">- Semua Bulan -</option>
                                <option value="1" @if($option['bulan']==='1' ) {{'selected'}} @endif>Januari</option>
                                <option value="2" @if($option['bulan']==='2' ) {{'selected'}} @endif>Februari</option>
                                <option value="3" @if($option['bulan']==='3' ) {{'selected'}} @endif>Maret</option>
                                <option value="4" @if($option['bulan']==='4' ) {{'selected'}} @endif>April</option>
                                <option value="5" @if($option['bulan']==='5' ) {{'selected'}} @endif>Mei</option>
                                <option value="6" @if($option['bulan']==='6' ) {{'selected'}} @endif>Juni</option>
                                <option value="7" @if($option['bulan']==='7' ) {{'selected'}} @endif>Juli</option>
                                <option value="8" @if($option['bulan']==='8' ) {{'selected'}} @endif>Agustus</option>
                                <option value="9" @if($option['bulan']==='9' ) {{'selected'}} @endif>September</option>
                                <option value="10" @if($option['bulan']==='10' ) {{'selected'}} @endif>Oktober</option>
                                <option value="11" @if($option['bulan']==='11' ) {{'selected'}} @endif>November</option>
                                <option value="12" @if($option['bulan']==='12' ) {{'selected'}} @endif>Desember</option>
                            </select>

                            <a class="btn btn-primary btn-sm float-end mx-2" href="{{ URL::to('/laporan/export'.'?tahun=' . $option['tahun'] . '&bulan=' . $option['bulan'] ) }}" target="_blank">Export</a>
                            <button class="btn btn-success btn-sm float-end" type="submit" name="tampilkan">Tampilkan</button>
                        </form>
                    </div>

                </div>

                <div class="card-body p-1">

                    @foreach($laporan as $year=>$dataYear)
                    <div class="container">

                        <div class="col position-relative">
                            <center>
                                <h5>Laporan Pasien Diabetes Melitus Kecamatan Tabir Selatan {{ $year }}</h5>
                            </center>
                        </div>
                        <div class="col-12 position-relative">
                            <table class="table table-responsive table-bordered table-sm">
                                <thead>

                                    <tr class="align-middle">
                                        <th scope="col" rowspan="2">#No</th>
                                        <th scope="col" rowspan="2">Nama Desa</th>

                                        @foreach($dataYear[0]['data'] as $dataBulan)
                                        <th scope="col" colspan="3">{{$dataBulan['bulan']}}</th>
                                        @endforeach

                                    </tr>
                                    <tr>
                                        @foreach($dataYear[0]['data'] as $dataBulan)

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataYear as $indexPerDesa=>$dataPerDesa)
                                    <tr class="align-middle">
                                        <th scope="col"> @if(($indexPerDesa+1) === count($dataYear)) {{ '#' }} @else {{$indexPerDesa+1}} @endif </th>
                                        <td scope="col" class="colom-align-left">{{ $dataPerDesa['desa'] }}</th>

                                            @foreach($dataPerDesa['data'] as $dataPerbulan)
                                        <td scope="col">{{ $dataPerbulan['pria'] }}</td>
                                        <td scope="col">{{ $dataPerbulan['wanita'] }}</td>
                                        <td scope="col">{{ $dataPerbulan['jml'] }}</td>
                                        @endforeach

                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                    </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection