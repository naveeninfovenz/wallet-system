@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h3 class="mb-4">Wallet Dashboard</h3>

    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5>Total Users</h5>
                    <h2>{{ $totalUsers }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h5>Total Wallets</h5>
                    <h2>{{ $totalWallets }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-dark text-white">
                <div class="card-body text-center">
                    <h5>Total Transactions</h5>
                    <h2>{{ $totalTransactions }}</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="card">

        <div class="card-header bg-primary text-white">

            Wallet Transfer

        </div>

        <div class="card-body">

            <form id="transferForm">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label>Sender</label>

                        <select class="form-control" id="sender_id">

                            <option value="">Select Sender</option>

                            @foreach($users as $user)

                                <option value="{{ $user->id }}">

                                    {{ $user->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Receiver</label>

                        <select class="form-control" id="receiver_id">

                            <option value="">Select Receiver</option>

                            @foreach($users as $user)

                                <option value="{{ $user->id }}">

                                    {{ $user->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Amount</label>

                        <input
                            type="number"
                            id="amount"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Reference No</label>

                        <input
                            type="text"
                            id="reference_no"
                            class="form-control"
                            value="REQ{{ rand(100000,999999) }}">

                    </div>

                </div>

                <button
                    type="button"
                    id="transferBtn"
                    class="btn btn-success">

                    Transfer Money

                </button>

            </form>

        </div>

    </div>

    <br>

    <div class="card">

        <div class="card-header bg-dark text-white">

            Recent Transactions

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                <tr>

                    <th>Reference</th>
                    <th>Sender</th>
                    <th>Receiver</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>

                </tr>

                </thead>

                <tbody>

                @foreach($transactions as $row)

                    <tr>

                        <td>{{ $row->reference_no }}</td>

                        <td>{{ $row->sender_name }}</td>

                        <td>{{ $row->receiver_name }}</td>

                        <td>₹ {{ number_format($row->amount,2) }}</td>

                        <td>

                            @if($row->status=='completed')
                                <span class="badge bg-success">Completed</span>
                            @elseif($row->status=='pending')
                                <span class="badge bg-warning">Pending</span>
                            @else
                                <span class="badge bg-danger">Failed</span>
                            @endif

                        </td>

                        <td>{{ date('d-m-Y H:i',strtotime($row->created_at)) }}</td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>
@push('scripts')

<script>

$("#transferBtn").click(function(){

    $.ajax({

        url:"{{ url('/api/wallet/transfer') }}",

        type:"POST",

        data:{

            sender_id:$("#sender_id").val(),

            receiver_id:$("#receiver_id").val(),

            amount:$("#amount").val(),

            reference_no:$("#reference_no").val(),

            _token:$('meta[name="csrf-token"]').attr('content')

        },

        success:function(response){

            alert(response.message);

            location.reload();

        },

        error:function(xhr){

            if(xhr.responseJSON && xhr.responseJSON.message){

                alert(xhr.responseJSON.message);

            }else{

                alert("Transfer Failed");

            }

        }

    });

});

</script>

@endpush
@endsection