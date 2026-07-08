<div class="wallet-sidebar">

    <!-- Logo -->
    <div class="wallet-sidebar-header">

        <div class="wallet-logo">

            <i class="fa-solid fa-wallet"></i>

        </div>

        <h3>Wallet System</h3>

        <p>

            Welcome,

            <strong>{{ auth()->user()->name }}</strong>

        </p>

    </div>

    <!-- Menu -->

    <ul class="wallet-sidebar-menu">

        <li>

            <a href="{{ url('/dashboard') }}"
                class="{{ request()->is('dashboard') ? 'active' : '' }}">

                <i class="fa-solid fa-house"></i>

                Dashboard

            </a>

        </li>

        <li>

            <a href="{{ url('/wallet') }}"
                class="{{ request()->is('wallet') ? 'active' : '' }}">

                <i class="fa-solid fa-wallet"></i>

                My Wallet

            </a>

        </li>

        <li>

            <a href="{{ url('/wallet/transfer') }}"
                class="{{ request()->is('wallet/transfer') ? 'active' : '' }}">

                <i class="fa-solid fa-paper-plane"></i>

                Transfer Money

            </a>

        </li>

        <li>

            <a href="{{ url('/wallet/history') }}"
                class="{{ request()->is('wallet/history') || request()->is('wallet/history/*') ? 'active' : '' }}">

                <i class="fa-solid fa-clock-rotate-left"></i>

                Transactions

            </a>

        </li>

        <li>

            <a href="{{ url('/wallet/ledger') }}"
                class="{{ request()->is('wallet/ledger') ? 'active' : '' }}">

                <i class="fa-solid fa-book"></i>

                Ledger

            </a>

        </li>

    </ul>

    <!-- Logout -->

    <div class="wallet-sidebar-footer">

        <a href="{{ route('logout') }}">

            <i class="fa-solid fa-right-from-bracket"></i>

            Logout

        </a>

    </div>

</div>