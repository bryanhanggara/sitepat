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
            ->whereHas('appointment')
            ->with(['user', 'appointment'])
            ->latest()
            ->paginate(10, ['*'], 'scheduled');
            
        $completedTickets = Ticket::where('status', Ticket::STATUS_COMPLETED)
            ->with(['user', 'appointment'])
            ->latest()
            ->paginate(10, ['*'], 'completed');

        return view('admin.tickets.index', compact('pendingTickets', 'scheduledTickets', 'completedTickets'));
    }

    public function markAsCompleted(Ticket $ticket)
    {
        $ticket->update(['status' => Ticket::STATUS_COMPLETED]);
        
        return back()->with('success', 'Tiket berhasil ditandai sebagai selesai.');
    }
}
