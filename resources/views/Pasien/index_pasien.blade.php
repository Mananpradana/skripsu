@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Pasien
                </div>

                <div class="card-body">
                    <div class="container">
                        
                        <div class="col-12 position-relative" style="min-height: 40px;">
                            <a class="btn btn-danger float-end" href="{{ url('/pasien/tambah') }}">
                                + Tambah Pasien
                            </a>                            
                        </div>

                        <div class="col-12 position-relative" >
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">#ID</th>                                    
                                    <th scope="col">Nama</th>
                                    <th scope="col">Jenis Kelamin</th>
                                    <th scope="col">Umur</th>
                                    <th scope="col">Lokasi Desa</th>
                                    <th scope="col">Bulan Tahun</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pasien as $indexPasiwn => $l)
                                        <tr>
                                            <th scope="row">{{ $l['id'] }}</th>                                            
                                            <td>{{ $l['nama'] }}</td>
                                            <td>{{ $l['jenis_kelamin'] }}</td>
                                            <td>{{ $l['umur'] }}</td>
                                            <td>{{ $lokasi[$l['lokasi_desa']]['Desa'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($l['tanggal_ditambahkan'])->format('M Y') }}</td>
                                            <td>                                                
                                                <a href="{{ url('/pasien/edit').'/'.$l['id'] }}" class="btn btn-primary btn-sm p-1" style="margin: 2px;">Edit</button>                                                                                            
                                            </td>
                                        </tr>    
                                    @endforeach
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
