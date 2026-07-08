@extends('layouts.header')
@section('title','Wallet')
@section('content')
<div class="dashboard">
    @include('layouts.sidebar')
    <section id="expenses" class="card fade-in">
        <div class="card">

            <div class="card-body">

                <h3>Transfer Money</h3>

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

                <form action="/wallet/transfer" method="POST">

                    @csrf

                    <div class="mb-3">

                        <label>Receiver</label>

                        <select name="receiver_id" class="form-control">

                            <option value="">Select User</option>

                            @foreach($users as $user)

                            <option value="{{ $user->id }}">

                                {{ $user->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-3">

                        <label>Amount</label>

                        <input
                            type="number"
                            step="0.01"
                            name="amount"
                            class="form-control">

                    </div>

                    <div class="mb-3">

                        <label>Reference No</label>

                        <input
                            type="text"
                            name="reference_no"
                            class="form-control"
                            value="{{ uniqid('REQ-') }}">

                    </div>

                    <button class="btn btn-success">

                        Transfer

                    </button>

                </form>
            </div>
    </section>
</div>
@endsection