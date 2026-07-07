<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.header')
</head>
<body>
    @include('layouts.navbar')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                @include('layouts.sidebar')
            </div>
            <div class="col-md-10 mt-3">
                @yield('content')
            </div>
        </div>
    </div>
    @include('layouts.footer')
</body>
</html>