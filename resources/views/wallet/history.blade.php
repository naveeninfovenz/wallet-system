@extends('layouts.header')
@section('title','Wallet')
@section('content')
<div class="dashboard">
    @include('layouts.sidebar')
    <section id="expenses" class="card fade-in">
        <div class="">

            <div class="card-body">

              <div class="row mb-4">

    <div class="col-md-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <small class="text-muted">Total Transactions</small>

                <h3>{{ $transactions->total() }}</h3>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <small class="text-muted text-danger">

                    Money Sent

                </small>

                <h3 class="text-danger">

                    ₹ {{ number_format($totalSent,2) }}

                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <small class="text-muted text-success">

                    Money Received

                </small>

                <h3 class="text-success">

                    ₹ {{ number_format($totalReceived,2) }}

                </h3>

            </div>

        </div>

    </div>

</div><table class="table table-hover align-middle">

    <thead class="table-light">

        <tr>

            <th>#</th>

            <th>Type</th>

            <th>From / To</th>

            <th>Reference</th>

            <th>Amount</th>

            <th>Status</th>

            <th>Date</th>

            <th></th>

        </tr>

    </thead>

    <tbody>

    @foreach($transactions as $row)

    @php

        $isSent = $row->from_wallet_id == $wallet->id;

    @endphp

    <tr>

        <td>{{ $loop->iteration }}</td>

        <td>

            @if($isSent)

                <span class="badge bg-danger">

                    <i class="fa fa-arrow-up"></i>

                    Sent

                </span>

            @else

                <span class="badge bg-success">

                    <i class="fa fa-arrow-down"></i>

                    Received

                </span>

            @endif

        </td>

        <td>

            @if($isSent)

                <strong>{{ $row->receiver_name }}</strong>

            @else

                <strong>{{ $row->sender_name }}</strong>

            @endif

        </td>

        <td>

            {{ $row->reference_no }}

        </td>

        <td>

            @if($isSent)

                <span class="text-danger">

                    - ₹ {{ number_format($row->amount,2) }}

                </span>

            @else

                <span class="text-success">

                    + ₹ {{ number_format($row->amount,2) }}

                </span>

            @endif

        </td>

        <td>

            @if($row->status=="completed")

                <span class="badge bg-success">

                    Completed

                </span>

            @elseif($row->status=="pending")

                <span class="badge bg-warning">

                    Pending

                </span>

            @else

                <span class="badge bg-danger">

                    Failed

                </span>

            @endif

        </td>

        <td>

            {{ date('d M Y',strtotime($row->created_at)) }}

            <br>

            <small class="text-muted">

                {{ date('h:i A',strtotime($row->created_at)) }}

            </small>

        </td>

        <td>

            <a href="{{ url('/wallet/history/'.$row->id) }}"
               class="btn btn-outline-primary btn-sm">

                <i class="fa fa-eye"></i>

                Details

            </a>

        </td>

    </tr>

    @endforeach

    </tbody>

</table>
<div class="mt-3 d-flex justify-content-end">

    {{ $transactions->links() }}

</div>
            </div>
        </div>
    </section>
</div>
@endsection