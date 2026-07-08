@extends('layouts.header')
@section('title','Dashboard')
@section('content')
<div class="dashboard">
    @include('layouts.sidebar')
    <section id="expenses" class="card fade-in">
        <div class="">

            <div class="card-body">

                <div class="row mb-4">

                    <div class="col-md-4">

                        <div class="card shadow border-0">

                            <div class="card-body">

                                <h6>Current Balance</h6>

                                <h2 class="text-success">

                                    ₹ {{ number_format($wallet->balance,2) }}

                                </h2>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="card shadow border-0">

                            <div class="card-body">

                                <h6>Total Sent</h6>

                                <h2 class="text-danger">

                                    ₹ {{ number_format($totalSent,2) }}

                                </h2>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="card shadow border-0">

                            <div class="card-body">

                                <h6>Total Received</h6>

                                <h2 class="text-primary">

                                    ₹ {{ number_format($totalReceived,2) }}

                                </h2>

                            </div>

                        </div>

                    </div>

                </div>
                <div class="card shadow-sm mb-4">

                    <div class="card-header bg-danger text-white">

                        Recent Sent Transactions

                    </div>

                    <div class="card-body">

                        <table class="table">

                            <thead>

                                <tr>

                                    <th>Receiver</th>

                                    <th>Reference</th>

                                    <th>Amount</th>

                                    <th>Status</th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($sentTransactions as $item)

                                <tr>

                                    <td>{{ $item->receiver_name }}</td>

                                    <td>{{ $item->reference_no }}</td>

                                    <td class="text-danger">

                                        - ₹ {{ number_format($item->amount,2) }}

                                    </td>

                                    <td>

                                        <span class="badge bg-success">

                                            {{ ucfirst($item->status) }}

                                        </span>

                                    </td>

                                </tr>

                                @empty

                                <tr>

                                    <td colspan="4" class="text-center">

                                        No Records

                                    </td>

                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>
                <div class="card shadow-sm">

                    <div class="card-header bg-success text-white">

                        Recent Received Transactions

                    </div>

                    <div class="card-body">

                        <table class="table">

                            <thead>

                                <tr>

                                    <th>Sender</th>

                                    <th>Reference</th>

                                    <th>Amount</th>

                                    <th>Status</th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($receivedTransactions as $item)

                                <tr>

                                    <td>{{ $item->sender_name }}</td>

                                    <td>{{ $item->reference_no }}</td>

                                    <td class="text-success">

                                        + ₹ {{ number_format($item->amount,2) }}

                                    </td>

                                    <td>

                                        <span class="badge bg-success">

                                            {{ ucfirst($item->status) }}

                                        </span>

                                    </td>

                                </tr>

                                @empty

                                <tr>

                                    <td colspan="4" class="text-center">

                                        No Records

                                    </td>

                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>
    </section>
</div>
@endsection