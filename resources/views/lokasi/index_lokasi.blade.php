@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Lokasi                    
                </div>

                <div class="card-body">
                    <div class="container">
                        
                        <div class="col position-relative">
                            <button class="btn btn-danger position-absolute end-0">
                                Tambah Lokasi
                            </button>                            
                        </div>

                        <div class="col-12 position-relative" >
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">#ID</th>                                    
                                    <th scope="col">Provinsi</th>
                                    <th scope="col">Kabupaten</th>
                                    <th scope="col">Kecamatan</th>
                                    <th scope="col">Desa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lokasi as $indexLocation => $l)
                                        <tr>
                                            <th scope="row">{{ $l['id'] }}</th>                                            
                                            <td>{{ $l['Provinsi'] }}</td>
                                            <td>{{ $l['Kabupaten'] }}</td>
                                            <td>{{ $l['Kecamatan'] }}</td>
                                            <td>{{ $l['Desa'] }}</td>
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
