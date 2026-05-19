<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile - SINANAS</title>
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
                    <strong>SINANAS</strong>
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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Profile Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 text-brand">
                            <i class="bi bi-person-circle me-2"></i>Informasi Profile
                        </h5>
                        <p class="mb-0 text-muted small">Update informasi profile dan alamat email Anda.</p>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor HP / WhatsApp</label>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                       value="{{ old('phone', $user->phone) }}"
                                       placeholder="08xxxxxxxx atau 628xxxxxxxx" required>
                                <div class="form-text">Digunakan untuk notifikasi jadwal pertemuan via WhatsApp.</div>
                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div class="alert alert-warning mt-2">
                                        <small>
                                            Email Anda belum terverifikasi.
                                            <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-link p-0 text-decoration-underline">
                                                    Klik di sini untuk mengirim ulang email verifikasi.
                                                </button>
                                            </form>
                                        </small>
                                    </div>

                                    @if (session('status') === 'verification-link-sent')
                                        <div class="alert alert-success mt-2">
                                            <small>Link verifikasi baru telah dikirim ke alamat email Anda.</small>
                                        </div>
                                    @endif
                                @endif
                            </div>

                            <div class="d-flex align-items-center gap-3">
                                <button type="submit" class="btn btn-brand">
                                    <i class="bi bi-save me-1"></i>Simpan
                                </button>

                                @if (session('status') === 'profile-updated')
                                    <span class="text-success small">
                                        <i class="bi bi-check-circle me-1"></i>Berhasil disimpan.
                                    </span>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Update Password -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 text-brand">
                            <i class="bi bi-shield-lock me-2"></i>Update Password
                        </h5>
                        <p class="mb-0 text-muted small">Pastikan akun Anda menggunakan password yang panjang dan acak untuk tetap aman.</p>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label for="update_password_current_password" class="form-label">Password Saat Ini</label>
                                <input type="password" class="form-control" id="update_password_current_password" name="current_password" autocomplete="current-password">
                                @error('current_password', 'updatePassword')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="update_password_password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="update_password_password" name="password" autocomplete="new-password">
                                @error('password', 'updatePassword')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="update_password_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="update_password_password_confirmation" name="password_confirmation" autocomplete="new-password">
                                @error('password_confirmation', 'updatePassword')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex align-items-center gap-3">
                                <button type="submit" class="btn btn-brand">
                                    <i class="bi bi-save me-1"></i>Simpan
                                </button>

                                @if (session('status') === 'password-updated')
                                    <span class="text-success small">
                                        <i class="bi bi-check-circle me-1"></i>Password berhasil diupdate.
                                    </span>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 text-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>Hapus Akun
                        </h5>
                        <p class="mb-0 text-muted small">Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen.</p>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            <i class="bi bi-trash me-1"></i>Hapus Akun
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Hapus Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus akun Anda? Setelah akun dihapus, semua sumber daya dan data akan dihapus secara permanen. Masukkan password Anda untuk mengkonfirmasi bahwa Anda ingin menghapus akun secara permanen.</p>
                    
                    <form method="post" action="{{ route('profile.destroy') }}" class="mt-3">
                        @csrf
                        @method('delete')

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            @error('password', 'userDeletion')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-1"></i>Hapus Akun
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
