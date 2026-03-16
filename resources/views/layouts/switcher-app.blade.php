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

	<body class="ltr main-body app sidebar-mini">

		<!--- GLOBAL LOADER -->
		<div id="global-loader" >
			<img src="{{asset('build/assets/img/svgicons/loader.svg')}}" class="loader-img" alt="loader">
		</div>
		<!--- END GLOBAL LOADER -->

        <!-- PAGE -->
		<div class="page">
            <div>
                <!-- MAIN-HEADER -->
                @include('layouts.components.main-header')
                <!-- END MAIN-HEADER -->

                <!-- MAIN-SIDEBAR -->
                @include('layouts.components.main-sidebar')
                <!-- END MAIN-SIDEBAR -->

            </div>

            <!-- MAIN-CONTENT -->
            <div class="main-content app-content">
                <div class="main-container container-fluid">
                        @yield('content')
                </div>
            </div>
            <!-- END MAIN-CONTENT -->

            <!-- RIGHT-SIDEBAR -->
            @include('layouts.components.right-sidebar')
           <!-- END RIGHT-SIDEBAR -->

           <!-- MESSAGE-MODAL -->
           @include('layouts.components.message-modal')
            <!-- END MESSAGE-MODAL -->

            <!-- VIDEO-MODAL -->
            @include('layouts.components.video-modal')
            <!-- END VIDEO-MODAL -->

            <!-- AUDIO-MODAL -->
            @include('layouts.components.audio-modal')
            <!-- END AUDIO-MODAL -->
            @yield('modals')

            <!-- MAIN-FOOTER -->
            @include('layouts.components.main-footer')
            <!-- END MAIN-FOOTER -->

		</div>
        <!-- END PAGE-->

        <!-- SCRIPTS -->

        @include('layouts.components.scripts')

        <!-- STICKY JS -->
		<script src="{{asset('build/assets/sticky.js')}}"></script>

        <!-- THEME COLOR JS -->
        @vite('resources/assets/js/themecolor.js')


        <!-- APP JS -->
		@vite('resources/js/app.js')


        <!-- SWITCHER JS -->
        @vite('resources/assets/switcher/js/switcher.js')


        <!-- END SCRIPTS -->

	</body>
</html>
