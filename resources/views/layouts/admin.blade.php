<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name') }} Admin</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Toastr -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <style>
        :root {
            --admin-primary:      #6C5CE7;
            --admin-primary-rgb:  108, 92, 231;
            --admin-secondary:    #00B894;
            --admin-accent:       #FDCB6E;
            --admin-danger:       #D63031;
            --admin-warning:      #E17055;
            --admin-info:         #0984E3;
            --admin-sidebar-bg:   #FCFBF9;
            --admin-sidebar-w:    260px;
            --admin-topnav-h:     64px;
            --admin-card-bg:      #FCFBF9;
            --admin-surface:      #F5F4F0;
            --admin-border:       rgba(0,0,0,0.06);
            --admin-text:         #1A1A1A;
            --admin-text-muted:   #595959;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #F0EFEA;
            color: var(--admin-text);
            margin: 0;
            overflow-x: hidden;
        }

        /* ── SIDEBAR ───────────────────────────────────────────────────────── */
        .admin-sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--admin-sidebar-w);
            height: 100vh;
            background: var(--admin-sidebar-bg);
            border-right: 1px solid var(--admin-border);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: transform 0.3s ease;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(108,92,231,0.3) transparent;
        }

        .sidebar-brand {
            padding: 20px 24px;
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .sidebar-brand .brand-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--admin-primary), #a29bfe);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: #fff;
            flex-shrink: 0;
        }

        .sidebar-brand .brand-name {
            font-size: 16px;
            font-weight: 700;
            color: var(--admin-text);
            letter-spacing: -0.3px;
        }

        .sidebar-brand .brand-tag {
            font-size: 10px;
            color: var(--admin-text-muted);
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 0;
        }

        .nav-section-title {
            font-size: 10px;
            font-weight: 600;
            color: var(--admin-text-muted);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 12px 24px 6px;
        }

        .nav-link-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 24px;
            color: var(--admin-text-muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 0;
            transition: all 0.2s;
            position: relative;
            margin: 1px 0;
        }

        .nav-link-item .nav-icon {
            width: 20px; text-align: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .nav-link-item .nav-badge {
            margin-left: auto;
            background: var(--admin-danger);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 20px;
            min-width: 20px;
            text-align: center;
        }

        .nav-link-item:hover {
            color: var(--admin-primary);
            background: rgba(108,92,231,0.05);
        }

        .nav-link-item.active {
            color: var(--admin-primary);
            background: linear-gradient(90deg, rgba(108,92,231,0.1), transparent);
        }

        .nav-link-item.active::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 3px;
            background: var(--admin-primary);
            border-radius: 0 2px 2px 0;
        }

        .nav-link-item.active .nav-icon { color: var(--admin-primary); }

        .sidebar-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--admin-border);
        }

        /* ── TOPNAV ────────────────────────────────────────────────────────── */
        .admin-topnav {
            position: fixed;
            top: 0;
            left: var(--admin-sidebar-w);
            right: 0;
            height: var(--admin-topnav-h);
            background: var(--admin-card-bg);
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 16px;
            z-index: 999;
        }

        .topnav-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--admin-text);
            font-size: 20px;
            cursor: pointer;
            padding: 4px;
        }

        .topnav-breadcrumb {
            flex: 1;
            font-size: 14px;
        }

        .topnav-breadcrumb .page-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--admin-text);
            margin: 0;
        }

        .topnav-breadcrumb .breadcrumb {
            font-size: 12px;
            color: var(--admin-text-muted);
            margin: 0;
        }

        .topnav-actions { display: flex; align-items: center; gap: 8px; }

        .topnav-btn {
            width: 40px; height: 40px;
            background: var(--admin-surface);
            border: 1px solid var(--admin-border);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: var(--admin-text-muted);
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
            text-decoration: none;
        }

        .topnav-btn:hover { background: rgba(108,92,231,0.15); color: var(--admin-primary); border-color: rgba(108,92,231,0.3); }

        .topnav-btn .badge-dot {
            width: 8px; height: 8px;
            background: var(--admin-danger);
            border-radius: 50%;
            position: absolute;
            top: 8px; right: 8px;
        }

        .topnav-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px;
            background: var(--admin-surface);
            border: 1px solid var(--admin-border);
            border-radius: 12px;
            cursor: pointer;
            text-decoration: none;
        }

        .topnav-user .user-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--admin-primary), #a29bfe);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }

        .topnav-user .user-info .user-name { font-size: 13px; font-weight: 600; color: var(--admin-text); }
        .topnav-user .user-info .user-role { font-size: 11px; color: var(--admin-text-muted); }

        /* ── MAIN CONTENT ──────────────────────────────────────────────────── */
        .admin-main {
            margin-left: var(--admin-sidebar-w);
            margin-top: var(--admin-topnav-h);
            min-height: calc(100vh - var(--admin-topnav-h));
            padding: 28px;
        }

        /* ── STAT CARDS ────────────────────────────────────────────────────── */
        .stat-card {
            background: var(--admin-card-bg);
            border: 1px solid var(--admin-border);
            border-radius: 16px;
            padding: 22px;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(0,0,0,0.3); }

        .stat-card .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            margin-bottom: 16px;
        }

        .stat-card .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--admin-text);
            letter-spacing: -0.5px;
            line-height: 1;
        }

        .stat-card .stat-label {
            font-size: 13px;
            color: var(--admin-text-muted);
            margin-top: 6px;
            font-weight: 500;
        }

        .stat-card .stat-change {
            font-size: 12px;
            font-weight: 600;
            margin-top: 8px;
        }

        .stat-card .stat-bg-icon {
            position: absolute;
            right: -10px; bottom: -10px;
            font-size: 80px;
            opacity: 0.03;
            color: var(--admin-text);
        }

        /* ── CHART CARDS ───────────────────────────────────────────────────── */
        .chart-card {
            background: var(--admin-card-bg);
            border: 1px solid var(--admin-border);
            border-radius: 16px;
            padding: 24px;
        }

        .chart-card .chart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .chart-card .chart-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--admin-text);
        }

        /* ── DATA TABLES ───────────────────────────────────────────────────── */
        .admin-table-card {
            background: var(--admin-card-bg);
            border: 1px solid var(--admin-border);
            border-radius: 16px;
        }

        .admin-table-card .table-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .admin-table-card .table-header h6 {
            font-size: 15px;
            font-weight: 700;
            color: var(--admin-text);
            margin: 0;
        }

        table.dataTable thead th {
            background: var(--admin-surface) !important;
            color: var(--admin-text-muted) !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            border-color: var(--admin-border) !important;
            padding: 14px 16px !important;
        }

        table.dataTable tbody td {
            background: var(--admin-card-bg) !important;
            color: var(--admin-text) !important;
            border-color: var(--admin-border) !important;
            font-size: 14px !important;
            padding: 12px 16px !important;
            vertical-align: middle !important;
        }

        table.dataTable tbody tr:hover td {
            background: var(--admin-surface) !important;
        }

        /* ── BADGES ────────────────────────────────────────────────────────── */
        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .status-pending    { background: rgba(253,203,110,0.15); color: #FDCB6E; }
        .status-active,
        .status-completed,
        .status-approved   { background: rgba(0,184,148,0.15); color: #00B894; }
        .status-rejected,
        .status-cancelled  { background: rgba(214,48,49,0.15); color: #FF7675; }
        .status-suspended  { background: rgba(225,112,85,0.15); color: #E17055; }
        .status-confirmed  { background: rgba(9,132,227,0.15); color: #74B9FF; }
        .status-in_progress { background: rgba(108,92,231,0.15); color: #A29BFE; }

        /* ── FORMS ─────────────────────────────────────────────────────────── */
        .form-control, .form-select {
            background: var(--admin-surface) !important;
            border-color: var(--admin-border) !important;
            color: var(--admin-text) !important;
            border-radius: 10px !important;
        }

        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(108,92,231,0.2) !important;
            border-color: var(--admin-primary) !important;
        }

        .form-control::placeholder { color: var(--admin-text-muted) !important; }

        /* ── BUTTONS ───────────────────────────────────────────────────────── */
        .btn-primary {
            background: var(--admin-primary) !important;
            border-color: var(--admin-primary) !important;
            font-weight: 600;
        }

        .btn-outline-primary {
            border-color: var(--admin-primary) !important;
            color: var(--admin-primary) !important;
        }

        /* ── DROPDOWN ──────────────────────────────────────────────────────── */
        .dropdown-menu {
            background: var(--admin-card-bg) !important;
            border: 1px solid var(--admin-border) !important;
            border-radius: 12px !important;
            box-shadow: 0 16px 40px rgba(0,0,0,0.5) !important;
        }

        .dropdown-item {
            color: var(--admin-text) !important;
            font-size: 14px !important;
            padding: 10px 16px !important;
            border-radius: 8px !important;
            margin: 2px 4px !important;
            transition: background 0.15s;
        }

        .dropdown-item:hover { background: rgba(108,92,231,0.15) !important; }

        /* ── MODALS ────────────────────────────────────────────────────────── */
        .modal-content {
            background: var(--admin-card-bg) !important;
            border: 1px solid var(--admin-border) !important;
            border-radius: 16px !important;
        }

        .modal-header {
            border-bottom: 1px solid var(--admin-border) !important;
            padding: 20px 24px !important;
        }

        .modal-footer {
            border-top: 1px solid var(--admin-border) !important;
            padding: 16px 24px !important;
        }

        /* ── SCROLLBAR ─────────────────────────────────────────────────────── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(108,92,231,0.3); border-radius: 3px; }

        /* ── RESPONSIVE ────────────────────────────────────────────────────── */
        @media (max-width: 991px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.show {
                transform: translateX(0);
                box-shadow: 4px 0 20px rgba(0,0,0,0.5);
            }

            .admin-topnav { left: 0; }
            .admin-main { margin-left: 0; }
            .topnav-toggle { display: flex !important; }
        }

        @media (max-width: 576px) {
            .admin-main { padding: 16px; }
            .stat-card .stat-value { font-size: 22px; }
        }

        /* ── UTILITIES ─────────────────────────────────────────────────────── */
        .text-primary { color: var(--admin-primary) !important; }
        .bg-primary   { background: var(--admin-primary) !important; }
        .avatar-sm { width: 34px; height: 34px; border-radius: 50%; object-fit: cover; }
        .avatar-initials {
            width: 34px; height: 34px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }
        .card-border { border: 1px solid var(--admin-border) !important; border-radius: 16px !important; }
        .divider { border-color: var(--admin-border) !important; }
        .page-header { margin-bottom: 24px; }
        .page-header h4 { font-weight: 800; color: var(--admin-text); margin: 0; }
        .page-header p { color: var(--admin-text-muted); font-size: 14px; margin: 4px 0 0; }
    </style>

    @stack('styles')
</head>
<body>

{{-- ── SIDEBAR ──────────────────────────────────────────────────────────── --}}
<aside class="admin-sidebar" id="adminSidebar">

    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
        <div class="brand-icon"><i class="fa-solid fa-calendar-check"></i></div>
        <div>
            <div class="brand-name">BookingPro</div>
            <div class="brand-tag">Admin Panel</div>
        </div>
    </a>

    <nav class="sidebar-nav">

        <div class="nav-section-title">Main</div>

        <a href="{{ route('admin.dashboard') }}"
           class="nav-link-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-gauge-high"></i></span>
            Dashboard
        </a>

        <div class="nav-section-title">Users</div>

        <a href="{{ route('admin.customers.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-users"></i></span>
            Customers
        </a>

        <div class="nav-section-title">Business</div>

        <a href="{{ route('admin.businesses.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.businesses.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-store"></i></span>
            Businesses
            @php $pendingCount = \App\Models\Business::where('status','pending')->count(); @endphp
            @if($pendingCount > 0)
                <span class="nav-badge">{{ $pendingCount }}</span>
            @endif
        </a>

        <a href="{{ route('admin.categories.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-layer-group"></i></span>
            Categories
        </a>

        <div class="nav-section-title">Operations</div>

        <a href="{{ route('admin.appointments.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-calendar-days"></i></span>
            Appointments
        </a>

        <a href="{{ route('admin.payments.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-credit-card"></i></span>
            Payments
        </a>

        <a href="{{ route('admin.payouts.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.payouts.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-money-bill-transfer"></i></span>
            Payouts
        </a>

        <div class="nav-section-title">Marketing</div>

        <a href="{{ route('admin.coupons.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-tag"></i></span>
            Coupons
        </a>

        <a href="{{ route('admin.banners.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-image"></i></span>
            Banners
        </a>

        <a href="{{ route('admin.notifications.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-bell"></i></span>
            Notifications
        </a>

        <div class="nav-section-title">Content</div>

        <a href="{{ route('admin.reviews.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-star"></i></span>
            Reviews
        </a>

        <a href="{{ route('admin.reports.revenue') }}"
           class="nav-link-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-chart-line"></i></span>
            Reports
        </a>

        <a href="{{ route('admin.cms.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.cms.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-file-lines"></i></span>
            CMS Pages
        </a>

        <div class="nav-section-title">System</div>

        <a href="{{ route('admin.support.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.support.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-headset"></i></span>
            Support
        </a>

        <a href="{{ route('admin.roles.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-shield-halved"></i></span>
            Roles
        </a>

        <a href="{{ route('admin.audit-logs.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.audit-logs.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-clock-rotate-left"></i></span>
            Audit Logs
        </a>

        <a href="{{ route('admin.settings.index') }}"
           class="nav-link-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-gear"></i></span>
            Settings
        </a>

    </nav>

    <div class="sidebar-footer">
        <a href="{{ route('admin.logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="nav-link-item" style="padding: 10px 0;">
            <span class="nav-icon"><i class="fa-solid fa-right-from-bracket text-danger"></i></span>
            <span class="text-danger">Logout</span>
        </a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">@csrf</form>
    </div>

</aside>

{{-- ── TOPNAV ────────────────────────────────────────────────────────────── --}}
<header class="admin-topnav">
    <button class="topnav-toggle" id="sidebarToggle">
        <i class="fa-solid fa-bars"></i>
    </button>

    <div class="topnav-breadcrumb">
        <h5 class="page-title">@yield('page-title', 'Dashboard')</h5>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted">Home</a></li>
                @yield('breadcrumb')
            </ol>
        </nav>
    </div>

    <div class="topnav-actions ms-auto">
        {{-- Search --}}
        <a href="#" class="topnav-btn" data-bs-toggle="tooltip" title="Search">
            <i class="fa-solid fa-magnifying-glass"></i>
        </a>

        {{-- Notifications --}}
        <a href="#" class="topnav-btn" data-bs-toggle="tooltip" title="Notifications">
            <i class="fa-solid fa-bell"></i>
            <span class="badge-dot"></span>
        </a>

        {{-- User Dropdown --}}
        <div class="dropdown">
            <a class="topnav-user" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth('admin')->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="user-info d-none d-md-block">
                    <div class="user-name">{{ auth('admin')->user()->name ?? 'Admin' }}</div>
                    <div class="user-role">{{ auth('admin')->user()->role?->name ?? 'Super Admin' }}</div>
                </div>
                <i class="fa-solid fa-chevron-down ms-2 d-none d-md-block" style="font-size:11px; color:var(--admin-text-muted)"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end mt-2" style="min-width:200px;">
                <li><a class="dropdown-item" href="#"><i class="fa-solid fa-user me-2 text-primary"></i>My Profile</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}"><i class="fa-solid fa-gear me-2 text-primary"></i>Settings</a></li>
                <li><hr class="dropdown-divider divider"></li>
                <li>
                    <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>

{{-- Sidebar overlay for mobile --}}
<div class="d-lg-none" id="sidebarOverlay"
     style="display:none!important; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:999;"
     onclick="closeSidebar()"></div>

{{-- ── MAIN CONTENT ──────────────────────────────────────────────────────── --}}
<main class="admin-main">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="fa-solid fa-circle-xmark me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    // Sidebar toggle
    const sidebar  = document.getElementById('adminSidebar');
    const overlay  = document.getElementById('sidebarOverlay');
    const toggle   = document.getElementById('sidebarToggle');

    toggle?.addEventListener('click', () => {
        sidebar.classList.toggle('show');
        overlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
    });

    function closeSidebar() {
        sidebar.classList.remove('show');
        overlay.style.display = 'none';
    }

    // Tooltips
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el, { trigger: 'hover' });
    });

    // Toastr config
    toastr.options = {
        positionClass: 'toast-bottom-right',
        timeOut: 4000,
        closeButton: true,
        progressBar: true,
    };

    // Flash messages → toastr
    @if(session('success')) toastr.success("{{ session('success') }}"); @endif
    @if(session('error'))   toastr.error("{{ session('error') }}"); @endif
    @if(session('warning')) toastr.warning("{{ session('warning') }}"); @endif

    // AJAX CSRF setup
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
</script>

@stack('scripts')
</body>
</html>
