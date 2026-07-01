<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\TicketReply;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index(Request $request)
    {
        $tickets = SupportTicket::with(['user'])
            ->latest()
            ->paginate(20);

        return view('admin.support.index', compact('tickets'));
    }

    public function show(SupportTicket $supportTicket)
    {
        $supportTicket->load(['user', 'replies.user', 'assignedTo']);

        return view('admin.support.show', compact('supportTicket'));
    }

    public function destroy(SupportTicket $supportTicket)
    {
        $supportTicket->replies()->delete();
        $supportTicket->delete();

        return redirect()->route('admin.support.index')
            ->with('success', 'Ticket deleted successfully.');
    }

    public function reply(Request $request, SupportTicket $supportTicket)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        TicketReply::create([
            'ticket_id' => $supportTicket->id,
            'user_id'   => auth()->id(),
            'body'      => $request->input('body'),
            'is_admin'  => true,
        ]);

        return redirect()->back()->with('success', 'Reply sent successfully.');
    }

    public function assign(Request $request, SupportTicket $supportTicket)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $supportTicket->update([
            'assigned_to' => $request->input('assigned_to'),
            'status'      => 'assigned',
        ]);

        return redirect()->back()->with('success', 'Ticket assigned successfully.');
    }

    public function close(SupportTicket $supportTicket)
    {
        $supportTicket->update(['status' => 'closed']);

        return redirect()->back()->with('success', 'Ticket closed successfully.');
    }
}
