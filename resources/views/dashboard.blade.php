<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
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
        <div class="container py-4">
            <!-- Navbar -->
            <nav class="d-flex justify-content-between align-items-center mb-4">
                <a href="#" class="text-white text-decoration-none d-flex align-items-center">
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
    
            @php
                $heroTicketCount = auth()->check()
                    ? \App\Models\Ticket::where('user_id', auth()->id())->count()
                    : 0;
                $heroPendingCount = auth()->check()
                    ? \App\Models\Ticket::where('user_id', auth()->id())->where('status', 'pending')->count()
                    : 0;
            @endphp

            <!-- Hero Section -->
            <section class="hero-section">
                <div class="hero-grid-pattern"></div>
                <div class="hero-blob hero-blob-1"></div>
                <div class="hero-blob hero-blob-2"></div>
                <div class="hero-blob hero-blob-3"></div>

                <div class="row align-items-center position-relative" style="z-index: 1;">
                    <div class="col-lg-7">
                        <span class="hero-badge">
                            <span class="pulse-dot"></span>
                            Layanan Digital Dinas Pendidikan
                        </span>

                        <h1 class="hero-title text-white">
                            E-Ticket Pendidikan<br>
                            <span class="gradient-text">Cepat, Transparan, Terintegrasi</span>
                        </h1>

                        <p class="hero-subtitle">
                            Ajukan pengaduan atau permohonan layanan, pantau progres tiket secara real-time,
                            dan terima jadwal pertemuan langsung via email atau WhatsApp.
                        </p>

                        <div class="hero-chips">
                            <span class="hero-chip"><i class="bi bi-lightning-charge-fill"></i> Proses Cepat</span>
                            <span class="hero-chip"><i class="bi bi-shield-check"></i> Terpercaya</span>
                            <span class="hero-chip"><i class="bi bi-whatsapp"></i> Notifikasi WA</span>
                            <span class="hero-chip"><i class="bi bi-calendar-check"></i> Jadwal Online</span>
                        </div>

                        <div class="hero-actions">
                            <a href="{{ route('tickets.create') }}" class="btn btn-brand btn-lg">
                                <i class="bi bi-plus-circle me-2"></i>Buat Tiket
                            </a>
                            <a href="{{ route('tickets.index') }}" class="btn-hero-outline">
                                <i class="bi bi-ticket-perforated"></i> Tiket Saya
                            </a>
                        </div>

                        <div class="hero-stats">
                            <div class="hero-stat">
                                <span class="hero-stat-value">{{ $heroTicketCount }}</span>
                                <span class="hero-stat-label">Total Tiket</span>
                            </div>
                            <div class="hero-stat">
                                <span class="hero-stat-value">{{ $heroPendingCount }}</span>
                                <span class="hero-stat-label">Pending</span>
                            </div>
                            <div class="hero-stat">
                                <span class="hero-stat-value">24/7</span>
                                <span class="hero-stat-label">Akses Online</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="hero-visual text-center">
                            <div class="hero-float-card hero-float-card-1">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                Tiket Terkirim
                            </div>
                            <div class="hero-float-card hero-float-card-2">
                                <i class="bi bi-calendar-event"></i>
                                Jadwal Aktif
                            </div>
                            <div class="hero-float-card hero-float-card-3">
                                <i class="bi bi-bell-fill"></i>
                                Notifikasi
                            </div>
                            <img src="{{ asset('assets/img/logo.png') }}"
                                 alt="Ilustrasi E-Ticket"
                                 class="img-fluid"
                                 style="max-width: 320px; height: auto; object-fit: contain;">
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </header>
    

    <main class="py-5">
        <!-- Cards Section -->
        <section class="container">
            <div class="row g-4 mb-5" style="margin-top: 20px">
                <div class="col-md-4">
                    <div class="card card-brand h-100">
                        <div class="card-body">
                            <h5 class="card-title d-flex align-items-center mb-3">
                                <span class="pill me-2">📝</span>Buat Tiket Layanan
                            </h5>
                            <ul class="list-unstyled mb-3">
                                <li class="mb-2 d-flex align-items-center">
                                    <span class="dot me-2"></span>Ajukan pengaduan atau permohonan layanan
                                </li>
                                <li class="mb-2 d-flex align-items-center">
                                    <span class="dot me-2"></span>Dapatkan nomor tiket & pantau status
                                </li>
                                <li class="mb-2 d-flex align-items-center">
                                    <span class="dot me-2"></span>Notifikasi status via email/WA
                                </li>
                            </ul>
                            <a href="{{ route('tickets.create') }}" class="btn btn-brand">Buat Tiket</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-brand h-100">
                        <div class="card-body">
                            <h5 class="card-title d-flex align-items-center mb-3">
                                <span class="pill me-2">📂</span>Tiket Saya
                            </h5>
                            <ul class="list-unstyled mb-3">
                                <li class="mb-2 d-flex align-items-center">
                                    <span class="dot me-2"></span>Lihat tiket yang Anda kirim
                                </li>
                                <li class="mb-2 d-flex align-items-center">
                                    <span class="dot me-2"></span>Status: Open/Pending/Scheduled/Closed
                                </li>
                            </ul>
                            <a href="{{ route('tickets.index') }}" class="btn btn-brand">Lihat Tiket</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-brand h-100">
                        <div class="card-body">
                            <h5 class="card-title d-flex align-items-center mb-3">
                                <span class="pill me-2">📅</span>Janji Pertemuan
                            </h5>
                            <ul class="list-unstyled mb-3">
                                <li class="mb-2 d-flex align-items-center">
                                    <span class="dot me-2"></span>Terima jadwal pertemuan dari admin
                                </li>
                                <li class="mb-2 d-flex align-items-center">
                                    <span class="dot me-2"></span>Detail waktu, lokasi, dan catatan
                                </li>
                            </ul>
                            <a href="{{ route('tickets.index') }}" class="btn btn-brand">Lihat Jadwal</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-brand h-100">
                        <div class="card-body">
                            <h5 class="card-title d-flex align-items-center mb-3">
                                <span class="pill me-2">📢</span>Pengumuman
                            </h5>
                            <ul class="list-unstyled mb-3">
                                <li class="mb-2 d-flex align-items-center">
                                    <span class="dot me-2"></span>Informasi pelayanan & pemeliharaan
                                </li>
                            </ul>
                            <a href="#" class="btn btn-brand">Lihat Semua</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-brand h-100">
                        <div class="card-body">
                            <h5 class="card-title d-flex align-items-center mb-3">
                                <span class="pill me-2">❓</span>Panduan & FAQ
                            </h5>
                            <ul class="list-unstyled mb-3">
                                <li class="mb-2 d-flex align-items-center">
                                    <span class="dot me-2"></span>Cara membuat dan memantau tiket
                                </li>
                            </ul>
                            <a href="#" class="btn btn-brand">Baca Panduan</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-brand h-100">
                        <div class="card-body">
                            <h5 class="card-title d-flex align-items-center mb-3">
                                <span class="pill me-2">🧑‍💼</span>Untuk Admin
                            </h5>
                            <ul class="list-unstyled mb-3">
                                <li class="mb-2 d-flex align-items-center">
                                    <span class="dot me-2"></span>Kelola tiket dan jadwalkan pertemuan
                                </li>
                            </ul>
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <a href="{{ route('admin.tickets.index') }}" class="btn btn-brand">Panel Admin</a>
                            @else
                                <span class="btn btn-secondary disabled">Khusus Admin</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Recent Tickets -->
        @php
            $recentTickets = auth()->check() ? \App\Models\Ticket::where('user_id', auth()->id())->latest()->limit(5)->get() : collect();
        @endphp
        @if(auth()->check())
        <section class="container mb-4">
            <div class="card card-brand">
                <div class="card-body">
                    <h5 class="card-title mb-3">Tiket Terbaru Anda</h5>
                    @if($recentTickets->isEmpty())
                        <p class="text-muted mb-0">Belum ada tiket. <a href="{{ route('tickets.create') }}" class="text-brand">Buat tiket sekarang</a>.</p>
                    @else
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Subjek</th>
                                    <th>Status</th>
                                    <th>Dibuat</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTickets as $t)
                                    <tr>
                                        <td>{{ $t->subject }}</td>
                                        <td><span class="badge bg-success-subtle text-brand">{{ ucfirst($t->status) }}</span></td>
                                        <td>{{ $t->created_at->format('d M Y H:i') }}</td>
                                        <td class="text-end"><a href="{{ route('tickets.show', $t) }}" class="text-brand text-decoration-none">Detail</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        @endif
    </main>

<!-- Footer -->
    <footer class="footer-brand text-white mt-5">
        <div class="container py-5">
        <div class="row g-4">
            <!-- Brand & Description -->
            <div class="col-lg-5">
            <div class="d-flex align-items-center mb-3">
                <span class="pill me-2">S</span>
                <strong class="fs-5">SITEPAT</strong>
            </div>
            <p class="mb-2 fw-semibold">Dinas Pendidikan Kota Prabumulih</p>
            <p class="small mb-2">Layanan E-Ticket Pendidikan untuk mempermudah pengaduan dan permohonan masyarakat secara cepat, transparan, dan terintegrasi.</p>
            <p class="small mb-2">Jl. Jenderal Sudirman No.1, Kota Prabumulih</p>
            <p class="small mb-0"> Telp: +62822 6981 0609</p>
            </div>
    
            <!-- Navigation Links -->
            <div class="col-lg-7">
            <div class="row g-4">
                <div class="col-6 col-md-4">
                <h6 class="text-light fw-semibold mb-3">LAYANAN</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('tickets.create') }}" class="text-white-50 text-decoration-none">Buat Tiket</a></li>
                    <li><a href="{{ route('tickets.index') }}" class="text-white-50 text-decoration-none">Tiket Saya</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">Panduan & FAQ</a></li>
                </ul>
                </div>
    
                <div class="col-6 col-md-4">
                <h6 class="text-light fw-semibold mb-3">INFORMASI</h6>
                <ul class="list-unstyled small">
                    <li><a href="#" class="text-white-50 text-decoration-none">Pengumuman</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">Kebijakan Privasi</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">Syarat & Ketentuan</a></li>
                </ul>
                </div>
    
                <div class="col-12 col-md-4">
                <h6 class="text-light fw-semibold mb-3">HUBUNGI KAMI</h6>
                <ul class="list-unstyled small">
        
                    <li><i class="bi bi-telephone me-2"></i> +62822 6981 0609</li>
                    <li><i class="bi bi-geo-alt me-2"></i> Kota Prabumulih</li>
                </ul>
                </div>
            </div>
            </div>
        </div>
    
        <hr class="border-light opacity-25 my-4">
    
        <div class="text-center small">
            <span>COPYRIGHT © 2026 — Dinas Pendidikan Kota Prabumulih</span><br>
            <span class="text-white-50">VERSI <strong>1.2</strong></span>
        </div>
        </div>
    </footer>
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>