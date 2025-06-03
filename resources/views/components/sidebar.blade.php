
@php
    $noOperator = Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin'
    
@endphp

<aside class="sidebar">
    <button type="button" class="sidebar-close-btn !mt-4">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="{{ url('/') }}" class="sidebar-logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="site logo" class="light-logo">
            <img src="{{ asset('assets/images/logo-light.png') }}" alt="site logo" class="dark-logo">
            <img src="{{ asset('assets/images/logo-icon.png') }}" alt="site logo" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li>
                <a href="{{ url('/') }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
            </li>

            @if (Auth::user()->role == 'admin' && 'super_admin')
                <li class="sidebar-menu-group-title">User</li>
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                        <span>Users</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('usersList') }}"><i
                                    class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Users List</a>
                        </li>
                        <li>
                            <a href="{{ route('usersGrid') }}"><i
                                    class="ri-circle-fill circle-icon text-warning-600 w-auto"></i> Users Grid</a>
                        </li>
                        <li>
                            <a href="{{ route('addUser') }}"><i
                                    class="ri-circle-fill circle-icon text-info-600 w-auto"></i> Add User</a>
                        </li>
                        <li>
                            <a href="{{ route('viewProfile') }}"><i
                                    class="ri-circle-fill circle-icon text-danger-600 w-auto"></i> View Profile</a>
                        </li>
                    </ul>
                </li>
            @endif

            <li class="sidebar-menu-group-title">Master</li>
            @if ($noOperator)
            <li>
                <a href="{{ url('/category') }}">
                    <iconify-icon icon="iconamoon:category-fill" class
                    ="menu-icon"></iconify-icon>
                    <span>Kategori</span>
                </a>
            </li>
                <li>
                    <a href="{{ url('/product') }}">
                        <iconify-icon icon="ix:product" class="menu-icon"></iconify-icon>
                        <span>Products</span>
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ url('/member') }}">
                    <iconify-icon icon="tdesign:member-filled" class="menu-icon"></iconify-icon>
                    <span>Member</span>
                </a>
            </li>


            @if (Auth::user()->role == 'admin' && 'super_admin')
                <li>
                    <a href="{{ url('/payment-method') }}">
                        <iconify-icon icon="fluent:payment-48-filled" class="menu-icon"></iconify-icon>
                        <span>Payment Method</span>
                    </a>
                </li>
            @endif


            <li class="sidebar-menu-group-title">Expense</li>
            @if (Auth::user()->role == 'admin' && 'super_admin')
                <li>
                    <a href="{{ url('/expense-categories') }}">
                        <iconify-icon icon="solar:cash-out-bold-duotone" class="menu-icon"></iconify-icon>
                        <span>Expense Categories</span>
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ url('/expense') }}">
                    <iconify-icon icon="solar:cash-out-bold-duotone" class="menu-icon"></iconify-icon>
                    <span>Expense</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/expense/create') }}">
                    <iconify-icon icon="solar:cash-out-bold" class="menu-icon"></iconify-icon>
                    <span>Create Expense</span>
                </a>
            </li>

            <li class="sidebar-menu-group-title">Transaksi</li>
            <li>
                <a href="{{ url('/transaction') }}">
                    <iconify-icon icon="icon-park-twotone:transaction" class="menu-icon"></iconify-icon>
                    <span>Transaction</span>
                </a>
            </li>




            <li class="sidebar-menu-group-title">Reservasi</li>
            <li>
                <a href="{{ url('/reservations') }}">
                    <iconify-icon icon="solar:cash-out-bold-duotone" class="menu-icon"></iconify-icon>
                    <span>Reservation</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/tables') }}">
                    <iconify-icon icon="material-symbols:table-bar" class="menu-icon"></iconify-icon>
                    <span>Tables</span>
                </a>
            </li>


            <li class="sidebar-menu-group-title">Order</li>
            <li>
                <a href="{{ url('/order') }}">
                    <iconify-icon icon="solar:cash-out-bold-duotone" class="menu-icon"></iconify-icon>
                    <span>Order</span>
                </a>
            </li>



            {{-- <li class="sidebar-menu-group-title">Report</li>
            <li>
                <a href="{{ url('/income-report') }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Laporan Pendapatan</span>
                </a>
            </li> --}}

            <li class="sidebar-menu-group-title">System</li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="icon-park-outline:setting-two" class="menu-icon"></iconify-icon>
                    <span>Pengaturan</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('company') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Company</a>
                    </li>
                    <li>
                        <a href="{{ route('notification') }}"><i
                                class="ri-circle-fill circle-icon text-warning-600 w-auto"></i> Notification</a>
                    </li>
                    <li>
                        <a href="{{ route('notificationAlert') }}"><i
                                class="ri-circle-fill circle-icon text-info-600 w-auto"></i> Notification Alert</a>
                    </li>
                    <li>
                        <a href="{{ route('theme') }}"><i
                                class="ri-circle-fill circle-icon text-danger-600 w-auto"></i>
                            Theme</a>
                    </li>
                    <li>
                        <a href="{{ route('currencies') }}"><i
                                class="ri-circle-fill circle-icon text-danger-600 w-auto"></i> Currencies</a>
                    </li>
                    <li>
                        <a href="{{ route('language') }}"><i
                                class="ri-circle-fill circle-icon text-danger-600 w-auto"></i> Languages</a>
                    </li>
                    <li>
                        <a href="{{ route('paymentGateway') }}"><i
                                class="ri-circle-fill circle-icon text-danger-600 w-auto"></i> Payment Gateway</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>
