<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function revenue(Request $request)
    {
        $data = Payment::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(amount) as total_revenue'),
                DB::raw('COUNT(*) as total_transactions')
            )
            ->where('status', 'paid')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        return view('admin.reports.index', [
            'report' => 'revenue',
            'data'   => $data,
        ]);
    }

    public function bookings(Request $request)
    {
        $data = Appointment::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total_bookings'),
                'status'
            )
            ->groupBy('month', 'status')
            ->orderBy('month', 'desc')
            ->get();

        return view('admin.reports.index', [
            'report' => 'bookings',
            'data'   => $data,
        ]);
    }

    public function customers(Request $request)
    {
        $data = User::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as new_customers')
            )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        return view('admin.reports.index', [
            'report' => 'customers',
            'data'   => $data,
        ]);
    }

    public function commission(Request $request)
    {
        $data = Payment::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(commission_amount) as total_commission')
            )
            ->where('status', 'paid')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        return view('admin.reports.index', [
            'report' => 'commission',
            'data'   => $data,
        ]);
    }

    public function export(Request $request)
    {
        $type = $request->input('type', 'revenue');

        // TODO: implement actual CSV/Excel export using Maatwebsite/Excel or similar
        $filename = "report_{$type}_" . now()->format('Y_m_d') . '.csv';

        return response()->streamDownload(function () use ($type) {
            echo "report_type,placeholder\n";
            echo "{$type},export_not_yet_implemented\n";
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
