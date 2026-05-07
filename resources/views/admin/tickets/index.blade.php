

<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 m-0 text-brand">Manajemen Tiket</h2>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs mb-4" id="ticketTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                Pending <span class="badge bg-warning ms-1">{{ $pendingTickets->total() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="scheduled-tab" data-bs-toggle="tab" data-bs-target="#scheduled" type="button" role="tab">
                Terjadwal <span class="badge bg-info ms-1">{{ $scheduledTickets->total() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab">
                Selesai <span class="badge bg-success ms-1">{{ $completedTickets->total() }}</span>
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="ticketTabsContent">
        <!-- Pending Tickets -->
        <div class="tab-pane fade show active" id="pending" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Tiket Pending</h5>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Pengguna</th>
                                <th>Subjek</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($pendingTickets as $ticket)
                            <tr>
                                <td>{{ $ticket->user->name }}</td>
                                <td>{{ $ticket->subject }}</td>
                                <td>{{ $ticket->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <form class="row gx-2" action="{{ route('admin.tickets.schedule', $ticket) }}" method="POST">
                                        @csrf
                                        <div class="col-auto">
                                            <input type="datetime-local" name="scheduled_at" class="form-control form-control-sm" required>
                                        </div>
                                        <div class="col-auto">
                                            <input type="text" name="location" class="form-control form-control-sm" placeholder="Lokasi (opsional)">
                                        </div>
                                        <div class="col-auto">
                                            <input type="text" name="notes" class="form-control form-control-sm" placeholder="Catatan (opsional)">
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn btn-sm btn-brand">Jadwalkan</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Tidak ada tiket pending</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if($pendingTickets->hasPages())
                    <div class="card-footer">{{ $pendingTickets->links() }}</div>
                @endif
            </div>
        </div>

        <!-- Scheduled Tickets -->
        <div class="tab-pane fade" id="scheduled" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Tiket Terjadwal</h5>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Pengguna</th>
                                <th>Subjek</th>
                                <th>Jadwal</th>
                                <th>Lokasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($scheduledTickets as $ticket)
                            <tr>
                                <td>{{ $ticket->user->name }}</td>
                                <td>{{ $ticket->subject }}</td>
                                <td>{{ $ticket->appointment ? $ticket->appointment->scheduled_at->format('d M Y H:i') : '-' }}</td>
                                <td>{{ $ticket->appointment && $ticket->appointment->location ? $ticket->appointment->location : '-' }}</td>
                                <td>
                                    @if($ticket->appointment)
                                        <form action="{{ route('admin.tickets.mark-completed', $ticket) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Tandai tiket ini sebagai selesai?')">
                                                Tandai Selesai
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">Tidak ada appointment</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Tidak ada tiket terjadwal</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if($scheduledTickets->hasPages())
                    <div class="card-footer">{{ $scheduledTickets->links() }}</div>
                @endif
            </div>
        </div>

        <!-- Completed Tickets -->
        <div class="tab-pane fade" id="completed" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Tiket Selesai</h5>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Pengguna</th>
                                <th>Subjek</th>
                                <th>Jadwal</th>
                                <th>Lokasi</th>
                                <th>Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($completedTickets as $ticket)
                            <tr>
                                <td>{{ $ticket->user->name }}</td>
                                <td>{{ $ticket->subject }}</td>
                                <td>{{ $ticket->appointment ? $ticket->appointment->scheduled_at->format('d M Y H:i') : '-' }}</td>
                                <td>{{ $ticket->appointment && $ticket->appointment->location ? $ticket->appointment->location : '-' }}</td>
                                <td>{{ $ticket->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Tidak ada tiket selesai</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if($completedTickets->hasPages())
                    <div class="card-footer">{{ $completedTickets->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>


