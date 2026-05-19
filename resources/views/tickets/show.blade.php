<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 m-0 text-brand">Detail Tiket</h2>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $ticket->subject }}</h5>
            <p class="card-text">{{ $ticket->description }}</p>
            <div class="d-flex justify-content-between align-items-center">
                <span class="badge bg-brand">{{ ucfirst($ticket->status) }}</span>
                <small class="text-muted">Dibuat: {{ $ticket->created_at->format('d M Y H:i') }}</small>
            </div>
            
            @if($ticket->attachment_path)
                <div class="mt-3 p-3 bg-light rounded">
                    <h6 class="mb-2">
                        <i class="bi bi-paperclip me-2 text-primary"></i>
                        Lampiran Dokumen
                    </h6>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-file-earmark-pdf me-2 text-danger"></i>
                        <span class="me-3">{{ $ticket->attachment_original_name }}</span>
                        <a href="{{ Storage::url($ticket->attachment_path) }}" 
                           target="_blank" 
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-download me-1"></i>
                            Download
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($ticket->appointment)
        <div class="card shadow-sm">
            <div class="card-header bg-white"><strong>Janji Pertemuan</strong></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4"><strong>Waktu:</strong> {{ $ticket->appointment->scheduled_at->format('d M Y H:i') }}</div>
                    <div class="col-md-4"><strong>Lokasi:</strong> {{ $ticket->appointment->location ?? '-' }}</div>
                    <div class="col-md-4"><strong>Catatan:</strong> {{ $ticket->appointment->notes ?? '-' }}</div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>


