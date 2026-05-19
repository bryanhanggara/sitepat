<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 m-0 text-brand">Manajemen Tiket</h2>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @php
        $activeTab = request('tab', 'pending');
    @endphp

    <ul class="nav nav-tabs mb-4" id="ticketTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'pending' ? 'active' : '' }}" id="pending-tab"
                    data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                Pending <span class="badge bg-warning text-dark ms-1">{{ $pendingTickets->total() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'scheduled' ? 'active' : '' }}" id="scheduled-tab"
                    data-bs-toggle="tab" data-bs-target="#scheduled" type="button" role="tab">
                Terjadwal <span class="badge bg-info text-dark ms-1">{{ $scheduledTickets->total() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'completed' ? 'active' : '' }}" id="completed-tab"
                    data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab">
                Selesai <span class="badge bg-success ms-1">{{ $completedTickets->total() }}</span>
            </button>
        </li>
    </ul>

    <div class="tab-content" id="ticketTabsContent">
        {{-- Pending --}}
        <div class="tab-pane fade {{ $activeTab === 'pending' ? 'show active' : '' }}" id="pending" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tiket Pending</h5>
                    <small class="text-muted">Klik Detail untuk melihat isi tiket & menjadwalkan</small>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Pengguna</th>
                                <th>Subjek</th>
                                <th>Dibuat</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($pendingTickets as $ticket)
                            <tr>
                                <td class="text-muted">{{ $ticket->id }}</td>
                                <td>{{ $ticket->user->name }}</td>
                                <td>
                                    {{ $ticket->subject }}
                                    @if($ticket->attachment_path)
                                        <i class="bi bi-paperclip ms-1 text-muted" title="Memiliki lampiran"></i>
                                    @endif
                                </td>
                                <td>{{ $ticket->created_at->format('d M Y H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.tickets.show', $ticket) }}" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Tidak ada tiket pending</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if($pendingTickets->hasPages())
                    <div class="card-footer">{{ $pendingTickets->appends(['tab' => 'pending'])->links() }}</div>
                @endif
            </div>
        </div>

        {{-- Scheduled --}}
        <div class="tab-pane fade {{ $activeTab === 'scheduled' ? 'show active' : '' }}" id="scheduled" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Tiket Terjadwal</h5>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Pengguna</th>
                                <th>Subjek</th>
                                <th>Jadwal</th>
                                <th>Lokasi</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($scheduledTickets as $ticket)
                            <tr>
                                <td class="text-muted">{{ $ticket->id }}</td>
                                <td>{{ $ticket->user->name }}</td>
                                <td>{{ $ticket->subject }}</td>
                                <td>{{ $ticket->appointment ? $ticket->appointment->scheduled_at->format('d M Y H:i') : '-' }}</td>
                                <td>{{ $ticket->appointment?->location ?? '-' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.tickets.show', $ticket) }}" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Tidak ada tiket terjadwal</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if($scheduledTickets->hasPages())
                    <div class="card-footer">{{ $scheduledTickets->appends(['tab' => 'scheduled'])->links() }}</div>
                @endif
            </div>
        </div>

        {{-- Completed --}}
        <div class="tab-pane fade {{ $activeTab === 'completed' ? 'show active' : '' }}" id="completed" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Tiket Selesai</h5>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Pengguna</th>
                                <th>Subjek</th>
                                <th>Jadwal</th>
                                <th>Selesai</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($completedTickets as $ticket)
                            <tr>
                                <td class="text-muted">{{ $ticket->id }}</td>
                                <td>{{ $ticket->user->name }}</td>
                                <td>{{ $ticket->subject }}</td>
                                <td>{{ $ticket->appointment ? $ticket->appointment->scheduled_at->format('d M Y H:i') : '-' }}</td>
                                <td>{{ $ticket->updated_at->format('d M Y H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.tickets.show', $ticket) }}" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Tidak ada tiket selesai</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if($completedTickets->hasPages())
                    <div class="card-footer">{{ $completedTickets->appends(['tab' => 'completed'])->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
