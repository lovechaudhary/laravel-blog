<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('app.name', 'Tech Blog') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">        

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom_style.css') }}">
</head>
<body>
    <div id="app">
        @include('inc.navbar')
        <main class="py-4">
            <div class="container container-fluid" style="min-height: 475px !important;">
                @include('inc.message')
                @yield('content')
            </div>            
        </main>

        <footer class="container">
            <div class="row">
                <div class="col-md-4 offset-4">
                    <small class="text-muted">
                        Designed & Developed by <a href="https://github.com" target="_blank" class="text-muted"><i>Love Chaudhary</i></a>
                    </small>                    
                </div>
            </div>
        </footer>
    </div>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>    
    {{-- <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script> --}}
    {{-- <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script> --}}
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
    @yield('script')
</body>
</html>
