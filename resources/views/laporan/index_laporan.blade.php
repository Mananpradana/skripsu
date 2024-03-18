@extends('layouts.app')

@section('style')

<style>

    th {
        text-align: center;
    }

    td {
        text-align: center;
    }

    .colom-align-left {
        text-align: left;
    }

</style>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Laporan
                </div>

                <div class="card-body p-1">
                    <div class="container">
                        
                        <div class="col position-relative">                            
                            <center>
                                <h5>Laporan Pasien Tahun {{ date('Y') }}</h5>
                            </center>                            
                        </div>
                        <div class="col-12 position-relative" >
                            <table class="table table-responsive table-bordered table-sm">
                                <thead>
                                    <tr class="align-middle">
                                        <th scope="col" rowspan="2">#No</th>                                    
                                        <th scope="col" rowspan="2">Nama Desa</th>
                                        <th scope="col" colspan="3">Januari</th>
                                        <th scope="col" colspan="3">Februai</th>
                                        <th scope="col" colspan="3">Maret</th>
                                        <th scope="col" colspan="3">April</th>
                                        <th scope="col" colspan="3">Mei</th>
                                        <th scope="col" colspan="3">Juni</th>
                                        <th scope="col" colspan="3">Juli</th>
                                        <th scope="col" colspan="3">Agustus</th>
                                        <th scope="col" colspan="3">September</th>
                                        <th scope="col" colspan="3">Oktober</th>
                                        <th scope="col" colspan="3">November</th>
                                        <th scope="col" colspan="3">Desember</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @for($a = 0; $a < (count($laporan)-1); $a++)

                                        <tr>
                                            <th scope="row">{{ $a+1 }}</th>                                            
                                            <td class="colom-align-left">{{ $laporan[$a]['desa'] }}</td>
                                            
                                            @foreach($laporan[$a]['data'] as $indexData => $data)
                                                <td>{{ $data['pria_tahun_ini'] }}</td>
                                                <td>{{ $data['wanita_tahun_ini'] }}</td>
                                                <td>{{ $data['jml_tahun_ini'] }}</td>
                                            @endforeach                                            
                                        </tr>                                            

                                    @endfor                                        

                                        <tr>
                                            <th scope="row">{{ '#' }}</th>                                            
                                            <th class="colom-align-left">{{ 'TOTAL' }}</th>
                                            
                                            @foreach($laporan[count($laporan)-1]['data'] as $indexData => $data)
                                                <td>{{ $data['total_pria'] }}</td>
                                                <td>{{ $data['total_wanita'] }}</td>
                                                <td>{{ $data['total'] }}</td>
                                            @endforeach                                            
                                        </tr>

                                </tbody>
                            </table>
                        </div>
                        
                    </div>

                    <div class="container">
                        
                        <div class="col position-relative">                            
                            <center>
                                <h5>Laporan Pasien Tahun {{ date('Y')-1 }}</h5>
                            </center>                            
                        </div>
                        <div class="col-12 position-relative" >
                            <table class="table table-responsive table-bordered table-sm">
                                <thead>
                                    <tr class="align-middle">
                                        <th scope="col" rowspan="2">#No</th>                                    
                                        <th scope="col" rowspan="2">Nama Desa</th>
                                        <th scope="col" colspan="3">Januari</th>
                                        <th scope="col" colspan="3">Februai</th>
                                        <th scope="col" colspan="3">Maret</th>
                                        <th scope="col" colspan="3">April</th>
                                        <th scope="col" colspan="3">Mei</th>
                                        <th scope="col" colspan="3">Juni</th>
                                        <th scope="col" colspan="3">Juli</th>
                                        <th scope="col" colspan="3">Agustus</th>
                                        <th scope="col" colspan="3">September</th>
                                        <th scope="col" colspan="3">Oktober</th>
                                        <th scope="col" colspan="3">November</th>
                                        <th scope="col" colspan="3">Desember</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>

                                        <th scope="col">L</th>
                                        <th scope="col">P</th>
                                        <th scope="col">Jml</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @for($a = 0; $a < (count($laporan)-1); $a++)

                                        <tr>
                                            <th scope="row">{{ $a+1 }}</th>                                            
                                            <td class="colom-align-left">{{ $laporan[$a]['desa'] }}</td>
                                            
                                            @foreach($laporan[$a]['data'] as $indexData => $data)
                                                <td>{{ $data['pria_tahun_lalu'] }}</td>
                                                <td>{{ $data['wanita_tahun_lalu'] }}</td>
                                                <td>{{ $data['jml_tahun_lalu'] }}</td>
                                            @endforeach                                            
                                        </tr>                                            

                                    @endfor

                                        <tr>
                                            <th scope="row">{{ '#' }}</th>                                            
                                            <th class="colom-align-left">{{ 'TOTAL' }}</th>
                                            
                                            @foreach($laporan[count($laporan)-1]['data'] as $indexData => $data)
                                                <td>{{ $data['total_pria_tahun_lalu'] }}</td>
                                                <td>{{ $data['total_wanita_tahun_lalu'] }}</td>
                                                <td>{{ $data['total_tahun_lalu'] }}</td>
                                            @endforeach                                            
                                        </tr>
                                        
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
