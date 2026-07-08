

                @extends('layouts.header')
                @section('title','Wallet')
                @section('content')
                <div class="dashboard">
                    @include('layouts.sidebar')
                    <section id="expenses" class="card fade-in">
                        <div class="card">

                            <div class="card-body">

                                <h3>Transaction Details</h3>

                                <table class="table table-bordered">

                                    <tr>
                                        <th>Reference</th>
                                        <td>{{ $transaction->reference_no }}</td>
                                    </tr>

                                    <tr>
                                        <th>Amount</th>
                                        <td>₹ {{ $transaction->amount }}</td>
                                    </tr>

                                    <tr>
                                        <th>Status</th>
                                        <td>{{ $transaction->status }}</td>
                                    </tr>

                                </table>

                                <h4>Ledger Entries</h4>

                                <table class="table table-bordered">

                                    <tr>

                                        <th>Wallet</th>
                                        <th>Type</th>
                                        <th>Amount</th>

                                    </tr>

                                    @foreach($ledger as $item)

                                    <tr>

                                        <td>{{ $item->wallet_id }}</td>

                                        <td>{{ ucfirst($item->type) }}</td>

                                        <td>{{ $item->amount }}</td>

                                    </tr>

                                    @endforeach

                                </table>

                                <h4>Logs</h4>

                                <table class="table table-bordered">

                                    <tr>

                                        <th>Old</th>
                                        <th>New</th>
                                        <th>Date</th>

                                    </tr>

                                    @foreach($logs as $log)

                                    <tr>

                                        <td>{{ $log->old_status }}</td>

                                        <td>{{ $log->new_status }}</td>

                                        <td>{{ $log->created_at }}</td>

                                    </tr>

                                    @endforeach

                                </table>

                            </div>
                        </div>
                    </section>
                </div>
                @endsection