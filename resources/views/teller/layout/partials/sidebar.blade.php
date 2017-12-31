<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="icon-speedometer"></i> Dashboard</a>
            </li>

            <li class="nav-title">
                Customers Service
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> Borrower</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('new.borrower') }}"><i class="icon-plus"></i> New Borrower</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('borrower.list') }}"><i class="icon-list"></i> List Borrowers</a>
                    </li>
                </ul>
            </li>

            <li class="nav-title">
                Loans
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('loans.index') }}"><i class="icon-plus"></i> New Loan</a>
            </li>

            <li class="nav-title">
                Loan Payment
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="icon-plus"></i> New Payment</a>
            </li>

            <li class="divider"></li>
            <li class="nav-title">
                Account Details
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('teller.profile') }}" target="_top"><i class="icon-star"></i> Profile</a>

            </li>


        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>