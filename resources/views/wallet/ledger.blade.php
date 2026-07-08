@extends('layouts.header')
@section('title','Wallet')
@section('content')
<div class="dashboard">
    @include('layouts.sidebar')
    <section id="expenses" class="card fade-in">
        <div class="card">

            <div class="card-body">

                <h3>Ledger Entries</h3>

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>ID</th>
                            <th>Wallet</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Date</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($ledger as $item)

                        <tr>

                            <td>{{ $item->id }}</td>

                            <td>{{ $item->wallet_id }}</td>

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

                                ₹ {{ $item->amount }}

                            </td>

                            <td>

                                {{ $item->created_at }}

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

                {{ $ledger->links() }}
            </div>
        </div>
    </section>
</div>
@endsection