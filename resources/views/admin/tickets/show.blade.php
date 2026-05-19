<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h2 class="h4 m-0 text-brand">Detail Tiket #{{ $ticket->id }}</h2>
            <a href="{{ route('admin.tickets.index', ['tab' => $ticket->status]) }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <strong>Informasi Tiket</strong>
                    @php
                        $statusClass = match($ticket->status) {
                            'pending' => 'bg-warning text-dark',
                            'scheduled' => 'bg-info text-dark',
                            'completed' => 'bg-success',
                            default => 'bg-secondary',
                        };
                        $statusLabel = match($ticket->status) {
                            'pending' => 'Pending',
                            'scheduled' => 'Terjadwal',
                            'completed' => 'Selesai',
                            default => ucfirst($ticket->status),
                        };
                    @endphp
                    <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-3">{{ $ticket->subject }}</h5>
                    <p class="card-text text-muted mb-0" style="white-space: pre-wrap;">{{ $ticket->description }}</p>

                    @if($ticket->attachment_path)
                        <hr>
                        <h6 class="mb-2">
                            <i class="bi bi-paperclip me-2 text-primary"></i>
                            Lampiran Dokumen
                        </h6>
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <i class="bi bi-file-earmark-pdf text-danger"></i>
                            <span>{{ $ticket->attachment_original_name }}</span>
                            <a href="{{ Storage::url($ticket->attachment_path) }}"
                               target="_blank"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-download me-1"></i> Download
                            </a>
                        </div>
                    @endif

                    <hr>
                    <small class="text-muted">Dibuat: {{ $ticket->created_at->format('d M Y, H:i') }}</small>
                </div>
            </div>

            @if($ticket->appointment)
                <div class="card shadow-sm">
                    <div class="card-header bg-white"><strong>Janji Pertemuan</strong></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="text-muted small">Waktu</div>
                                <div>{{ $ticket->appointment->scheduled_at->format('d M Y, H:i') }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-muted small">Lokasi</div>
                                <div>{{ $ticket->appointment->location ?? '-' }}</div>
                            </div>
                            <div class="col-12">
                                <div class="text-muted small">Catatan</div>
                                <div>{{ $ticket->appointment->notes ?? '-' }}</div>
                            </div>
                            @if($ticket->appointment->admin)
                                <div class="col-12">
                                    <div class="text-muted small">Dijadwalkan oleh</div>
                                    <div>{{ $ticket->appointment->admin->name }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white"><strong>Pengguna</strong></div>
                <div class="card-body">
                    <dl class="mb-0">
                        <dt class="text-muted small">Nama</dt>
                        <dd class="mb-2">{{ $ticket->user->name }}</dd>
                        <dt class="text-muted small">Email</dt>
                        <dd class="mb-2">
                            <a href="mailto:{{ $ticket->user->email }}">{{ $ticket->user->email }}</a>
                        </dd>
                        <dt class="text-muted small">Telepon</dt>
                        <dd class="mb-0">
                            @if($ticket->user->phone)
                                <a href="tel:{{ $ticket->user->phone }}">{{ $ticket->user->phone }}</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>

            @if($ticket->status === 'pending')
                <div class="card shadow-sm border-warning">
                    <div class="card-header bg-white"><strong>Jadwalkan Pertemuan</strong></div>
                    <div class="card-body">
                        <form action="{{ route('admin.tickets.schedule', $ticket) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="scheduled_at" class="form-label">Waktu <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="scheduled_at" id="scheduled_at"
                                       class="form-control @error('scheduled_at') is-invalid @enderror"
                                       value="{{ old('scheduled_at') }}" required>
                                @error('scheduled_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Lokasi</label>
                                <input type="text" name="location" id="location"
                                       class="form-control @error('location') is-invalid @enderror"
                                       value="{{ old('location') }}" placeholder="Contoh: Ruang Rapat Dinas">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Catatan</label>
                                <textarea name="notes" id="notes" rows="3"
                                          class="form-control @error('notes') is-invalid @enderror"
                                          placeholder="Catatan untuk pengguna">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-brand w-100">
                                <i class="bi bi-calendar-check me-1"></i> Jadwalkan
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($ticket->status === 'scheduled')
                <div class="card shadow-sm">
                    <div class="card-header bg-white"><strong>Aksi</strong></div>
                    <div class="card-body">
                        <form action="{{ route('admin.tickets.mark-completed', $ticket) }}" method="POST"
                              onsubmit="return confirm('Tandai tiket ini sebagai selesai?')">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check-circle me-1"></i> Tandai Selesai
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
