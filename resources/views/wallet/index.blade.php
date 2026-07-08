@extends('layouts.header')

@section('title','My Wallet')

@section('content')

<div class="dashboard">

    @include('layouts.sidebar')

    <div class="wallet-content">

        @if($wallet)

        <div class="row">

            <!-- Wallet Balance -->
            <div class="col-lg-8">

                <div class="card border-0 shadow-lg wallet-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <span class="wallet-title">
                                    Available Balance
                                </span>

                                <h1 class="wallet-balance">

                                    ₹ {{ number_format($wallet->balance,2) }}

                                </h1>

                                <span class="wallet-version">

                                    Wallet Version :
                                    {{ $wallet->version }}

                                </span>

                            </div>

                            <div>

                                <div class="wallet-icon">

                                    <i class="fa-solid fa-wallet"></i>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- User -->
            <div class="col-lg-4">

                <div class="card border-0 shadow-lg h-100">

                    <div class="card-body text-center">

                        <img
                            src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=0D6EFD&color=fff"
                            class="rounded-circle mb-3"
                            width="90">

                        <h4>

                            {{ auth()->user()->name }}

                        </h4>

                        <p class="text-muted">

                            {{ auth()->user()->email }}

                        </p>

                    </div>

                </div>

            </div>

        </div>

        <div class="row mt-4">

            <div class="col-md-4">

                <div class="card border-0 shadow-sm stats-card">

                    <div class="card-body">

                        <h6 class="text-muted">

                            Current Balance

                        </h6>

                        <h3 class="text-success">

                            ₹ {{ number_format($wallet->balance,2) }}

                        </h3>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card border-0 shadow-sm stats-card">

                    <div class="card-body">

                        <h6 class="text-muted">

                            Wallet Version

                        </h6>

                        <h3>

                            {{ $wallet->version }}

                        </h3>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card border-0 shadow-sm stats-card">

                    <div class="card-body">

                        <h6 class="text-muted">

                            Account Status

                        </h6>

                        <span class="badge bg-success fs-6">

                            Active

                        </span>

                    </div>

                </div>

            </div>

        </div>

        <div class="row mt-4">

            <div class="col-lg-12">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">

                            Quick Actions

                        </h5>

                    </div>

                    <div class="card-body">

                        <a href="{{ url('/wallet/transfer') }}"
                            class="btn btn-primary me-2">

                            <i class="fa-solid fa-paper-plane"></i>

                            Transfer Money

                        </a>

                        <a href="{{ url('/wallet/history') }}"
                            class="btn btn-success me-2">

                            <i class="fa-solid fa-clock-rotate-left"></i>

                            View Transactions

                        </a>

                        <a href="{{ url('/wallet/ledger') }}"
                            class="btn btn-dark">

                            <i class="fa-solid fa-book"></i>

                            Ledger

                        </a>

                    </div>

                </div>

            </div>

        </div>

        @else

        <div class="alert alert-warning">

            Wallet not found.

        </div>

        @endif

    </div>

</div>

@endsection