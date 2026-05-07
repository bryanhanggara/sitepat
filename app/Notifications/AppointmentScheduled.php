<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentScheduled extends Notification
{
    use Queueable;

    public function __construct(public Appointment $appointment)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Janji Pertemuan Disetujui')
            ->greeting('Halo ' . $notifiable->name)
            ->line('Permintaan janji pertemuan kamu telah dijadwalkan:')
            ->line('Waktu: ' . $this->appointment->scheduled_at)
            ->line('Lokasi: ' . ($this->appointment->location ?: '-'))
            ->line('Catatan: ' . ($this->appointment->notes ?: '-'))
            ->action('Lihat Tiket', url(route('tickets.show', $this->appointment->ticket)))
            ->line('Terima kasih.');
    }
}


