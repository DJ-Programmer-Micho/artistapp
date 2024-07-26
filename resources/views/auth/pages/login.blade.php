@extends('auth.layout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    @livewire('auth.login-livewire')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection