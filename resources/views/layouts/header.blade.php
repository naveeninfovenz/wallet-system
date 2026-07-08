<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallet system</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('js/dashboard.js')}}"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>
    @if(Route::current()->getName() == "index")
    <link rel="stylesheet" href="{{asset('css/auth.css')}}">
    <script src="{{asset('js/auth.js')}}"></script>
    @endif
 
</head>
<body>
    @yield('content')
   @if(session('status-error'))
    <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
        {{ session('status-error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('status-success'))
    <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
        {{ session('status-success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<script>
    setTimeout(function () {
    $('.custom-alert').fadeOut('slow');
}, 3000);
</script>
@include('layouts.footer')