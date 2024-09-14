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
                            <form action="{{ route('savePasien') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>                                    
                                </div>
                                <div class="mb-3">
                                    <label class="col-sm-2 col-form-label">Jenis Kelamin</label>      
                                    <div class="col-sm-10">                              
                                        <input type="radio" name="jenis_kelamin" class="form-check-input" id="gender-pria" value="Pria" required>
                                        <label class="form-check-label" for="gender-pria">Pria</label>
                                        <input type="radio" name="jenis_kelamin" class="form-check-input" id="gender-wanita" value="Wanita">
                                        <label class="form-check-label" for="gender-wanita">Wanita</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="umur" class="form-label">Umur</label>
                                    <input type="number" class="form-control" id="umur" name="umur" placeholder="Umur" required>                                    
                                </div>
                                <div class="mb-3">
                                    <label for="lokasi_desa" class="form-label">Lokasi Desa</label>
                                    <select name="lokasi_desa" id="lokasi_desa" class="form-select" aria-label="Default select example" required>
                                        <option value="">Pilih Lokasi Desa</option>
                                        @foreach($lokasi as $l)                                        
                                            <option value="{{ $l['id']  }}">{{ $l['Desa'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="datepicker" class="form-label">Tanggal</label>
                                    <input id="datepicker" name="tanggal" required>                                    
                                </div>  
                                <div class="mb-3">
                                    <label class="col-sm-2 col-form-label">Keterangan</label>      
                                    <div class="col-sm-10">                              
                                        
                                        <input type="radio" name="keterangan" class="form-check-input" id="deritabaru" value="Penderita Baru" required>
                                        <label class="form-check-label" for="deritabaru">Penderita Baru</label>

                                        <input type="radio" name="keterangan" class="form-check-input" id="derialama" value="Penderita Lama" required>
                                        <label class="form-check-label" for="derialama">Penderita Lama</label>

                                        <input type="radio" name="keterangan" class="form-check-input" id="pasiensembuh" value="Pasien Sembuh" required>
                                        <label class="form-check-label" for="pasiensembuh">Pasien Sembuh</label>

                                        <input type="radio" name="keterangan" class="form-check-input" id="meninggal" value="Meninggal Dunia" required>
                                        <label class="form-check-label" for="meninggal">Meninggal Dunia</label>

                                    </div>
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
            format: 'dd-mm-yyyy' 
    });
</script>

@endsection
