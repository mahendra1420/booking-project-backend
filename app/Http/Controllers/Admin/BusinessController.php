<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index(Request $request)
    {
        $query = Business::with(['owner', 'category']);

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $businesses = $query->latest()->paginate(20);

        $stats = [
            'total'     => Business::count(),
            'active'    => Business::where('status', 'active')->count(),
            'pending'   => Business::where('status', 'pending')->count(),
            'suspended' => Business::where('status', 'suspended')->count(),
        ];

        $categories = \App\Models\Category::whereNull('parent_id')->orderBy('name')->get();

        return view('admin.businesses.index', compact('businesses', 'stats', 'categories'));
    }

    public function show(Business $business)
    {
        $business->load(['owner', 'category']);

        return view('admin.businesses.show', compact('business'));
    }

    public function edit(Business $business)
    {
        return view('admin.businesses.edit', compact('business'));
    }

    public function update(Request $request, Business $business)
    {
        $business->update($request->validated());

        return redirect()->route('admin.businesses.show', $business)
            ->with('success', 'Business updated successfully.');
    }

    public function destroy(Business $business)
    {
        $business->delete();

        return redirect()->route('admin.businesses.index')
            ->with('success', 'Business deleted successfully.');
    }

    public function approve($id)
    {
        $business = Business::findOrFail($id);
        $business->update(['status' => 'active', 'approved_by' => auth('admin')->id(), 'approved_at' => now()]);

        AuditLog::log('approve', 'businesses', $business->id, null, null, "Business '{$business->name}' approved.");

        return redirect()->back()->with('success', 'Business approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $business = Business::findOrFail($id);
        $reason = $request->input('reason', "Rejected by admin.");
        $business->update(['status' => 'rejected', 'rejection_reason' => $reason]);

        AuditLog::log('reject', 'businesses', $business->id, null, null, "Business '{$business->name}' rejected. Reason: {$reason}");

        return redirect()->back()->with('success', 'Business rejected.');
    }

    public function suspend($id)
    {
        $business = Business::findOrFail($id);
        $business->update(['status' => 'suspended']);
        AuditLog::log('suspend', 'businesses', $business->id, null, null, "Business '{$business->name}' suspended.");
        return redirect()->back()->with('success', 'Business suspended.');
    }

    public function feature($id)
    {
        $business = Business::findOrFail($id);
        $business->update(['is_featured' => ! $business->is_featured]);
        $label = $business->is_featured ? 'featured' : 'unfeatured';
        return redirect()->back()->with('success', "Business {$label} successfully.");
    }
}
