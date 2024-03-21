@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ 'Profile' }}</div>

                <div class="card-body">
                    <form action="{{ url('/profile/change-password') }}" method="post">

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
                            <label for="staticUsername" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="staticUsername" value="{{ $admin['username'] }}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $admin['email'] }}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                            <input type="password" name="newPassword" class="form-control" id="inputPassword" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="confirmPassword" class="col-sm-2 col-form-label">Confirm Password</label>
                            <div class="col-sm-10">
                            <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" required>
                            <div class="invalid-feedback" id="invalidPassword">
                                Password not a match.
                            </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <button id="submitForm" class="btn btn-sm btn-primary" type="submit" disabled="disabled">Ganti Password</button>
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
    $("#confirmPassword").on("keyup", function () {
        if (
                $("#inputPassword").val() != "" &&
                $("#confirmPassword").val() != "" &&
                $("#confirmPassword").val() != $("#inputPassword").val()
            ) {
                $('#invalidPassword').show()
                $('#submitForm').prop('disabled', true)
        } else {
            
                $('#invalidPassword').hide()
                $('#submitForm').prop('disabled', false)
        }
    });
</script>
@endsection
