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
                        
                        <div class="col-12">
                            <form>
                            <div class="mb-3">
                                    <label for="provinsi" class="form-label">Provinsi</label>
                                    <input type="text" class="form-control" id="provinsi" name="provinsi" value="JAMBI" disabled readonly>                                    
                                </div>
                                <div class="mb-3">
                                    <label for="kabupaten" class="form-label">Kabupaten</label>
                                    <input type="text" class="form-control" id="kabupaten" name="kabupaten" value="MERANGIN" disabled readonly>                                    
                                </div>
                                <div class="mb-3">
                                    <label for="kecamatan" class="form-label">Kecamatan</label>
                                    <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="TABIR SELATAN" disabled readonly>                                    
                                </div>
                                <div class="mb-3">
                                    <label for="kelurahan" class="form-label">Nama Keluarahan</label>
                                    <input type="text" class="form-control" id="kelurahan" name="desa" >                                    
                                </div>
                                <div class="mb-3">
                                    <label for="json_coordinates" class="form-label">JSON Koordinat</label>
                                    <textarea type="password" class="form-control" id="json_coordinates" name="json_coordinates" rows="10">
                                    </textarea>
                                    <div class="form-text">Cek Contoh <a href="{{ route('coordinateExample')}}">disini</a></div>
                                </div>                                
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
