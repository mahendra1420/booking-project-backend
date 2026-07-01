<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Business;
use App\Models\Payment;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_customers'      => User::where('role', 'customer')->count(),
            'total_businesses'     => Business::count(),
            'pending_approvals'    => Business::where('status', 'pending')->count(),
            'todays_appointments'  => Appointment::whereDate('appointment_date', today())->count(),
            'monthly_appointments' => Appointment::whereMonth('appointment_date', now()->month)->whereYear('appointment_date', now()->year)->count(),
            'completed'            => Appointment::where('status', 'completed')->count(),
            'cancelled'            => Appointment::where('status', 'cancelled')->count(),
            'total_revenue'        => Payment::where('status', 'paid')->sum('amount'),
            'total_commission'     => DB::table('commissions')->sum('commission_amount'),
            'active_businesses'    => Business::where('status', 'active')->count(),
            'active_customers'     => User::where('role', 'customer')->where('status', true)->count(),
        ];

        // Revenue chart — last 12 months
        $revenueChart = Payment::where('status', 'paid')
            ->selectRaw("DATE_FORMAT(paid_at, '%Y-%m') as month, SUM(amount) as total")
            ->where('paid_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Bookings chart — last 12 months
        $bookingsChart = Appointment::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Fill missing months with 0
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('Y-m'));
        }

        $revenueData  = $months->mapWithKeys(fn($m) => [$m => $revenueChart->get($m, 0)]);
        $bookingsData = $months->mapWithKeys(fn($m) => [$m => $bookingsChart->get($m, 0)]);

        // Category performance
        $categoryStats = DB::table('businesses')
            ->join('categories', 'businesses.category_id', '=', 'categories.id')
            ->selectRaw('categories.name, COUNT(businesses.id) as count')
            ->where('businesses.status', 'active')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('count')
            ->limit(8)
            ->get();

        // Recent appointments
        $recentAppointments = Appointment::with(['user', 'business'])
            ->latest()
            ->limit(10)
            ->get();

        // Pending businesses
        $pendingBusinesses = Business::with(['owner', 'category'])
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'stats', 'revenueData', 'bookingsData',
            'categoryStats', 'recentAppointments', 'pendingBusinesses',
            'months'
        ));
    }
}
