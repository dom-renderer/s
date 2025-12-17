<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="image/x-icon" href="{{ Helper::favicon() }}">

	<title> {{ Helper::title() }} - {{ isset($title) ? $title : 'Home' }} </title>

	<link rel="stylesheet" href="{{ asset('ui/css/boostrap-min.css') }}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
	<link rel="stylesheet" href="{{ asset('ui/css/style.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.6/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="{{ asset('ui/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('ui/css/responsive.css') }}">

	@if(isset($datatable))
	<link rel="stylesheet" href="{{ asset('assets/css/datatable.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
	@endif

	@if(isset($select2))
	<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
	@endif

	@if(isset($datepicker))
	<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">
	@endif

	@if(isset($editor))
	<link rel="stylesheet" href="{{ asset('assets/css/ckeditor.min.css') }}">
	@endif

	<link rel="stylesheet" href="{{ asset('assets/css/swal.min.css') }}">
	@stack('css')
</head>

<body>
	@include('layouts.header')

	<section class="main hero">
		<div class="container main-container">
			@yield('content')
		</div>
	</section>
</body>

<script src="{{ asset('ui/js/Jquery-min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-validate.min.js') }}"></script>

@if(isset($datatable))
<script src="{{ asset('assets/js/datatable.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
@endif

@if(isset($select2))
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
@endif

@if(isset($datepicker))
<script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
@endif

@if(isset($editor))
<script src="{{ asset('assets/js/ckeditor.min.js') }}"></script>
@endif

<script src="{{ asset('assets/js/swal.min.js') }}"></script>
@include('layouts.script')
@stack('js')

</html>