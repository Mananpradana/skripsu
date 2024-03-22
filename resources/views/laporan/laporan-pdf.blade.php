<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="{{ public_path('css/bootstrap5/css/bootstrap.min.css') }}" rel="stylesheet">    

    <!-- Scripts -->
    
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />    

    <style>

        @page { 
            margin: 0px;
            size: 29.7cm 21cm ;
         }
        html { margin: 0px; }

        table{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: x-small;
            border: 1px solid;
            border-collapse: collapse;
        }

        th {
            text-align: center;
            border: 1px solid;
            border-collapse: collapse;
        }

        td {
            text-align: center;
            min-width: 20px;
            border: 1px solid;
            border-collapse: collapse;
        }

        .colom-align-left {
            text-align: left;
        }

        .font-smaller {
            font-size: xx-small;
        }

    </style>
</head>
<body>

<div class="py-4">    
    <div class="col-md-12">
        
        <div class="container">
            
            <div class="col position-relative">                                            
                <h5 style="text-align:center">Laporan Pasien Tahun {{ date('Y') }}</h5>                     
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
                                <td class="colom-align-left font-smaller">{{ $laporan[$a]['desa'] }}</td>
                                
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
                <h5 style="text-align:center">Laporan Pasien Tahun {{ date('Y')-1 }}</h5>                                     
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
                                <td class="colom-align-left font-smaller">{{ $laporan[$a]['desa'] }}</td>
                                
                                @foreach($laporan[$a]['data'] as $indexData => $data)
                                    <td>{{ $data['pria_tahun_lalu'] }}</td>
                                    <td>{{ $data['wanita_tahun_lalu'] }}</td>
                                    <td>{{ $data['jml_tahun_lalu'] }}</td>
                                @endforeach                                            
                            </tr>                                            

                        @endfor

                            <tr>
                                <th scope="row">{{ '#' }}</th>                                            
                                <th class="colom-align-left font-smaller">{{ 'TOTAL' }}</th>
                                
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
</di    v>

</body>
</html>
