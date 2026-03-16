<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>

		<!-- META DATA -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="Description" content="2Easy Insurance - Larvel Admin Dashboard Template">
        <meta name="Author" content="Spruko Technologies Private Limited">
        <meta name="keywords" content="admin dashboard, admin dashboard laravel, admin panel template, blade template, blade template laravel, bootstrap template, dashboard laravel, laravel admin, laravel admin dashboard, laravel admin panel, laravel admin template, laravel bootstrap admin template, laravel bootstrap template, laravel template">
       
        <!-- FAVICON -->
		<link rel="icon" href="{{asset('build/assets/img/brand/favicon.png')}}" type="image/x-icon">
   
		<!-- TITLE -->
		<title> 2Easy Insurance </title>

        <!-- BOOTSTRAP CSS -->
	    <link id="style" href="{{asset('build/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

        <!-- ICONS CSS -->
        <link href="{{asset('build/assets/iconfonts/icons.css')}}" rel="stylesheet">

        <!-- ANIMATE CSS -->
        <link href="{{asset('build/assets/iconfonts/animate.css')}}" rel="stylesheet">

        <!-- APP SCSS & APP CSS -->
        @vite(['resources/sass/app.scss' , 'resources/css/app.css'])
        
        @yield('styles')

	</head>

	<body class="login-img">

        @yield('custom-body')
        @yield('custom-body2')
        @yield('custom-body3')

            <!-- PAGE -->
                    @yield('content')
            <!-- END PAGE-->
        </div>

        <!-- SCRIPTS -->
        
        @include('layouts.components.custom-scripts')
        
        <!-- THEMECOLOR JS -->
        @vite('resources/assets/js/themecolor.js')


        <!-- APP JS -->
		@vite('resources/js/app.js')


        <!-- END SCRIPTS -->

	</body>
</html>
