@extends('layouts.header')
@section('title','Wallet')
@section('content')
<div class="dashboard">
    @include('layouts.sidebar')
    <section id="expenses" class="card fade-in">
        <div class="">

            <div class="card-body">

                <div class="card shadow-sm mb-4">

                    <div class="card-header bg-primary text-white">

                        <h4 class="mb-0">
                            Transaction Details
                        </h4>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6">

                                <div class="border rounded p-3 bg-light">

                                    <h5 class="text-success">

                                        <i class="fa fa-arrow-up"></i>

                                        Sender

                                    </h5>

                                    <hr>

                                    <h4>{{ $transaction->sender_name }}</h4>

                                    <p>{{ $transaction->sender_email }}</p>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="border rounded p-3 bg-light">

                                    <h5 class="text-primary">

                                        <i class="fa fa-arrow-down"></i>

                                        Receiver

                                    </h5>

                                    <hr>

                                    <h4>{{ $transaction->receiver_name }}</h4>

                                    <p>{{ $transaction->receiver_email }}</p>

                                </div>

                            </div>

                        </div>

                        <hr>

                        <table class="table">

                            <tr>

                                <th width="220">Reference Number</th>

                                <td>{{ $transaction->reference_no }}</td>

                            </tr>

                            <tr>

                                <th>Transfer Amount</th>

                                <td>

                                    <span class="badge bg-success fs-6">

                                        ₹ {{ number_format($transaction->amount,2) }}

                                    </span>

                                </td>

                            </tr>

                            <tr>

                                <th>Status</th>

                                <td>

                                    @if($transaction->status=='completed')

                                    <span class="badge bg-success">

                                        Completed

                                    </span>

                                    @elseif($transaction->status=='pending')

                                    <span class="badge bg-warning">

                                        Pending

                                    </span>

                                    @else

                                    <span class="badge bg-danger">

                                        Failed

                                    </span>

                                    @endif

                                </td>

                            </tr>

                            <tr>

                                <th>Date</th>

                                <td>

                                    {{ date('d M Y h:i A',strtotime($transaction->created_at)) }}

                                </td>

                            </tr>

                        </table>

                    </div>

                </div>
                <div class="card shadow-sm mb-4">

                    <div class="card-header">

                        <h5>

                            Ledger Entries

                        </h5>

                    </div>

                    <div class="card-body">

                        <table class="table table-hover">

                            <thead>

                                <tr>

                                    <th>User</th>

                                    <th>Type</th>

                                    <th>Amount</th>

                                    <th>Date</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($ledger as $item)

                                <tr>

                                    <td>

                                        {{ $item->name }}

                                    </td>

                                    <td>

                                        @if($item->type=="credit")

                                        <span class="badge bg-success">

                                            Credit

                                        </span>

                                        @else

                                        <span class="badge bg-danger">

                                            Debit

                                        </span>

                                        @endif

                                    </td>

                                    <td>

                                        ₹ {{ number_format($item->amount,2) }}

                                    </td>

                                    <td>

                                        {{ date('d M Y h:i A',strtotime($item->created_at)) }}

                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>
                <div class="card shadow-sm">

                    <div class="card-header">

                        <h5>

                            Transaction Timeline

                        </h5>

                    </div>

                    <div class="card-body">

                        <table class="table table-striped">

                            <thead>

                                <tr>

                                    <th>Old Status</th>

                                    <th>New Status</th>

                                    <th>Updated At</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($logs as $log)

                                <tr>

                                    <td>

                                        <span class="badge bg-secondary">

                                            {{ ucfirst($log->old_status) }}

                                        </span>

                                    </td>

                                    <td>

                                        <span class="badge bg-success">

                                            {{ ucfirst($log->new_status) }}

                                        </span>

                                    </td>

                                    <td>

                                        {{ date('d M Y h:i A',strtotime($log->created_at)) }}

                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection