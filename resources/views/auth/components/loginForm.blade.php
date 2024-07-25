<div class="row">
    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
    <div class="col-lg-6">
        <div class="p-5">
            <div class="text-center">
                <img src="{{asset('assets/img/mstudioc _pwa.png')}}" width="60" class="d-lg-none mb-3" alt="mstudioiraq">
                <h1 class="h4 text-gray-900 mb-4">M STUDIO IRAQ | YOUTUBE</h1>
            </div>
            {{-- @php
                Hash::make('Ev@101Sa')
            @endphp --}}
            <form class="user" action="{{route('logging')}}" method="post">
            {{-- <form class="user" action="" method="post"> --}}
                @csrf
                <div class="form-group">
                    <input type="email" name="email" class="form-control form-control-user"
                        id="exampleInputEmail" aria-describedby="emailHelp"
                        placeholder="Enter Email Address..." />
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control form-control-user"
                        id="exampleInputPassword" placeholder="Password" />
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck" />
                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                    {{__('Login')}}
                </button>
            </form>
        </div>
    </div>
</div>