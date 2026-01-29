     <!-- Sidebar Start -->
     <div class="sidebar pe-4 pb-3">
        <nav class="navbar bg-light navbar-light">
            <a href="#" class="navbar-brand mx-4 mb-3">
                <h3 class="text-primary">Payment <br> GateWay</h3>
            </a>

            <div class="navbar-nav w-100">
                @if (Auth::check() && Auth::user()->type != 'Merchant')
                <a href="{{ route('admin.dashboard') }}" class="nav-item nav-link {{ (request()->is('admin/admin-dashboard')) ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                @endif
                <a href="{{ route('admin.transactions.index') }}" class="nav-item nav-link {{ (request()->is('admin/Transactions')) ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Transactions</a>
                @if (Auth::check() && Auth::user()->type != 'Merchant')
                <a href="{{ route('admin.merchants.index') }}" class="nav-item nav-link {{ (request()->is('admin/merchants*')) ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Merchants</a>
                @if (Auth::check() && Auth::user()->type == 'Admin')
                <a href="{{ route('admin.settings.index') }}" class="nav-item nav-link {{ (request()->is('admin/settings')) ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Settings</a>
                <a class="nav-item nav-link {{ (request()->is('admin/users')) ? 'active' : '' }}" href="{{ route('users.index') }}"><i class="fa fa-tachometer-alt me-2"></i>Manage Users</a>
                <a class="nav-item nav-link {{ (request()->is('admin/roles')) ? 'active' : '' }}" href="{{ route('roles.index') }}"><i class="fa fa-tachometer-alt me-2"></i>Manage Role</a>
                @endif
                @endif

            </div>
        </nav>
    </div>
    <!-- Sidebar End -->
