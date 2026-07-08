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

    @if(Route::current()->getName()=="dashboard")

    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script src="{{asset('js/dashboard.js')}}"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>
    @endif
    @if(Route::current()->getName() == "index")
    <link rel="stylesheet" href="{{asset('css/auth.css')}}">
    <script src="{{asset('js/auth.js')}}"></script>
    @endif
 
</head>
<body>
    @yield('content')
    @if(session()->has('status-error'))
        <div class="alert alert-success">
                <div class="full">
                    <div class="notifications alert-success cf"><span class="message-icon success"></span>
                        <p>{{ session()->pull('status-error') }}</p><span class="close">X</span>
                    </div>
                </div>
            </div>
            @endif
        @if(session()->has('status-success'))
            <div class="alert alert-success login-success">
            <div class="full" ><div class="notifications alert-success cf"><span class="message-icon success"></span><p>  {{ session()->get('status-success') }}</p><span class="close">X</span></div></div>
            </div>
        @endif
        <div class="confirmation-popup-container d-none">
            <div class="awsm-dialog animated bounceIn">
                <div class="awd-content">
                    <p class="awd-message">Are you sure you want to delete this wallet?</p>
                    <a href="/delete/wallet/" class="confirmation-btn awd-ok">Yes</a>
                    <button class="confirmation-btn awd-cancel">No</button>
                </div>
            </div>
        </div>

@include('layouts.footer')