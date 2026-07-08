@extends('layouts.header')
@section('title','Wallet')
@section('content')
<div class="dashboard">
    @include('layouts.sidebar')
    <section id="expenses" class="card fade-in">
        <div class="card">

            <div class="card-body">

                <h3>Wallet</h3>
                @if($wallet)
                <table class="table table-bordered">

                    <tr>
                        <th>User</th>
                        <td>{{ auth()->user()->name }}</td>
                    </tr>

                    <tr>
                        <th>Balance</th>
                        <td> @if($wallet && $wallet->balance)
                            ₹ {{ number_format($wallet->balance,2) }}
                            @else
                            ₹0.00
                            @endif</td>
                    </tr>

                    <tr>
                        <th>Version</th>
                        <td>{{ $wallet->version }}</td>
                    </tr>

                </table>
                @else
                <div class="alert alert-warning">
                    Wallet not found.
                </div>
                @endif

            </div>
        </div>
    </section>
</div>
@endsection