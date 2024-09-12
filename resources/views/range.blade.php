@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ 'Config Range Legenda' }}</div>

                <div class="card-body">
                    <form action="{{ url('/config_range/save') }}" method="post">

                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                        @endif

                        <div class="mb-3 row">
                            <label for="parah" class="col-sm-2 col-form-label">Parah</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="parah" id="parah" required value="{{ $range['parah'] }}">
                            </div>
                            <div class="col-sm-2" style="background-color: #A83232;">
                                &nbsp;
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="sedang" class="col-sm-2 col-form-label">Sedang</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="sedang" id="sedang" required value="{{ $range['sedang'] }}">
                            </div>
                            <div class="col-sm-2" style="background-color: #F59631;">
                                &nbsp;
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="rendah" class="col-sm-2 col-form-label">Rendah</label>
                            <div class="col-sm-8">
                                <input type="number" name="rendah" class="form-control" id="rendah" required value="{{ $range['rendah'] }}">
                            </div>
                            <div class="col-sm-2" style="background-color: #32A852;">
                                &nbsp;
                            </div>
                        </div>                        

                        <div class="mb-3 row">
                            <button id="submitForm" class="btn btn-sm btn-primary" type="submit">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    
</script>
@endsection
