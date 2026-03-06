
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPuBu — Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
/* 
    SiPuBu - Sistem Informasi Perpustakaan Buku Digital
    Praktikum 4 - Application Programming Interface (API)
    PHP OOP + REST API + PDO

    Dibuat oleh:
    Nama  : Farid Dhiya Fairuz
    NIM   : 247006111058
    Kelas : B

    Deskripsi:
    Aplikasi perpustakaan digital sederhana yang memungkinkan pengguna untuk mencari, meminjam, dan mengelola koleksi buku secara online.
*/
        :root {
            --green: #16a34a; --green-dark: #15803d; --green-deep: #166534;
            --green-light: #dcfce7; --green-border: #bbf7d0;
            --bg: #f0fdf4; --card: #ffffff; --text: #1e293b; --muted: #64748b;
        }
        * { box-sizing: border-box; }
        body { background: var(--bg); font-family: 'Segoe UI', sans-serif; color: var(--text); }

        /* NAVBAR */
        .navbar { background: linear-gradient(135deg, var(--green-dark), var(--green-deep)); box-shadow: 0 4px 20px rgba(21,128,61,.3); }
        .navbar-brand { font-weight: 800; font-size: 1.5rem; color: white !important; letter-spacing: -0.5px; }
        .nav-link { color: rgba(255,255,255,.8) !important; font-weight: 500; transition: color .2s; }
        .nav-link:hover, .nav-link.active { color: #fff !important; }
        .nav-user { color: #bbf7d0; font-size: .85rem; }

        /* HERO */
        .hero { background: linear-gradient(135deg, var(--green-deep) 0%, var(--green-dark) 50%, #0f766e 100%); color: white; padding: 3.5rem 0 2.5rem; margin-bottom: 2rem; }
        .hero h1 { font-size: 2.4rem; font-weight: 800; }
        .hero p { color: #bbf7d0; font-size: 1.05rem; }
        .search-hero { max-width: 520px; }
        .search-hero input { border-radius: 30px 0 0 30px; border: none; padding: .75rem 1.2rem; font-size: 1rem; }
        .search-hero button { border-radius: 0 30px 30px 0; background: #f59e0b; border: none; color: white; padding: .75rem 1.5rem; font-weight: 700; }
        .search-hero button:hover { background: #d97706; }

        /* STATS BAR */
        .stats-bar { background: white; border-bottom: 1px solid var(--green-border); padding: .8rem 0; }
        .stat-item { text-align: center; padding: 0 1.5rem; border-right: 1px solid var(--green-border); }
        .stat-item:last-child { border-right: none; }
        .stat-num { font-size: 1.4rem; font-weight: 700; color: var(--green-dark); }
        .stat-lbl { font-size: .75rem; color: var(--muted); text-transform: uppercase; letter-spacing: .5px; }

        /* BOOK CARD (steam-style) */
        .section-title { font-weight: 700; font-size: 1.2rem; color: var(--green-deep); border-left: 4px solid var(--green); padding-left: .75rem; margin-bottom: 1.2rem; }
        .book-card { background: white; border-radius: 14px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.07); border: 1px solid var(--green-border); transition: transform .2s, box-shadow .2s; height: 100%; display: flex; flex-direction: column; }
        .book-card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(21,128,61,.15); }
        .book-cover { width: 100%; height: 220px; object-fit: cover; background: linear-gradient(135deg, #bbf7d0, #6ee7b7); display: flex; align-items: center; justify-content: center; font-size: 4rem; color: var(--green-dark); flex-shrink: 0; }
        .book-cover img { width: 100%; height: 220px; object-fit: cover; }
        .book-body { padding: 1rem; flex: 1; display: flex; flex-direction: column; }
        .book-title { font-weight: 700; font-size: .95rem; color: var(--text); margin-bottom: .2rem; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .book-author { font-size: .82rem; color: var(--muted); margin-bottom: .5rem; }
        .badge-kat { background: var(--green-light); color: var(--green-deep); padding: 2px 9px; border-radius: 20px; font-size: .75rem; font-weight: 600; }
        .book-stok { font-size: .82rem; margin-top: auto; padding-top: .6rem; }
        .stok-ok { color: var(--green); } .stok-low { color: #d97706; } .stok-zero { color: #dc2626; }
        .btn-pinjam { background: linear-gradient(135deg, var(--green), var(--green-dark)); color: white; border: none; border-radius: 8px; width: 100%; padding: .5rem; font-weight: 600; font-size: .88rem; margin-top: .6rem; transition: all .2s; }
        .btn-pinjam:hover { background: linear-gradient(135deg, var(--green-dark), var(--green-deep)); color: white; }
        .btn-pinjam:disabled { background: #94a3b8; cursor: not-allowed; }

        /* MODAL */
        .modal-header { background: linear-gradient(135deg, var(--green-dark), var(--green-deep)); color: white; }
        .modal-header .btn-close { filter: invert(1); }
        .modal-detail-cover { width: 160px; height: 220px; object-fit: cover; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,.2); flex-shrink: 0; }
        .modal-detail-cover-placeholder { width: 160px; height: 220px; border-radius: 10px; background: linear-gradient(135deg, var(--green-light), #6ee7b7); display: flex; align-items: center; justify-content: center; font-size: 4rem; color: var(--green-dark); flex-shrink: 0; }
        .form-control:focus, .form-select:focus { border-color: var(--green); box-shadow: 0 0 0 4px rgba(22,163,74,.12); }

        /* PEMINJAMAN TABLE */
        .table th { background: var(--green-light); color: var(--green-deep); font-size: .82rem; text-transform: uppercase; }
        .badge-dipinjam { background: #fef3c7; color: #92400e; padding: 3px 10px; border-radius: 20px; font-size: .78rem; font-weight: 600; }
        .badge-kembali  { background: var(--green-light); color: var(--green-deep); padding: 3px 10px; border-radius: 20px; font-size: .78rem; font-weight: 600; }

        /* TABS */
        .nav-tabs .nav-link { color: var(--muted); border: none; font-weight: 600; padding: .75rem 1.2rem; }
        .nav-tabs .nav-link.active { color: var(--green-dark); border-bottom: 3px solid var(--green); background: transparent; }

        /* ADMIN PANEL */
        .admin-card { background: white; border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,.07); border: 1px solid var(--green-border); overflow: hidden; }
        .admin-card-head { background: linear-gradient(135deg, var(--green-dark), var(--green-deep)); color: white; padding: 1rem 1.5rem; font-weight: 700; }
        .btn-green { background: var(--green); color: white; border: none; border-radius: 8px; font-weight: 600; }
        .btn-green:hover { background: var(--green-dark); color: white; }

        /* FOOTER */
        footer { background: var(--green-deep); color: #bbf7d0; padding: 2rem 0 1rem; margin-top: 4rem; }
        footer h6 { color: white; font-weight: 700; }
        footer .text-small { font-size: .83rem; }
        .footer-divider { border-color: rgba(255,255,255,.1); }

        /* ALERTS */
        #toast-container { position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 9999; }
        .toast-msg { background: white; border-radius: 12px; padding: .8rem 1.2rem; box-shadow: 0 4px 20px rgba(0,0,0,.15); margin-top: .5rem; border-left: 4px solid var(--green); font-size: .9rem; animation: slideIn .3s ease; }
        .toast-msg.error { border-left-color: #dc2626; }
        @keyframes slideIn { from { opacity:0; transform: translateX(40px); } to { opacity:1; transform: translateX(0); } }

        .loading { text-align: center; padding: 3rem; color: var(--muted); }
        .empty-state { text-align: center; padding: 4rem 2rem; color: var(--muted); }
        .empty-state i { font-size: 3.5rem; opacity: .25; margin-bottom: 1rem; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fas fa-book-open me-2"></i>SiPuBu
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <i class="fas fa-bars text-white"></i>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto ms-3">
                <li class="nav-item"><a class="nav-link active" href="#" onclick="showTab('katalog')"><i class="fas fa-th me-1"></i>Katalog</a></li>
                <li class="nav-item"><a class="nav-link" href="#" onclick="showTab('peminjaman')"><i class="fas fa-bookmark me-1"></i>Peminjaman</a></li>
                <li class="nav-item"><a class="nav-link" href="#" onclick="showTab('admin')"><i class="fas fa-cog me-1"></i>Admin</a></li>
            </ul>
            <div class="nav-user">
                <i class="fas fa-user-circle me-1"></i>
                <strong>Farid Dhiya Fairuz</strong> &nbsp;|&nbsp; 247006111058 &nbsp;|&nbsp; Kelas B
            </div>
        </div>
    </div>
</nav>

<!-- HERO -->
<div class="hero" id="heroSection">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1><i class="fas fa-book-open me-3"></i>Perpustakaan Digital</h1>
                <p class="mb-3">Temukan, pinjam, dan nikmati ribuan koleksi buku terbaik kami. Mudah, cepat, dan gratis!</p>
                <div class="d-flex search-hero">
                    <input type="text" id="heroSearch" placeholder="Cari judul, pengarang, kategori..." class="form-control">
                    <button onclick="doSearch()"><i class="fas fa-search me-1"></i>Cari</button>
                </div>
            </div>
            <div class="col-lg-5 text-end d-none d-lg-block">
                <i class="fas fa-book-reader" style="font-size:8rem;opacity:.2;color:white;"></i>
            </div>
        </div>
    </div>
</div>

<!-- STATS BAR -->
<div class="stats-bar">
    <div class="container">
        <div class="d-flex justify-content-center flex-wrap">
            <div class="stat-item"><div class="stat-num" id="statBuku">-</div><div class="stat-lbl">Judul Buku</div></div>
            <div class="stat-item"><div class="stat-num" id="statKategori">-</div><div class="stat-lbl">Kategori</div></div>
            <div class="stat-item"><div class="stat-num" id="statStok">-</div><div class="stat-lbl">Total Stok</div></div>
            <div class="stat-item"><div class="stat-num" id="statPinjam">-</div><div class="stat-lbl">Sedang Dipinjam</div></div>
        </div>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="container py-4">

    <!-- TAB: KATALOG -->
    <div id="tab-katalog">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div class="section-title mb-0"><i class="fas fa-th-large me-2"></i>Katalog Buku</div>
            <div class="d-flex gap-2 align-items-center">
                <select id="filterKategori" class="form-select form-select-sm" style="width:160px;" onchange="filterByKategori()">
                    <option value="">Semua Kategori</option>
                </select>
                <span class="text-muted small" id="jumlahHasil"></span>
            </div>
        </div>
        <div class="row g-3" id="bukuGrid">
            <div class="col-12 loading"><i class="fas fa-spinner fa-spin fa-2x mb-2 d-block"></i>Memuat koleksi buku...</div>
        </div>
    </div>

    <!-- TAB: PEMINJAMAN -->
    <div id="tab-peminjaman" style="display:none;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="section-title mb-0"><i class="fas fa-bookmark me-2"></i>Data Peminjaman</div>
            <button class="btn btn-green btn-sm px-3" onclick="loadPeminjaman()">
                <i class="fas fa-sync me-1"></i>Refresh
            </button>
        </div>
        <div class="admin-card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>#</th><th>Peminjam</th><th>Judul Buku</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th><th>Aksi</th></tr></thead>
                    <tbody id="peminjamanTable"><tr><td colspan="7" class="text-center py-4 text-muted">Klik Refresh untuk memuat data</td></tr></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB: ADMIN -->
    <div id="tab-admin" style="display:none;">
        <div class="section-title"><i class="fas fa-cog me-2"></i>Panel Admin — Kelola Buku</div>
        <div class="row g-4">
            <!-- Form Tambah Buku -->
            <div class="col-lg-5">
                <div class="admin-card">
                    <div class="admin-card-head"><i class="fas fa-plus-circle me-2"></i>Tambah Buku Baru</div>
                    <div class="p-4">
                        <div class="mb-2">
                            <label class="form-label fw-semibold small">ISBN</label>
                            <input type="text" id="add_isbn" class="form-control form-control-sm" placeholder="978-xxx-xxx">
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-semibold small">Judul Buku</label>
                            <input type="text" id="add_judul" class="form-control form-control-sm" placeholder="Judul buku">
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-semibold small">Pengarang</label>
                            <input type="text" id="add_pengarang" class="form-control form-control-sm" placeholder="Nama pengarang">
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-semibold small">Kategori</label>
                            <select id="add_kategori" class="form-select form-select-sm">
                                <option value="">-- Pilih --</option>
                                <option>Fiksi</option><option>Non-Fiksi</option><option>Sains & Teknologi</option>
                                <option>Sejarah</option><option>Biografi</option><option>Pendidikan</option>
                                <option>Agama</option><option>Kesehatan</option><option>Ekonomi</option><option>Seni & Budaya</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-2">
                                <label class="form-label fw-semibold small">Tahun Terbit</label>
                                <input type="number" id="add_tahun" class="form-control form-control-sm" placeholder="2024" min="1900" max="2030">
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label fw-semibold small">Stok</label>
                                <input type="number" id="add_stok" class="form-control form-control-sm" value="1" min="0">
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-semibold small">URL Cover (opsional)</label>
                            <input type="text" id="add_cover" class="form-control form-control-sm" placeholder="https://...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Deskripsi (opsional)</label>
                            <textarea id="add_deskripsi" class="form-control form-control-sm" rows="2" placeholder="Sinopsis singkat..."></textarea>
                        </div>
                        <button class="btn btn-green w-100" onclick="tambahBuku()">
                            <i class="fas fa-save me-2"></i>Simpan Buku
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tabel daftar buku admin -->
            <div class="col-lg-7">
                <div class="admin-card">
                    <div class="admin-card-head d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-list me-2"></i>Daftar Buku</span>
                        <button class="btn btn-light btn-sm" onclick="loadBuku()"><i class="fas fa-sync me-1"></i></button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="font-size:.85rem;">
                            <thead><tr><th>Judul</th><th>Pengarang</th><th>Stok</th><th>Aksi</th></tr></thead>
                            <tbody id="adminTable"><tr><td colspan="4" class="text-center py-3 text-muted">Memuat...</td></tr></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL: DETAIL & PINJAM BUKU -->
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-book me-2"></i>Detail Buku</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex gap-4 flex-wrap">
                    <div id="modalCoverWrap"></div>
                    <div class="flex-fill">
                        <h4 class="fw-bold" id="modalJudul"></h4>
                        <p class="text-muted mb-1" id="modalPengarang"></p>
                        <div class="mb-2" id="modalKategori"></div>
                        <div class="d-flex gap-3 mb-3 flex-wrap">
                            <span><i class="fas fa-calendar text-success me-1"></i><span id="modalTahun"></span></span>
                            <span><i class="fas fa-barcode text-muted me-1"></i><span id="modalIsbn" class="font-monospace"></span></span>
                            <span id="modalStokBadge"></span>
                        </div>
                        <p class="text-muted small" id="modalDeskripsi"></p>
                        <hr>
                        <h6 class="fw-bold"><i class="fas fa-hand-holding-heart me-1 text-success"></i>Form Peminjaman</h6>
                        <input type="hidden" id="pinjamBukuId">
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Nama Peminjam</label>
                            <input type="text" id="pinjamNama" class="form-control form-control-sm" placeholder="Nama lengkap">
                        </div>
                        <div class="row">
                            <div class="col-6 mb-2">
                                <label class="form-label small fw-semibold">Tanggal Pinjam</label>
                                <input type="date" id="pinjamTglPinjam" class="form-control form-control-sm">
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label small fw-semibold">Tanggal Kembali</label>
                                <input type="date" id="pinjamTglKembali" class="form-control form-control-sm">
                            </div>
                        </div>
                        <button class="btn btn-green w-100 mt-1" id="btnPinjamSubmit" onclick="submitPinjam()">
                            <i class="fas fa-bookmark me-2"></i>Pinjam Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL: EDIT BUKU -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i>Edit Data Buku</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="edit_id">
                <div class="mb-2"><label class="form-label fw-semibold small">ISBN</label><input type="text" id="edit_isbn" class="form-control form-control-sm"></div>
                <div class="mb-2"><label class="form-label fw-semibold small">Judul</label><input type="text" id="edit_judul" class="form-control form-control-sm"></div>
                <div class="mb-2"><label class="form-label fw-semibold small">Pengarang</label><input type="text" id="edit_pengarang" class="form-control form-control-sm"></div>
                <div class="mb-2">
                    <label class="form-label fw-semibold small">Kategori</label>
                    <select id="edit_kategori" class="form-select form-select-sm">
                        <option>Fiksi</option><option>Non-Fiksi</option><option>Sains & Teknologi</option>
                        <option>Sejarah</option><option>Biografi</option><option>Pendidikan</option>
                        <option>Agama</option><option>Kesehatan</option><option>Ekonomi</option><option>Seni & Budaya</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-6 mb-2"><label class="form-label fw-semibold small">Tahun</label><input type="number" id="edit_tahun" class="form-control form-control-sm"></div>
                    <div class="col-6 mb-2"><label class="form-label fw-semibold small">Stok</label><input type="number" id="edit_stok" class="form-control form-control-sm"></div>
                </div>
                <div class="mb-2"><label class="form-label fw-semibold small">URL Cover</label><input type="text" id="edit_cover" class="form-control form-control-sm"></div>
                <div class="mb-3"><label class="form-label fw-semibold small">Deskripsi</label><textarea id="edit_deskripsi" class="form-control form-control-sm" rows="2"></textarea></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-warning btn-sm text-white fw-semibold" onclick="submitEdit()"><i class="fas fa-save me-1"></i>Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- TOAST CONTAINER -->
<div id="toast-container"></div>

<!-- FOOTER -->
<footer>
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-4 mb-3">
                <h6><i class="fas fa-book-open me-2"></i>SiPuBu</h6>
                <p class="text-small" style="color:#bbf7d0;">Sistem Informasi Perpustakaan Buku Digital. Nikmati ribuan koleksi buku pilihan.</p>
            </div>
            <div class="col-md-4 mb-3">
                <h6>Navigasi</h6>
                <ul class="list-unstyled text-small">
                    <li><a href="#" class="text-decoration-none" style="color:#bbf7d0;" onclick="showTab('katalog')">Katalog Buku</a></li>
                    <li><a href="#" class="text-decoration-none" style="color:#bbf7d0;" onclick="showTab('peminjaman')">Data Peminjaman</a></li>
                    <li><a href="#" class="text-decoration-none" style="color:#bbf7d0;" onclick="showTab('admin')">Panel Admin</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-3">
                <h6>Informasi</h6>
                <p class="text-small mb-1" style="color:#bbf7d0;"><i class="fas fa-user me-1"></i>Farid Dhiya Fairuz</p>
                <p class="text-small mb-1" style="color:#bbf7d0;"><i class="fas fa-id-card me-1"></i>247006111058</p>
                <p class="text-small mb-0" style="color:#bbf7d0;"><i class="fas fa-graduation-cap me-1"></i>Kelas B — Pemrograman Web</p>
            </div>
        </div>
        <hr class="footer-divider">
        <p class="text-center text-small mb-0" style="color:#86efac;">
            &copy; 2026 SiPuBu — Praktikum 4 Application Programming Interface (API) &nbsp;|&nbsp; PHP OOP + REST API + PDO
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ══════════════════════════════════════════════
// STATE
// ══════════════════════════════════════════════
const API_BASE = 'api';
let allBuku    = [];
let currentTab = 'katalog';

// ══════════════════════════════════════════════
// TOAST NOTIFICATION
// ══════════════════════════════════════════════
function toast(msg, isError = false) {
    const div = document.createElement('div');
    div.className = 'toast-msg' + (isError ? ' error' : '');
    div.innerHTML = `<i class="fas fa-${isError ? 'times-circle text-danger' : 'check-circle text-success'} me-2"></i>${msg}`;
    document.getElementById('toast-container').appendChild(div);
    setTimeout(() => div.remove(), 3500);
}

// ══════════════════════════════════════════════
// TAB NAVIGATION
// ══════════════════════════════════════════════
function showTab(tab) {
    ['katalog','peminjaman','admin'].forEach(t => {
        document.getElementById('tab-'+t).style.display = t === tab ? '' : 'none';
    });
    document.getElementById('heroSection').style.display = tab === 'katalog' ? '' : 'none';
    currentTab = tab;
    document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
    if (tab === 'peminjaman') loadPeminjaman();
    if (tab === 'admin') { loadBuku(); renderAdminTable(); }
}

// ══════════════════════════════════════════════
// LOAD & RENDER BUKU (KATALOG)
// ══════════════════════════════════════════════
async function loadBuku() {
    try {
        const res  = await fetch(`${API_BASE}/read.php`);
        const data = await res.json();
        allBuku = Array.isArray(data) ? data : [];
        renderKatalog(allBuku);
        updateStats();
        populateFilter();
        if (currentTab === 'admin') renderAdminTable();
    } catch (e) {
        document.getElementById('bukuGrid').innerHTML = `<div class="col-12 empty-state"><i class="fas fa-exclamation-triangle d-block"></i><p>Gagal memuat data. Pastikan server berjalan.</p></div>`;
    }
}

function renderKatalog(buku) {
    const grid = document.getElementById('bukuGrid');
    document.getElementById('jumlahHasil').textContent = buku.length + ' buku';
    if (!buku.length) {
        grid.innerHTML = `<div class="col-12 empty-state"><i class="fas fa-book-open d-block"></i><p>Tidak ada buku ditemukan.</p></div>`;
        return;
    }
    grid.innerHTML = buku.map(b => {
        const stokClass = b.stok > 5 ? 'stok-ok' : b.stok > 0 ? 'stok-low' : 'stok-zero';
        const stokLabel = b.stok > 0 ? `<i class="fas fa-circle me-1"></i>${b.stok} tersedia` : `<i class="fas fa-times-circle me-1"></i>Stok habis`;
        const cover = b.cover_url
            ? `<img src="${b.cover_url}" alt="${b.judul}" onerror="this.parentElement.innerHTML='<div class=\\'book-cover\\'><i class=\\'fas fa-book\\'></i></div>'">`
            : `<i class="fas fa-book"></i>`;
        return `
        <div class="col-6 col-md-4 col-lg-3">
            <div class="book-card" onclick="openDetail(${b.id})">
                <div class="book-cover">${b.cover_url ? `<img src="${b.cover_url}" alt="${b.judul}" onerror="this.style.display='none'">` : `<i class="fas fa-book"></i>`}</div>
                <div class="book-body">
                    <div class="book-title">${b.judul}</div>
                    <div class="book-author"><i class="fas fa-user-pen me-1"></i>${b.pengarang}</div>
                    <span class="badge-kat">${b.kategori}</span>
                    <div class="book-stok ${stokClass}">${stokLabel}</div>
                    <button class="btn-pinjam ${b.stok < 1 ? 'disabled' : ''}"
                        onclick="event.stopPropagation(); openDetail(${b.id})"
                        ${b.stok < 1 ? 'disabled' : ''}>
                        <i class="fas fa-bookmark me-1"></i>${b.stok < 1 ? 'Stok Habis' : 'Pinjam'}
                    </button>
                </div>
            </div>
        </div>`;
    }).join('');
}

function renderAdminTable() {
    const tbody = document.getElementById('adminTable');
    if (!allBuku.length) { tbody.innerHTML = '<tr><td colspan="4" class="text-center py-3 text-muted">Belum ada data</td></tr>'; return; }
    tbody.innerHTML = allBuku.map(b => `
        <tr>
            <td><strong>${b.judul}</strong><br><small class="text-muted">${b.isbn}</small></td>
            <td>${b.pengarang}</td>
            <td class="${b.stok > 0 ? 'text-success' : 'text-danger'} fw-bold">${b.stok}</td>
            <td>
                <button class="btn btn-warning btn-sm me-1 text-white" onclick="openEdit(${b.id})"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger btn-sm" onclick="hapusBuku(${b.id}, '${b.judul.replace(/'/g,"\\'")}')"><i class="fas fa-trash"></i></button>
            </td>
        </tr>`).join('');
}

// ══════════════════════════════════════════════
// FILTER & SEARCH
// ══════════════════════════════════════════════
function populateFilter() {
    const sel = document.getElementById('filterKategori');
    const cats = [...new Set(allBuku.map(b => b.kategori))].sort();
    sel.innerHTML = '<option value="">Semua Kategori</option>' + cats.map(c => `<option>${c}</option>`).join('');
}
function filterByKategori() {
    const val = document.getElementById('filterKategori').value;
    renderKatalog(val ? allBuku.filter(b => b.kategori === val) : allBuku);
}
function doSearch() {
    const q = document.getElementById('heroSearch').value.trim().toLowerCase();
    if (!q) { renderKatalog(allBuku); return; }
    renderKatalog(allBuku.filter(b =>
        b.judul.toLowerCase().includes(q) ||
        b.pengarang.toLowerCase().includes(q) ||
        b.kategori.toLowerCase().includes(q)
    ));
}
document.getElementById('heroSearch').addEventListener('keydown', e => { if (e.key === 'Enter') doSearch(); });

// ══════════════════════════════════════════════
// STATS
// ══════════════════════════════════════════════
function updateStats() {
    document.getElementById('statBuku').textContent     = allBuku.length;
    document.getElementById('statKategori').textContent = new Set(allBuku.map(b => b.kategori)).size;
    document.getElementById('statStok').textContent     = allBuku.reduce((s, b) => s + parseInt(b.stok), 0);
}

// ══════════════════════════════════════════════
// DETAIL MODAL
// ══════════════════════════════════════════════
function openDetail(id) {
    const b = allBuku.find(x => x.id == id);
    if (!b) return;
    document.getElementById('modalJudul').textContent    = b.judul;
    document.getElementById('modalPengarang').textContent = '✍️ ' + b.pengarang;
    document.getElementById('modalKategori').innerHTML   = `<span class="badge-kat">${b.kategori}</span>`;
    document.getElementById('modalTahun').textContent    = b.tahun_terbit;
    document.getElementById('modalIsbn').textContent     = b.isbn;
    document.getElementById('modalDeskripsi').textContent = b.deskripsi || 'Tidak ada deskripsi.';
    const stokClass = b.stok > 5 ? 'badge bg-success' : b.stok > 0 ? 'badge bg-warning text-dark' : 'badge bg-danger';
    document.getElementById('modalStokBadge').innerHTML = `<span class="${stokClass}">Stok: ${b.stok}</span>`;
    const coverWrap = document.getElementById('modalCoverWrap');
    coverWrap.innerHTML = b.cover_url
        ? `<img src="${b.cover_url}" class="modal-detail-cover" onerror="this.parentElement.innerHTML='<div class=\\'modal-detail-cover-placeholder\\'><i class=\\'fas fa-book\\'></i></div>'">`
        : `<div class="modal-detail-cover-placeholder"><i class="fas fa-book"></i></div>`;
    document.getElementById('pinjamBukuId').value = b.id;
    document.getElementById('pinjamNama').value   = '';
    const today = new Date().toISOString().split('T')[0];
    const ret   = new Date(); ret.setDate(ret.getDate() + 7);
    document.getElementById('pinjamTglPinjam').value   = today;
    document.getElementById('pinjamTglKembali').value  = ret.toISOString().split('T')[0];
    const btnPinjam = document.getElementById('btnPinjamSubmit');
    btnPinjam.disabled = b.stok < 1;
    btnPinjam.textContent = b.stok < 1 ? 'Stok Habis' : '📚 Pinjam Sekarang';
    new bootstrap.Modal(document.getElementById('modalDetail')).show();
}

// ══════════════════════════════════════════════
// TAMBAH BUKU (CREATE via API)
// ══════════════════════════════════════════════
async function tambahBuku() {
    const body = {
        isbn: document.getElementById('add_isbn').value.trim(),
        judul: document.getElementById('add_judul').value.trim(),
        pengarang: document.getElementById('add_pengarang').value.trim(),
        kategori: document.getElementById('add_kategori').value,
        tahun_terbit: document.getElementById('add_tahun').value,
        stok: parseInt(document.getElementById('add_stok').value) || 0,
        cover_url: document.getElementById('add_cover').value.trim(),
        deskripsi: document.getElementById('add_deskripsi').value.trim()
    };
    if (!body.isbn || !body.judul || !body.pengarang || !body.kategori || !body.tahun_terbit) {
        toast('Lengkapi field ISBN, Judul, Pengarang, Kategori, dan Tahun!', true); return;
    }
    try {
        const res  = await fetch(`${API_BASE}/create.php`, { method: 'POST', headers: {'Content-Type':'application/json'}, body: JSON.stringify(body) });
        const data = await res.json();
        if (res.ok) {
            toast(data.message);
            ['add_isbn','add_judul','add_pengarang','add_tahun','add_cover','add_deskripsi'].forEach(id => document.getElementById(id).value = '');
            document.getElementById('add_stok').value = '1';
            loadBuku();
        } else toast(data.message, true);
    } catch { toast('Gagal terhubung ke server.', true); }
}

// ══════════════════════════════════════════════
// EDIT BUKU (UPDATE via API)
// ══════════════════════════════════════════════
function openEdit(id) {
    const b = allBuku.find(x => x.id == id);
    if (!b) return;
    document.getElementById('edit_id').value        = b.id;
    document.getElementById('edit_isbn').value      = b.isbn;
    document.getElementById('edit_judul').value     = b.judul;
    document.getElementById('edit_pengarang').value = b.pengarang;
    document.getElementById('edit_kategori').value  = b.kategori;
    document.getElementById('edit_tahun').value     = b.tahun_terbit;
    document.getElementById('edit_stok').value      = b.stok;
    document.getElementById('edit_cover').value     = b.cover_url || '';
    document.getElementById('edit_deskripsi').value = b.deskripsi || '';
    new bootstrap.Modal(document.getElementById('modalEdit')).show();
}
async function submitEdit() {
    const body = {
        id: document.getElementById('edit_id').value,
        isbn: document.getElementById('edit_isbn').value.trim(),
        judul: document.getElementById('edit_judul').value.trim(),
        pengarang: document.getElementById('edit_pengarang').value.trim(),
        kategori: document.getElementById('edit_kategori').value,
        tahun_terbit: document.getElementById('edit_tahun').value,
        stok: parseInt(document.getElementById('edit_stok').value) || 0,
        cover_url: document.getElementById('edit_cover').value.trim(),
        deskripsi: document.getElementById('edit_deskripsi').value.trim()
    };
    try {
        const res  = await fetch(`${API_BASE}/update.php`, { method: 'PUT', headers: {'Content-Type':'application/json'}, body: JSON.stringify(body) });
        const data = await res.json();
        bootstrap.Modal.getInstance(document.getElementById('modalEdit')).hide();
        if (res.ok) { toast(data.message); loadBuku(); }
        else toast(data.message, true);
    } catch { toast('Gagal terhubung ke server.', true); }
}

// ══════════════════════════════════════════════
// HAPUS BUKU (DELETE via API)
// ══════════════════════════════════════════════
async function hapusBuku(id, judul) {
    if (!confirm(`Yakin hapus buku "${judul}"?`)) return;
    try {
        const res  = await fetch(`${API_BASE}/delete.php`, { method: 'DELETE', headers: {'Content-Type':'application/json'}, body: JSON.stringify({id}) });
        const data = await res.json();
        if (res.ok) { toast(data.message); loadBuku(); }
        else toast(data.message, true);
    } catch { toast('Gagal terhubung ke server.', true); }
}

// ══════════════════════════════════════════════
// PINJAM BUKU (CREATE PEMINJAMAN via API)
// ══════════════════════════════════════════════
async function submitPinjam() {
    const body = {
        buku_id: document.getElementById('pinjamBukuId').value,
        nama_peminjam: document.getElementById('pinjamNama').value.trim(),
        tanggal_pinjam: document.getElementById('pinjamTglPinjam').value,
        tanggal_kembali: document.getElementById('pinjamTglKembali').value
    };
    if (!body.nama_peminjam) { toast('Nama peminjam wajib diisi!', true); return; }
    if (!body.tanggal_pinjam || !body.tanggal_kembali) { toast('Tanggal pinjam dan kembali wajib diisi!', true); return; }
    try {
        const res  = await fetch(`${API_BASE}/peminjaman_create.php`, { method: 'POST', headers: {'Content-Type':'application/json'}, body: JSON.stringify(body) });
        const data = await res.json();
        bootstrap.Modal.getInstance(document.getElementById('modalDetail')).hide();
        if (res.ok) { toast(data.message); loadBuku(); }
        else toast(data.message, true);
    } catch { toast('Gagal terhubung ke server.', true); }
}

// ══════════════════════════════════════════════
// LOAD PEMINJAMAN
// ══════════════════════════════════════════════
async function loadPeminjaman() {
    const tbody = document.getElementById('peminjamanTable');
    tbody.innerHTML = '<tr><td colspan="7" class="text-center py-3"><i class="fas fa-spinner fa-spin me-2"></i>Memuat...</td></tr>';
    try {
        const res  = await fetch(`${API_BASE}/peminjaman_read.php`);
        const data = await res.json();
        if (!res.ok || !Array.isArray(data)) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted"><i class="fas fa-inbox d-block mb-2 opacity-25" style="font-size:2rem"></i>Belum ada data peminjaman</td></tr>';
            document.getElementById('statPinjam').textContent = 0;
            return;
        }
        const aktif = data.filter(d => d.status === 'dipinjam').length;
        document.getElementById('statPinjam').textContent = aktif;
        tbody.innerHTML = data.map((d, i) => `
            <tr>
                <td>${i+1}</td>
                <td><strong>${d.nama_peminjam}</strong></td>
                <td>${d.judul}<br><small class="text-muted">${d.pengarang}</small></td>
                <td>${d.tanggal_pinjam}</td>
                <td>${d.tanggal_kembali}</td>
                <td><span class="${d.status === 'dipinjam' ? 'badge-dipinjam' : 'badge-kembali'}">${d.status}</span></td>
                <td>
                    ${d.status === 'dipinjam'
                        ? `<button class="btn btn-success btn-sm" onclick="kembalikanBuku(${d.id})"><i class="fas fa-undo me-1"></i>Kembalikan</button>`
                        : `<span class="text-muted small">Selesai</span>`}
                </td>
            </tr>`).join('');
    } catch { tbody.innerHTML = '<tr><td colspan="7" class="text-center py-3 text-danger">Gagal memuat data.</td></tr>'; }
}

async function kembalikanBuku(id) {
    if (!confirm('Konfirmasi pengembalian buku ini?')) return;
    try {
        const res  = await fetch(`${API_BASE}/peminjaman_return.php`, { method: 'PUT', headers: {'Content-Type':'application/json'}, body: JSON.stringify({id}) });
        const data = await res.json();
        if (res.ok) { toast(data.message); loadPeminjaman(); loadBuku(); }
        else toast(data.message, true);
    } catch { toast('Gagal terhubung ke server.', true); }
}

// ══════════════════════════════════════════════
// INIT
// ══════════════════════════════════════════════
loadBuku();
</script>
</body>
</html>
