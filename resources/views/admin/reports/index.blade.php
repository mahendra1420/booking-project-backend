@extends('layouts.admin')

@section('title', 'Reports')
@section('page-title', 'Reports')

@section('content')
<div class="admin-page-header d-flex align-items-center mb-4">
    <div class="header-icon me-3">
        <i class="fas fa-chart-line fs-3" style="color: var(--admin-primary)"></i>
    </div>
    <div>
        <h2 class="mb-1">Reports & Analytics</h2>
        <p class="mb-0" style="color: var(--admin-text-muted)">View detailed statistics, revenue, and usage reports.</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-white  h-100">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">Total Revenue</h6>
                <h3 class="card-title text-success">$0.00</h3>
                <small class="text-success"><i class="fas fa-arrow-up"></i> 0% from last month</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-white  h-100">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">Appointments</h6>
                <h3 class="card-title text-info">0</h3>
                <small class="text-success"><i class="fas fa-arrow-up"></i> 0% from last month</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-white  h-100">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">New Customers</h6>
                <h3 class="card-title text-warning">0</h3>
                <small class="text-danger"><i class="fas fa-arrow-down"></i> 0% from last month</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-white  h-100">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">Total Barbers</h6>
                <h3 class="card-title text-primary">0</h3>
                <small class="text-muted">Active in system</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card bg-white  h-100">
            <div class="card-header  d-flex justify-content-between align-items-center">
                <h5 class="mb-0 ">Revenue Overview</h5>
                <select class="form-select form-select-sm bg-white   w-auto">
                    <option>This Year</option>
                    <option>Last Year</option>
                </select>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <div class="text-center p-5" style="color: var(--admin-text-muted);">
                    <i class="fas fa-chart-bar fs-1 mb-3"></i>
                    <p>Chart data will be populated here.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card bg-white  h-100">
            <div class="card-header ">
                <h5 class="mb-0 ">Top Services</h5>
            </div>
            <div class="card-body">
                <div class="text-center p-5" style="color: var(--admin-text-muted);">
                    <i class="fas fa-chart-pie fs-1 mb-3"></i>
                    <p>Data visualization placeholder.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
