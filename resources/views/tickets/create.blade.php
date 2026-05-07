<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buat Tiket - SINANAS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/green.css') }}">
    <!-- Bootstrap Icons for icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        :root { --brand-green: #198754; }
        .bg-brand { background-color: var(--brand-green) !important; }
        .text-brand { color: var(--brand-green) !important; }
        .btn-brand { background-color: var(--brand-green); color: #fff; border-color: var(--brand-green); }
        .btn-brand:hover { background-color: #146c43; color: #fff; border-color: #146c43; }
        .form-control:focus { border-color: var(--brand-green); box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25); }
        .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); }
        .card-header { background-color: #f8f9fa; border-bottom: 1px solid #dee2e6; }
        body { background-color: #f8f9fa; }
        * { color-scheme: light !important; }
    </style>
</head>
<body class="bg-light">
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
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-brand text-white">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-ticket-perforated me-2"></i>
                            <h5 class="mb-0">Formulir Pembuatan Tiket</h5>
                        </div>
                        <small class="opacity-75">Lengkapi informasi di bawah ini untuk membuat tiket baru</small>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data" id="ticketForm">
                            @csrf
                            
                            <!-- Subject Field -->
                            <div class="mb-4">
                                <label for="subject" class="form-label fw-semibold">
                                    <i class="bi bi-heading me-1 text-brand"></i>
                                    Subjek Tiket
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="subject"
                                    name="subject" 
                                    value="{{ old('subject') }}" 
                                    class="form-control form-control-lg @error('subject') is-invalid @enderror" 
                                    placeholder="Masukkan subjek tiket Anda..."
                                    required
                                >
                                @error('subject')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Berikan judul yang jelas dan deskriptif untuk tiket Anda
                                </div>
                            </div>

                            <!-- Description Field -->
                            <div class="mb-4">
                                <label for="description" class="form-label fw-semibold">
                                    <i class="bi bi-text-paragraph me-1 text-brand"></i>
                                    Deskripsi Masalah
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea 
                                    id="description"
                                    name="description" 
                                    rows="6" 
                                    class="form-control @error('description') is-invalid @enderror" 
                                    placeholder="Jelaskan masalah atau permintaan Anda secara detail..."
                                    required
                                >{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Jelaskan masalah secara detail untuk membantu tim support memahami kebutuhan Anda
                                </div>
                            </div>

                            <!-- File Upload Field -->
                            <div class="mb-4">
                                <label for="attachment" class="form-label fw-semibold">
                                    <i class="bi bi-paperclip me-1 text-brand"></i>
                                    Lampiran Dokumen (PDF)
                                </label>
                                <div class="file-upload-wrapper">
                                    <input 
                                        type="file" 
                                        id="attachment"
                                        name="attachment" 
                                        class="form-control @error('attachment') is-invalid @enderror" 
                                        accept=".pdf"
                                        onchange="previewFile(this)"
                                    >
                                    @error('attachment')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Upload dokumen PDF yang relevan (maksimal 10MB)
                                    </div>
                                    <div id="filePreview" class="mt-2" style="display: none;">
                                        <div class="alert alert-info d-flex align-items-center">
                                            <i class="bi bi-file-earmark-pdf me-2 text-danger"></i>
                                            <span id="fileName"></span>
                                            <button type="button" class="btn-close ms-auto" onclick="clearFile()"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Kembali
                                </a>
                                <button type="submit" class="btn btn-brand">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Buat Tiket
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Help Section -->
                <div class="card mt-4 border-0 bg-light">
                    <div class="card-body">
                        <h6 class="card-title text-brand">
                            <i class="bi bi-lightbulb me-2"></i>
                            Tips Membuat Tiket yang Efektif
                        </h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                Gunakan subjek yang jelas dan spesifik
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                Jelaskan masalah secara detail dengan langkah-langkah yang sudah dicoba
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                Lampirkan dokumen pendukung jika diperlukan
                            </li>
                            <li>
                                <i class="bi bi-check-circle text-success me-2"></i>
                                Berikan informasi kontak yang dapat dihubungi
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function previewFile(input) {
            const file = input.files[0];
            const preview = document.getElementById('filePreview');
            const fileName = document.getElementById('fileName');
            
            if (file) {
                fileName.textContent = file.name;
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
        }
        
        function clearFile() {
            document.getElementById('attachment').value = '';
            document.getElementById('filePreview').style.display = 'none';
        }
        
        // Form validation
        document.getElementById('ticketForm').addEventListener('submit', function(e) {
            const subject = document.getElementById('subject').value.trim();
            const description = document.getElementById('description').value.trim();
            
            if (!subject || !description) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi.');
                return false;
            }
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


