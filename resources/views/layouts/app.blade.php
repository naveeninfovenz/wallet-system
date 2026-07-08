<!DOCTYPE html>
<html>
<head>
    <title>Wallet System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand">Wallet System</a>

        <div class="text-white">

            {{ auth()->user()->name }}

            <a href="{{ url('/logout') }}" class="btn btn-danger btn-sm ms-3">
                Logout
            </a>

        </div>

    </div>
</nav>

<div class="container mt-4">

    <div class="row">

        <div class="col-md-3">

            <div class="list-group">

                <a href="/dashboard" class="list-group-item">
                    Dashboard
                </a>

                <a href="/wallet" class="list-group-item">
                    Wallet
                </a>

                <a href="/wallet/transfer" class="list-group-item">
                    Transfer
                </a>

                <a href="/wallet/history" class="list-group-item">
                    History
                </a>

                <a href="/wallet/ledger" class="list-group-item">
                    Ledger
                </a>

            </div>

        </div>

        <div class="col-md-9">

            @yield('content')

        </div>

    </div>

</div>

</body>
</html>