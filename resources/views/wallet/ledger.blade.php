@extends('layouts.header')
@section('title','Wallet')
@section('content')
<div class="dashboard">
    @include('layouts.sidebar')
    <section id="expenses" class="card fade-in">
        <div class="card">

            <div class="card-body">

                <div class="row mb-4">

                    <div class="col-md-4">

                        <div class="card border-0 shadow-sm">

                            <div class="card-body">

                                <small class="text-muted">

                                    Current Balance

                                </small>

                                <h2 class="text-primary">

                                    ₹ {{ number_format($wallet->balance,2) }}

                                </h2>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="card border-0 shadow-sm">

                            <div class="card-body">

                                <small class="text-success">

                                    Total Credit

                                </small>

                                <h2 class="text-success">

                                    + ₹ {{ number_format($totalCredit,2) }}

                                </h2>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="card border-0 shadow-sm">

                            <div class="card-body">

                                <small class="text-danger">

                                    Total Debit

                                </small>

                                <h2 class="text-danger">

                                    - ₹ {{ number_format($totalDebit,2) }}

                                </h2>

                            </div>

                        </div>

                    </div>

                </div>
                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white">

                        <h5 class="mb-0">

                            Ledger Entries

                        </h5>

                    </div>

                    <div class="card-body">

                        <table class="table table-hover align-middle">

                            <thead class="table-light">

                                <tr>

                                    <th>#</th>

                                    <th>Reference</th>

                                    <th>Entry Type</th>

                                    <th>Amount</th>

                                    <th>Date</th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($ledger as $item)

                                <tr>

                                    <td>

                                        {{ $loop->iteration }}

                                    </td>

                                    <td>

                                        {{ $item->reference_no }}

                                    </td>

                                    <td>

                                        @if($item->type=="credit")

                                        <span class="badge bg-success">

                                            <i class="fa fa-arrow-down"></i>

                                            Credit

                                        </span>

                                        @else

                                        <span class="badge bg-danger">

                                            <i class="fa fa-arrow-up"></i>

                                            Debit

                                        </span>

                                        @endif

                                    </td>

                                    <td>

                                        @if($item->type=="credit")

                                        <span class="text-success">

                                            + ₹ {{ number_format($item->amount,2) }}

                                        </span>

                                        @else

                                        <span class="text-danger">

                                            - ₹ {{ number_format($item->amount,2) }}

                                        </span>

                                        @endif

                                    </td>

                                    <td>

                                        {{ date('d M Y',strtotime($item->created_at)) }}

                                        <br>

                                        <small class="text-muted">

                                            {{ date('h:i A',strtotime($item->created_at)) }}

                                        </small>

                                    </td>

                                </tr>

                                @empty

                                <tr>

                                    <td colspan="5" class="text-center">

                                        No Ledger Entries Found

                                    </td>

                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">

                    <div>

                        Showing

                        {{ $ledger->firstItem() }}

                        -

                        {{ $ledger->lastItem() }}

                        of

                        {{ $ledger->total() }}

                        entries

                    </div>

                    <div>

                        {{ $ledger->links('pagination::bootstrap-5') }}

                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection