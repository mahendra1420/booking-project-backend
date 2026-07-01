@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- ── KPI STAT CARDS ──────────────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">

    {{-- Customers --}}
    <div class="col-6 col-md-4 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(108,92,231,0.15);">
                <i class="fa-solid fa-users" style="color:#6C5CE7;"></i>
            </div>
            <div class="stat-value">{{ number_format($stats['total_customers']) }}</div>
            <div class="stat-label">Total Customers</div>
            <div class="stat-change text-success"><i class="fa-solid fa-arrow-trend-up me-1"></i>Active: {{ number_format($stats['active_customers']) }}</div>
            <i class="fa-solid fa-users stat-bg-icon"></i>
        </div>
    </div>

    {{-- Businesses --}}
    <div class="col-6 col-md-4 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(0,184,148,0.15);">
                <i class="fa-solid fa-store" style="color:#00B894;"></i>
            </div>
            <div class="stat-value">{{ number_format($stats['total_businesses']) }}</div>
            <div class="stat-label">Total Businesses</div>
            <div class="stat-change text-success"><i class="fa-solid fa-circle-check me-1"></i>Active: {{ number_format($stats['active_businesses']) }}</div>
            <i class="fa-solid fa-store stat-bg-icon"></i>
        </div>
    </div>

    {{-- Pending Approvals --}}
    <div class="col-6 col-md-4 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(253,203,110,0.15);">
                <i class="fa-solid fa-hourglass-half" style="color:#FDCB6E;"></i>
            </div>
            <div class="stat-value">{{ number_format($stats['pending_approvals']) }}</div>
            <div class="stat-label">Pending Approvals</div>
            @if($stats['pending_approvals'] > 0)
                <div class="stat-change text-warning"><i class="fa-solid fa-triangle-exclamation me-1"></i>Needs attention</div>
            @else
                <div class="stat-change text-success"><i class="fa-solid fa-circle-check me-1"></i>All cleared</div>
            @endif
            <i class="fa-solid fa-hourglass-half stat-bg-icon"></i>
        </div>
    </div>

    {{-- Today's Appointments --}}
    <div class="col-6 col-md-4 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(9,132,227,0.15);">
                <i class="fa-solid fa-calendar-day" style="color:#74B9FF;"></i>
            </div>
            <div class="stat-value">{{ number_format($stats['todays_appointments']) }}</div>
            <div class="stat-label">Today's Appointments</div>
            <div class="stat-change text-muted"><i class="fa-solid fa-calendar me-1"></i>Monthly: {{ number_format($stats['monthly_appointments']) }}</div>
            <i class="fa-solid fa-calendar-day stat-bg-icon"></i>
        </div>
    </div>

    {{-- Completed --}}
    <div class="col-6 col-md-4 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(0,184,148,0.15);">
                <i class="fa-solid fa-circle-check" style="color:#00B894;"></i>
            </div>
            <div class="stat-value">{{ number_format($stats['completed']) }}</div>
            <div class="stat-label">Completed</div>
            <div class="stat-change text-success"><i class="fa-solid fa-arrow-trend-up me-1"></i>All time</div>
            <i class="fa-solid fa-circle-check stat-bg-icon"></i>
        </div>
    </div>

    {{-- Cancelled --}}
    <div class="col-6 col-md-4 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(214,48,49,0.15);">
                <i class="fa-solid fa-circle-xmark" style="color:#FF7675;"></i>
            </div>
            <div class="stat-value">{{ number_format($stats['cancelled']) }}</div>
            <div class="stat-label">Cancelled</div>
            <div class="stat-change text-danger"><i class="fa-solid fa-xmark me-1"></i>All time</div>
            <i class="fa-solid fa-circle-xmark stat-bg-icon"></i>
        </div>
    </div>

    {{-- Revenue --}}
    <div class="col-6 col-md-4 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(108,92,231,0.15);">
                <i class="fa-solid fa-indian-rupee-sign" style="color:#A29BFE;"></i>
            </div>
            <div class="stat-value">₹{{ number_format($stats['total_revenue'], 0) }}</div>
            <div class="stat-label">Total Revenue</div>
            <div class="stat-change text-success"><i class="fa-solid fa-arrow-trend-up me-1"></i>Gross earnings</div>
            <i class="fa-solid fa-rupee-sign stat-bg-icon"></i>
        </div>
    </div>

    {{-- Commission --}}
    <div class="col-6 col-md-4 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(0,184,148,0.15);">
                <i class="fa-solid fa-percent" style="color:#00B894;"></i>
            </div>
            <div class="stat-value">₹{{ number_format($stats['total_commission'], 0) }}</div>
            <div class="stat-label">Total Commission</div>
            <div class="stat-change text-success"><i class="fa-solid fa-coins me-1"></i>Platform earnings</div>
            <i class="fa-solid fa-percent stat-bg-icon"></i>
        </div>
    </div>

</div>

{{-- ── CHARTS ROW ──────────────────────────────────────────────────────────── --}}
<div class="row g-4 mb-4">

    {{-- Revenue Chart --}}
    <div class="col-12 col-xl-8">
        <div class="chart-card h-100">
            <div class="chart-header">
                <div>
                    <div class="chart-title">Revenue Overview</div>
                    <div style="font-size:12px; color:var(--admin-text-muted);">Last 12 months</div>
                </div>
                <div class="d-flex gap-2">
                    <span class="status-badge status-active">₹{{ number_format($revenueData->sum(), 0) }} Total</span>
                </div>
            </div>
            <canvas id="revenueChart" height="300"></canvas>
        </div>
    </div>

    {{-- Category Donut --}}
    <div class="col-12 col-xl-4">
        <div class="chart-card h-100">
            <div class="chart-header">
                <div>
                    <div class="chart-title">Category Performance</div>
                    <div style="font-size:12px; color:var(--admin-text-muted);">Active businesses</div>
                </div>
            </div>
            <canvas id="categoryChart" height="250"></canvas>
        </div>
    </div>

</div>

{{-- ── BOOKINGS + PENDING ──────────────────────────────────────────────────── --}}
<div class="row g-4 mb-4">

    {{-- Bookings Chart --}}
    <div class="col-12 col-xl-8">
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">Appointment Trends</div>
                <div style="font-size:12px; color:var(--admin-text-muted);">Monthly bookings</div>
            </div>
            <canvas id="bookingsChart" height="220"></canvas>
        </div>
    </div>

    {{-- Pending Approvals --}}
    <div class="col-12 col-xl-4">
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">Pending Approvals</div>
                <a href="{{ route('admin.businesses.index') }}?status=pending" class="btn btn-sm btn-outline-primary" style="font-size:12px; border-radius:8px;">View All</a>
            </div>
            @forelse($pendingBusinesses as $biz)
                <div class="d-flex align-items-center gap-3 mb-3 pb-3"
                     style="border-bottom: 1px solid var(--admin-border); @if($loop->last) border:none; padding-bottom:0!important; @endif">
                    <div class="avatar-initials" style="background:rgba(108,92,231,0.15); color:#A29BFE; font-size:13px;">
                        {{ strtoupper(substr($biz->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <div style="font-size:13px; font-weight:600; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            {{ $biz->name }}
                        </div>
                        <div style="font-size:11px; color:var(--admin-text-muted);">
                            {{ $biz->category?->name }} · {{ $biz->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <a href="{{ route('admin.businesses.show', $biz) }}" class="btn btn-sm btn-primary" style="font-size:11px; padding:4px 10px; border-radius:8px; white-space:nowrap;">Review</a>
                </div>
            @empty
                <div class="text-center py-4">
                    <i class="fa-solid fa-check-circle fa-2x text-success mb-2"></i>
                    <p style="color:var(--admin-text-muted); font-size:13px; margin:0;">All caught up!</p>
                </div>
            @endforelse
        </div>
    </div>

</div>

{{-- ── RECENT APPOINTMENTS TABLE ───────────────────────────────────────────── --}}
<div class="admin-table-card">
    <div class="table-header">
        <h6><i class="fa-solid fa-calendar-days me-2 text-primary"></i>Recent Appointments</h6>
        <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-outline-primary" style="font-size:12px; border-radius:8px;">
            View All <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-borderless mb-0" id="recentAppointmentsTable">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Business</th>
                    <th>Date & Time</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentAppointments as $appt)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-initials" style="background:rgba(108,92,231,0.15); color:#A29BFE; font-size:11px; width:30px; height:30px;">
                                    {{ strtoupper(substr($appt->user?->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-size:13px; font-weight:600; color:#fff;">{{ $appt->user?->name ?? '—' }}</div>
                                    <div style="font-size:11px; color:var(--admin-text-muted);">{{ $appt->user?->phone ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:13px;">{{ $appt->business?->name ?? '—' }}</td>
                        <td style="font-size:13px;">
                            {{ \Carbon\Carbon::parse($appt->appointment_date)->format('d M Y') }}<br>
                            <span style="font-size:11px; color:var(--admin-text-muted);">{{ \Carbon\Carbon::parse($appt->start_time)->format('h:i A') }}</span>
                        </td>
                        <td style="font-size:13px; font-weight:600; color:#A29BFE;">₹{{ number_format($appt->total_price, 0) }}</td>
                        <td>
                            <span class="status-badge status-{{ $appt->status }}">
                                {{ ucfirst($appt->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.appointments.show', $appt) }}"
                               class="btn btn-sm" style="background:rgba(108,92,231,0.15); color:#A29BFE; border-radius:8px; font-size:12px; padding:4px 10px; border:none;">
                                <i class="fa-solid fa-eye me-1"></i>View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
const chartDefaults = {
    color: '#8888A8',
    borderColor: 'rgba(255,255,255,0.07)',
    font: { family: 'Inter' },
};
Chart.defaults.color = chartDefaults.color;
Chart.defaults.borderColor = chartDefaults.borderColor;
Chart.defaults.font.family = 'Inter';

const months = @json($months->map(fn($m) => \Carbon\Carbon::parse($m.'-01')->format('M Y')));
const revenueData = @json($revenueData->values());
const bookingsData = @json($bookingsData->values());

// Revenue Line Chart
new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Revenue (₹)',
            data: revenueData,
            borderColor: '#6C5CE7',
            backgroundColor: 'rgba(108,92,231,0.1)',
            borderWidth: 2.5,
            pointBackgroundColor: '#6C5CE7',
            pointRadius: 4,
            fill: true,
            tension: 0.4,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { font: { size: 11 } } },
            y: { grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { font: { size: 11 }, callback: v => '₹'+v.toLocaleString() } },
        }
    }
});

// Category Donut Chart
const catLabels = @json($categoryStats->pluck('name'));
const catData   = @json($categoryStats->pluck('count'));
const palette   = ['#6C5CE7','#00B894','#FDCB6E','#E17055','#0984E3','#A29BFE','#55EFC4','#FD79A8'];
new Chart(document.getElementById('categoryChart'), {
    type: 'doughnut',
    data: {
        labels: catLabels,
        datasets: [{ data: catData, backgroundColor: palette, borderWidth: 0, hoverOffset: 4 }]
    },
    options: {
        responsive: true,
        cutout: '70%',
        plugins: {
            legend: { position: 'bottom', labels: { padding: 12, font: { size: 11 }, usePointStyle: true, pointStyle: 'circle' } }
        }
    }
});

// Bookings Bar Chart
new Chart(document.getElementById('bookingsChart'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{
            label: 'Bookings',
            data: bookingsData,
            backgroundColor: 'rgba(0,184,148,0.7)',
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 11 } } },
            y: { grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { font: { size: 11 } } },
        }
    }
});

// Simple DataTable for recent appointments
$('#recentAppointmentsTable').DataTable({
    pageLength: 10,
    searching: false,
    paging: false,
    info: false,
    ordering: false,
    language: { emptyTable: 'No appointments yet.' }
});
</script>
@endpush
