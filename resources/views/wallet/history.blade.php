@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow">

        <div class="card-header bg-primary text-white d-flex justify-content-between">

            <h4 class="mb-0">
                Wallet Transaction History
            </h4>

            <input
                type="text"
                id="search"
                class="form-control w-25"
                placeholder="Search...">

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">

                    <tr>

                        <th>#</th>
                        <th>Reference No</th>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>

                    </tr>

                    </thead>

                    <tbody>

                    @forelse($transactions as $key=>$transaction)

                        <tr>

                            <td>{{ $transactions->firstItem()+$key }}</td>

                            <td>

                                <span class="badge bg-secondary">

                                    {{ $transaction->reference_no }}

                                </span>

                            </td>

                            <td>

                                {{ $transaction->sender_name }}

                            </td>

                            <td>

                                {{ $transaction->receiver_name }}

                            </td>

                            <td>

                                ₹ {{ number_format($transaction->amount,2) }}

                            </td>

                            <td>

                                @if($transaction->status=="completed")

                                    <span class="badge bg-success">

                                        Completed

                                    </span>

                                @elseif($transaction->status=="pending")

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

                                {{ date('d-m-Y h:i A',strtotime($transaction->created_at)) }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center">

                                No Transactions Found

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $transactions->links() }}

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

document.getElementById('search').addEventListener('keyup', function(){

    let value=this.value.toLowerCase();

    document.querySelectorAll("tbody tr").forEach(function(row){

        row.style.display=row.innerText.toLowerCase().includes(value)
            ? ""
            : "none";

    });

});

</script>

@endpush