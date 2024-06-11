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
            size: 29.7cm 21cm;
        }

        html {
            margin: 0px;
        }

        table {
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

        tbody tr td .colom-align-left {
            text-align: left !important;
        }

        .font-smaller {
            font-size: xx-small;
        }
    </style>
</head>

<body>

    <div class="py-4">
        <div class="col-md-12">
            @foreach($laporan as $year=>$dataYear)
            <div class="container">

                <div class="col position-relative">
                    <center>
                        <h5>Laporan Pasien Diabetes Melitus Kecamatan Tabir Selatan Tahun {{ $year }}</h5>
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

</body>

</html>