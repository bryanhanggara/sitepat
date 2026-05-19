<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AppointmentScheduled;

class AppointmentController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        if ($ticket->status !== Ticket::STATUS_PENDING) {
            return back()->with('error', 'Tiket ini sudah dijadwalkan atau selesai.');
        }

        $validated = $request->validate([
            'scheduled_at' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $appointment = Appointment::create([
            'ticket_id' => $ticket->id,
            'admin_id' => Auth::id(),
            'scheduled_at' => $validated['scheduled_at'],
            'location' => $validated['location'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        $ticket->update(['status' => 'scheduled']);

        // Always send email notification
        $ticket->user->notify(new AppointmentScheduled($appointment));

        // If user has phone, redirect admin to WhatsApp with prefilled message for manual sending
        if ($ticket->user->phone) {
            $text = "Halo {$ticket->user->name}, janji pertemuan kamu telah dijadwalkan.\n" .
                'Waktu: ' . $appointment->scheduled_at . "\n" .
                'Lokasi: ' . ($appointment->location ?: '-') . "\n" .
                'Catatan: ' . ($appointment->notes ?: '-') . "\n\n" .
                'Detail tiket: ' . route('tickets.show', $ticket);

            $phone = preg_replace('/[^0-9]/', '', (string) $ticket->user->phone);
            $waLink = 'https://wa.me/' . $phone . '?text=' . rawurlencode($text);
            return redirect()->away($waLink);
        }

        return redirect()
            ->route('admin.tickets.show', $ticket)
            ->with('success', 'Janji pertemuan berhasil dijadwalkan.');
    }
}
