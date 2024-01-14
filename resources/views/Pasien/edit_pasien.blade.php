@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Tambah Pasien         
                </div>

                <div class="card-body">
                    <div class="container">
                        
                        <div class="col-12">
                            <form action="{{ route('updatePasien') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $pasien['id']  }}">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $pasien['nama'] }}" >
                                </div>
                                <div class="mb-3">
                                    <label class="col-sm-2 col-form-label">Jenis Kelamin</label>      
                                    <div class="col-sm-10">                              
                                        <input type="checkbox" name="jenis_kelamin" class="form-check-input" id="gender-pria" value="Pria" {{ $pasien['jenis_kelamin'] === 'Pria' ? 'checked' : '' }} >
                                        <label class="form-check-label" for="gender-pria">Pria</label>
                                        <input type="checkbox" name="jenis_kelamin" class="form-check-input" id="gender-wanita" value="Wanita" {{ $pasien['jenis_kelamin'] === 'Wanita' ? 'checked' : '' }} >
                                        <label class="form-check-label" for="gender-wanita">Wanita</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="umur" class="form-label">Umur</label>
                                    <input type="number" class="form-control" id="umur" name="umur" placeholder="Umur" value="{{ $pasien['umur'] }}" required>                                    
                                </div>
                                <div class="mb-3">
                                    <label for="lokasi_desa" class="form-label">Lokasi Desa</label>
                                    <select name="lokasi_desa" id="lokasi_desa" class="form-select" aria-label="Default select example" required>
                                        <option>Pilih Lokasi Desa</option>
                                        @foreach($lokasi as $l)                                        
                                            <option value="{{ $l['id']  }}" {{ $pasien['lokasi_desa'] == $l['id'] ? 'selected="selected"' : '' }} >{{ $l['Desa'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="datepicker" class="form-label" >Tanggal</label>
                                    <input id="datepicker" name="tanggal" value="{{ $pasien['tanggal_ditambahkan'] }}" required>                                    
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

@section('script')

<script>
    $('#datepicker').datepicker({
            uiLibrary: 'bootstrap5', 
            format: 'yyyy-mm-dd' 
    });
</script>

@endsection
