<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="https://www.youtube.com/s/desktop/0e9d1cf9/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="https://www.youtube.com/s/desktop/0e9d1cf9/img/favicon_32x32.png" sizes="32x32">
    <link rel="icon" href="https://www.youtube.com/s/desktop/0e9d1cf9/img/favicon_48x48.png" sizes="48x48">
    <link rel="icon" href="https://www.youtube.com/s/desktop/0e9d1cf9/img/favicon_96x96.png" sizes="96x96">
    <link rel="icon" href="https://www.youtube.com/s/desktop/0e9d1cf9/img/favicon_144x144.png" sizes="144x144">
    <meta name="author" content="MET IRAQ" />
    <meta name="description" content="Content managers are prohibited from engaging in practices that attempt to go around or interfere with YouTube’s systems, processes, or policies." />

    <title>{{auth()->user()->name}} | Youtube CMS</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
    <!-- Custom styles for this template-->
    <link href="{{asset('assets/css/sb-admin-2.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/toastr.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/jsvectormap.css')}}" rel="stylesheet" />
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    <script src="https://unpkg.com/livewire-charts" defer></script> --}}
    <!-- Livewire Styles -->
    @yield('cssmap')

    @livewireStyles
    {{-- <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet"> --}}
</head>


<body id="page-top">
    <!-- Page Wrapper -->
    @include('artists.components.navLinks')
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    @include('utilities.logoutForm')

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>
    <script src="{{asset('assets/js/chart.js/Chart.min.js')}}"></script>
    <script>
        console.log('asd');
    </script>
    <!-- Livewire Scripts -->
    @livewireScripts

    <script type="text/javascript" src="{{asset('assets/js/toastr.js')}}"></script>
    {{-- <script src="https://unpkg.com/filepond/dist/filepond.js"></script> --}}

    @yield('dropZone')
    @yield('modalScript')
    @yield('scripts')
    <script>
        window.addEventListener('alert', event => { 
            console.log(event);
                     toastr[event.detail[0].type]
                     (event.detail[0].message, 
                     event.detail[0].title ?? ''), 
                     toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                        }
                    });
        </script>


</body>
</html>
