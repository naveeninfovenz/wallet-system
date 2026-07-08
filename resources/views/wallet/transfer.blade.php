@extends('layouts.header')
@section('title','Transfer Money')
@section('content')
<div class="dashboard">
    @include('layouts.sidebar')
    <section id="expenses" class="card fade-in">
        <div class="container-fluid p-4">
            <div class="row">
                {{-- Sender Wallet --}}
                <div class="col-lg-4">
                    <div class="card shadow border-0">

                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-wallet"></i>
                                My Wallet
                            </h5>
                        </div>

                        <div class="card-body">

                            <h4>{{ auth()->user()->name }}</h4>

                            <p class="text-muted mb-2">
                                {{ auth()->user()->email }}
                            </p>

                            <hr>

                            <h2 class="text-success">

                                ₹ {{ number_format($wallet->balance,2) }}

                            </h2>
                            <input type="hidden" id="sender_balance" value="{{$wallet->balance}}">
                            <small class="text-muted">

                                Wallet Version :
                                {{ $wallet->version }}

                            </small>

                        </div>

                    </div>

                </div>

                {{-- Transfer Form --}}
                <div class="col-lg-8">

                    <div class="card shadow border-0">

                        <div class="card-header bg-primary text-white">

                            <h4 class="mb-0">

                                Transfer Money

                            </h4>

                        </div>

                        <div class="card-body">

                            @if(session('success'))

                            <div class="alert alert-success">

                                {{ session('success') }}

                            </div>

                            @endif

                            @if(session('error'))

                            <div class="alert alert-danger">

                                {{ session('error') }}

                            </div>

                            @endif

                            <form
                                id="transferForm"
                                action="{{ url('/wallet/transfer') }}"
                                method="POST">

                                @csrf

                                {{-- Receiver --}}

                                <div class="mb-3">

                                    <label class="form-label">

                                        Receiver

                                    </label>

                                    <select
                                        class="form-select"
                                        id="receiver"
                                        name="receiver_id"
                                        required>

                                        <option value="">

                                            Select Receiver

                                        </option>

                                        @foreach($users as $user)

                                        <option

                                            value="{{ $user->id }}"

                                            data-name="{{ $user->name }}"

                                            data-email="{{ $user->email }}"

                                            data-balance="{{ $user->balance }}">

                                            {{ $user->name }}

                                            (₹ {{ number_format($user->balance,2) }})

                                        </option>

                                        @endforeach

                                    </select>
                                   <div class="text-danger" id="receiver_error"></div>
                                </div>

                                {{-- Amount --}}

                                <div class="mb-3">

                                    <label class="form-label">

                                        Amount

                                    </label>

                                    <input

                                        id="amount"

                                        type="number"

                                        step="0.01"

                                        min="1"

                                        name="amount"

                                        class="form-control"

                                        required>
                                    <div class="text-danger" id="amount_error"></div>
                                </div>

                                {{-- Reference --}}

                                <div class="mb-3">

                                    <label class="form-label">

                                        Reference No

                                    </label>

                                    <input

                                        type="text"

                                        name="reference_no"

                                        class="form-control"

                                        readonly

                                        value="{{ uniqid('REQ-') }}">

                                </div>

                                {{-- Summary --}}

                                <div class="card bg-light mb-4">

                                    <div class="card-header">

                                        Transfer Summary

                                    </div>

                                    <div class="card-body">

                                        <table class="table table-borderless">

                                            <tr>

                                                <th width="120">

                                                    From

                                                </th>

                                                <td>

                                                    {{ auth()->user()->name }}

                                                </td>

                                            </tr>

                                            <tr>

                                                <th>

                                                    To

                                                </th>

                                                <td id="receiverName">

                                                    -

                                                </td>

                                            </tr>

                                            <tr>

                                                <th>

                                                    Amount

                                                </th>

                                                <td>

                                                    ₹

                                                    <span id="summaryAmount">

                                                        0.00

                                                    </span>

                                                </td>

                                            </tr>

                                        </table>

                                        

                                    </div>

                                </div>

                                <button

                                    type="button"

                                    class="btn btn-success w-100"
                                    id="reviewTransfer"
                                    data-bs-toggle="modal"
                                    id="reviewTransfer"
                                   >

                                    Review & Confirm Transfer

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

{{-- Confirmation Modal --}}

<div class="modal fade" id="confirmModal">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header bg-primary text-white">

                <h5>

                    Confirm Wallet Transfer

                </h5>

            </div>

            <div class="modal-body">

                <table class="table">

                    <tr>

                        <th>Sender</th>

                        <td>

                            {{ auth()->user()->name }}

                        </td>

                    </tr>

                    <tr>

                        <th>Receiver</th>

                        <td id="modalReceiver">

                        </td>

                    </tr>

                    <tr>

                        <th>Amount</th>

                        <td>

                            ₹

                            <span id="modalAmount">

                            </span>

                        </td>

                    </tr>

                    <tr>

                        <th>Current Balance</th>

                        <td>

                            ₹ {{ number_format($wallet->balance,2) }}

                        </td>

                    </tr>

                </table>

                <div class="alert alert-danger">

                    <b>

                        Are you sure?

                    </b>

                    <br>

                    This transfer cannot be undone.

                </div>

            </div>

            <div class="modal-footer">

                <button

                    class="btn btn-secondary"

                    data-bs-dismiss="modal">

                    Cancel

                </button>

                <button

                    type="button"

                    class="btn btn-success"

                    onclick="submitTransfer()">

                    Confirm Transfer

                </button>

            </div>

        </div>

    </div>

</div>

<script>
    let modal=new bootstrap.Modal(document.getElementById('confirmModal'));
    $("#reviewTransfer").click(function(){
        $("#receiver_error").html('');
        $("#amount_error").html('');
        let receiver=$("#receiver").val();
        let amount=parseFloat($("#amount").val());
        let balance=parseFloat($("#sender_balance").val());
        let valid=true;
        if(receiver==""){
            $("#receiver_error").html("Please select receiver.");
            valid=false;
        }
        if(isNaN(amount)){
            $("#amount_error").html("Amount is required.");
            valid=false;
        }else if(amount<=0){
            $("#amount_error").html("Amount should be greater than zero.");
            valid=false;

        }else if(amount>balance){
            $("#amount_error").html("Insufficient Wallet Balance.");
            valid=false;
        }
        if(!valid){
            return false;
        }
        modal.show();
    });
document.addEventListener("DOMContentLoaded",function(){
    const receiver=document.getElementById("receiver");
    const amount=document.getElementById("amount");
    function updateSummary(){
        let option=receiver.options[receiver.selectedIndex];
        let name=option.dataset.name ?? "-";
        let amt=amount.value==""?0:parseFloat(amount.value).toFixed(2);
        document.getElementById("receiverName").innerHTML=name;
        document.getElementById("summaryAmount").innerHTML=amt;
        document.getElementById("modalReceiver").innerHTML=name;
        document.getElementById("modalAmount").innerHTML=amt;
    }
    receiver.addEventListener("change",updateSummary);
    amount.addEventListener("keyup",updateSummary);
    amount.addEventListener("change",updateSummary);
});

function submitTransfer(){
    document.getElementById("transferForm").submit();
}


</script>

@endsection