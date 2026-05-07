<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function index()
    {
        $pendingTickets = Ticket::where('user_id', Auth::id())
            ->where('status', Ticket::STATUS_PENDING)
            ->latest()
            ->paginate(10, ['*'], 'pending');
            
        $scheduledTickets = Ticket::where('user_id', Auth::id())
            ->where('status', Ticket::STATUS_SCHEDULED)
            ->whereHas('appointment')
            ->with('appointment')
            ->latest()
            ->paginate(10, ['*'], 'scheduled');
            
        $completedTickets = Ticket::where('user_id', Auth::id())
            ->where('status', Ticket::STATUS_COMPLETED)
            ->with('appointment')
            ->latest()
            ->paginate(10, ['*'], 'completed');

        return view('tickets.index', compact('pendingTickets', 'scheduledTickets', 'completedTickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'attachment' => ['nullable', 'file', 'mimes:pdf', 'max:10240'], // Max 10MB
        ]);

        $ticketData = [
            'user_id' => Auth::id(),
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'status' => 'pending',
        ];

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('ticket-attachments', $filename, 'public');
            
            $ticketData['attachment_path'] = $path;
            $ticketData['attachment_original_name'] = $file->getClientOriginalName();
        }

        $ticket = Ticket::create($ticketData);

        return redirect()->route('tickets.show', $ticket)->with('success', 'Tiket berhasil dibuat.');
    }

    public function show(Ticket $ticket)
    {
        // if ($ticket->user_id !== Auth::id()) {
        //     abort(403);
        // }
        return view('tickets.show', compact('ticket'));
    }
}
