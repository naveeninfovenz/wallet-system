@extends('layouts.header')
@section('title','Dashboard')
@section('content')
<div class="dashboard">
    @include('layouts.sidebar')
        <section id="expenses" class="card fade-in">
        <div class="card">

    <div class="card-body">

        <h5>Current Wallet Balance</h5>

        <h2 class="text-success">
           @if($wallet && $wallet->balance)
            $ {{ number_format($wallet->balance,2) }}
            @else
            $0.00
            @endif

        </h2>

        <hr>

        <a href="/wallet/transfer" class="btn btn-primary">
            Transfer Money
        </a>

    </div>

</div>
        </section>
    </div>
@endsection