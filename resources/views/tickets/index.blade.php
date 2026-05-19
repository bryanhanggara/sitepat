<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tiket Saya - SINANAS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/green.css') }}">
    <!-- Bootstrap Icons for icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body class="bg-app">
    <!-- Header -->
    <header class="bg-brand text-white">
        <div class="container py-3">
            <nav class="d-flex justify-content-between align-items-center">
                <a href="{{ route('dashboard') }}" class="text-white text-decoration-none d-flex align-items-center">
                    <span class="pill me-2">S</span>
                    <strong>SITEPAT</strong>
                </a>
                <div class="dropdown">
                    <button class="btn btn-light rounded-pill px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person-circle me-2"></i>Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 m-0 text-brand">Tiket Saya</h2>
            <a href="{{ route('tickets.create') }}" class="btn btn-brand">
                <i class="bi bi-plus-circle me-1"></i>Buat Tiket
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
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
                                    <th>Subjek</th>
                                    <th>Status</th>
                                    <th>Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($pendingTickets as $ticket)
                                <tr>
                                    <td>
                                        {{ $ticket->subject }}
                                        @if($ticket->attachment_path)
                                            <i class="bi bi-paperclip ms-2 text-muted" title="Memiliki lampiran"></i>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-pending">Pending</span></td>
                                    <td>{{ $ticket->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-eye me-1"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                        Tidak ada tiket pending
                                    </td>
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
                                    <th>Subjek</th>
                                    <th>Status</th>
                                    <th>Jadwal</th>
                                    <th>Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($scheduledTickets as $ticket)
                                <tr>
                                    <td>
                                        {{ $ticket->subject }}
                                        @if($ticket->attachment_path)
                                            <i class="bi bi-paperclip ms-2 text-muted" title="Memiliki lampiran"></i>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-scheduled">Terjadwal</span></td>
                                    <td>{{ $ticket->appointment->scheduled_at->format('d M Y H:i') }}</td>
                                    <td>{{ $ticket->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-eye me-1"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="bi bi-calendar-event display-4 d-block mb-2"></i>
                                        Tidak ada tiket terjadwal
                                    </td>
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
                                    <th>Subjek</th>
                                    <th>Status</th>
                                    <th>Jadwal</th>
                                    <th>Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($completedTickets as $ticket)
                                <tr>
                                    <td>
                                        {{ $ticket->subject }}
                                        @if($ticket->attachment_path)
                                            <i class="bi bi-paperclip ms-2 text-muted" title="Memiliki lampiran"></i>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-completed">Selesai</span></td>
                                    <td>
                                        @if($ticket->appointment)
                                            {{ $ticket->appointment->scheduled_at->format('d M Y H:i') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $ticket->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-eye me-1"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="bi bi-check-circle display-4 d-block mb-2"></i>
                                        Tidak ada tiket selesai
                                    </td>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>


