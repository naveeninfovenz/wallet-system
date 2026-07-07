@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <h4 class="mb-0">
                Wallet Balance
            </h4>

        </div>

        <div class="card-body">

            <div class="row mb-3">

                <div class="col-md-4">

                    <input type="text"
                           class="form-control"
                           id="search"
                           placeholder="Search User">

                </div>

            </div>

            <table class="table table-bordered table-striped table-hover">

                <thead class="table-dark">

                <tr>

                    <th>#</th>

                    <th>User</th>

                    <th>Wallet ID</th>

                    <th>Balance</th>

                    <th>Version</th>

                    <th>Status</th>

                </tr>

                </thead>

                <tbody>

                @forelse($wallets as $key => $wallet)

                    <tr>

                        <td>{{ $key + 1 }}</td>

                        <td>{{ $wallet->name }}</td>

                        <td>{{ $wallet->id }}</td>

                        <td>

                            ₹ {{ number_format($wallet->balance,2) }}

                        </td>

                        <td>

                            {{ $wallet->version }}

                        </td>

                        <td>

                            @if($wallet->balance > 0)

                                <span class="badge bg-success">

                                    Active

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    Empty

                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center">

                            No Wallet Found

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

$('#search').on('keyup', function () {

    var value = $(this).val().toLowerCase();

    $("table tbody tr").filter(function () {

        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);

    });

});

</script>

@endpush