<div class="sidebar admin__sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="icon-speedometer"></i> Dashboard</a>
            </li>

            <li class="nav-title">
                Customers Service
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-emotsmile"></i> Borrower</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('unapproved.borrowers') }}"><i class="icon-dislike"></i> Unapproved</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-like"></i> Approved Borrowers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-ban"></i> Declined Borrowers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-close"></i> BlackList Borrowers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-list"></i> All Borrowers</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-grid"></i> Loan Details</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-dislike"></i> Unapproved Loans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-like"></i> Approved Loans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-ban"></i> Declined Loans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-list"></i> All Loans</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-paypal"></i> Payment Details</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-credit-card"></i> Unapproved</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-eye"></i> Approved Payments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-ban"></i> Declined Payments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-list"></i> All Payments</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-people"></i> Agents Details</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('new.agent') }}"><i class="icon-plus"></i> New Agent</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('active.agents') }}"><i class="icon-user-following"></i> Active Agents</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('inactive.agents')}}"><i class="icon-user-unfollow"></i> Inactive Agents</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('all.agents') }}"><i class="icon-list"></i> All Agents</a>
                    </li>
                </ul>
            </li>

            <li class="divider"></li>
            <li class="nav-title">
                Account Details
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" target="_top"><i class="icon-settings"></i>Admin Profile</a>
            </li>


        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>