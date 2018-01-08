<div class="sidebar ">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('agent.dashboard') }}"><i class="icon-speedometer"></i> Dashboard</a>
            </li>

            <li class="nav-title">
                Customers Accounts
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> Accounts</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('new.customer') }}"><i class="icon-plus"></i> New Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.list') }}"><i class="icon-list"></i> Accounts List</a>
                    </li>
                </ul>
            </li>

            <li class="nav-title">
                Loans
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('loans.index') }}"><i class="icon-plus"></i> New Loan</a>
            </li>
            <li class="divider"></li>
            <li class="nav-title">
                Account Details
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('agent.profile') }}" target="_top"><i class="icon-star"></i> Agent Profile</a>

            </li>


        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>