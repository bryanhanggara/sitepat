<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketAdminController extends Controller
{
    public function index()
    {
        $pendingTickets = Ticket::where('status', Ticket::STATUS_PENDING)
            ->with('user')
            ->latest()
            ->paginate(10, ['*'], 'pending');
            
        $scheduledTickets = Ticket::where('status', Ticket::STATUS_SCHEDULED)
            ->with(['user', 'appointment'])
            ->latest()
            ->paginate(10, ['*'], 'scheduled');
            
        $completedTickets = Ticket::where('status', Ticket::STATUS_COMPLETED)
            ->with(['user', 'appointment'])
            ->latest()
            ->paginate(10, ['*'], 'completed');

        return view('admin.tickets.index', compact('pendingTickets', 'scheduledTickets', 'completedTickets'));
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'appointment.admin']);

        return view('admin.tickets.show', compact('ticket'));
    }

    public function markAsCompleted(Ticket $ticket)
    {
        if ($ticket->status !== Ticket::STATUS_SCHEDULED) {
            return back()->with('error', 'Hanya tiket terjadwal yang dapat ditandai selesai.');
        }

        $ticket->update(['status' => Ticket::STATUS_COMPLETED]);

        return redirect()
            ->route('admin.tickets.show', $ticket)
            ->with('success', 'Tiket berhasil ditandai sebagai selesai.');
    }
}
