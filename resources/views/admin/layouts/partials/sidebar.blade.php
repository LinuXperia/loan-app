<div class="sidebar admin__sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="icon-speedometer"></i> Dashboard</a>
            </li>

            <li class="nav-title">
                Customers Service
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-emotsmile"></i> Account Details @if($unapprovedAccounts > 0)<span class="badge badge-primary">NEW</span> @endif</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('unapproved.customers') }}"><i class="icon-dislike"></i>New Accounts <span class="badge badge-primary">{{ $unapprovedAccounts }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('approved.customers') }}"><i class="icon-like"></i> Approved Accounts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('declined.customers') }}"><i class="icon-ban"></i> Declined Accounts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dormant.customers') }}"><i class="icon-minus"></i> Dormant Accounts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blacklisted.customers') }}"><i class="icon-close"></i> BlackList Accounts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.list') }}"><i class="icon-list"></i> All Accounts</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-grid"></i> Loan Details @if($unapprovedLoans > 0)<span class="badge badge-success">NEW</span> @endif</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('unapproved.loans') }}"><i class="icon-dislike"></i> New Loans <span class="badge badge-success">{{ $unapprovedLoans }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('approved.loans') }}"><i class="icon-like"></i> Approved Loans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('declined.loans') }}"><i class="icon-ban"></i> Declined Loans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('all.loans') }}"><i class="icon-list"></i> All Loans</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-paypal"></i> Payment Details @if($unapprovedPayments > 0)<span class="badge badge-warning">NEW</span> @endif</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('unapproved.payments') }}"><i class="icon-credit-card"></i> New Payments <span class="badge badge-warning">{{ $unapprovedPayments }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('approved.payments') }}"><i class="icon-eye"></i> Approved Payments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('declined.payments') }}"><i class="icon-ban"></i> Declined Payments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('all.payments') }}"><i class="icon-list"></i> All Payments</a>
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
                <a class="nav-link" href="{{ route('admin.profile') }}" target="_top"><i class="icon-settings"></i>Admin Profile</a>
            </li>


        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>