# Rencana Fitur

> Dokumentasikan minimal **5 fitur utama** proyek Anda.
> Salin dan ulangi blok di bawah untuk setiap fitur tambahan.

---

## Fitur 1 — Autentikasi Pengguna & Manajemen Profil (Auth & User Profile)

**Role Penanggung Jawab:** `Frontend & Backend`

**Sumber Data:** `Internal System `

**Deskripsi & Ekspektasi:**
`Fitur ini memungkinkan pengguna (pelanggan dan admin) untuk mendaftarkan akun, masuk ke dalam sistem (Login), dan mengelola data profil mereka beserta data hewan peliharaan mereka.

Alur Kerja: Backend menyediakan API endpoint berbasis Laravel Sanctum untuk registrasi, login, dan logout. Frontend membuat form interaktif yang menangani validasi input, menyimpan token autentikasi dengan aman (misal via cookies/state), dan menampilkan halaman dashboard yang diproteksi sesuai role (Admin atau Pelanggan).
Ekspektasi: Pengguna dapat masuk ke akun mereka dengan aman, sistem dapat membedakan hak akses halaman antara Admin dan Pelanggan, serta pelanggan dapat menyimpan info dasar hewan mereka untuk mempermudah pemesanan di fitur lain.`

---

## Fitur 2 — Manajemen Produk & Layanan Petshop (Katalog & CRUD)

**Role Penanggung Jawab:** `Frontend & Backend`

**Sumber Data:** `Internal System`

**Deskripsi & Ekspektasi:**
`Fitur manajemen data (CRUD) untuk menampilkan katalog produk (makanan, aksesori) dan layanan (grooming, penitipan hewan) yang tersedia di petshop.

Alur Kerja: Admin dapat menambah, mengubah, atau menghapus data produk/layanan melalui panel admin di Frontend Next.js, yang kemudian datanya dikirim dan diproses oleh Backend Laravel ke database MySQL/PostgreSQL. Di sisi pelanggan, Frontend akan mengambil data tersebut dari API Backend untuk ditampilkan dalam bentuk katalog yang menarik, lengkap dengan fitur pencarian dan filter kategori.
Ekspektasi: Admin dapat mengelola stok produk dan jenis layanan secara real-time, sementara pelanggan dapat melihat informasi harga dan ketersediaan produk/layanan secara akurat.`

---

## Fitur 3 — Reservasi Layanan (Booking Grooming & Penitipan)

**Role Penanggung Jawab:** `Frontend & Backend`

**Sumber Data:** `Internal System`

**Deskripsi & Ekspektasi:**
`Fitur utama bagi pelanggan untuk melakukan pemesanan jadwal (booking) layanan grooming atau penitipan hewan secara online tanpa harus datang langsung terlebih dahulu.

Alur Kerja: Pelanggan memilih jenis layanan, memilih hewan peliharaan mereka yang sudah didaftarkan, lalu memilih tanggal dan slot waktu yang tersedia melalui kalender interaktif di Frontend. Data reservasi dikirim ke Backend, di mana Laravel akan memvalidasi apakah kuota slot pada tanggal tersebut masih tersedia. Jika tersedia, status reservasi dibuat menjadi "Pending" menunggu pembayaran atau persetujuan admin. Admin juga akan menerima notifikasi di dashboard mereka untuk menyetujui atau menolak reservasi.
Ekspektasi: Proses booking menjadi teratur, mencegah terjadinya bentrok jadwal (overbooking) di petshop, dan memudahkan pelanggan memantau status reservasi mereka.`

---

## Fitur 4 — Integrasi Pembayaran Digital (Payment Gateway)

**Role Penanggung Jawab:** `Backend & Frontend`

**Sumber Data:** `[Internal System | Third-Party API — nama layanan]`

**Deskripsi & Ekspektasi:**
`Fitur yang memungkinkan pelanggan melakukan pembayaran otomatis untuk produk yang dibeli atau layanan yang di-booking menggunakan e-wallet (OVO, GoPay), transfer bank (VA), atau QRIS.

Alur Kerja: Saat pelanggan melakukan checkout, Backend Laravel akan berkomunikasi dengan API Midtrans/Xendit untuk membuat tautan pembayaran (snap token). Frontend menerima token tersebut dan menampilkan modul pembayaran aman di layar pengguna. Setelah pengguna membayar, pihak payment gateway akan mengirimkan webhook (notifikasi otomatis) ke Backend Laravel untuk mengubah status transaksi secara otomatis dari "Belum Dibayar" menjadi "Lunas".
Ekspektasi: Proses transaksi menjadi lebih profesional, otomatis, aman, dan meminimalisir pencatatan keuangan manual oleh admin petshop.`

---

## Fitur 5 — Otomatisasi Deployment & CI/CD Pipeline

**Role Penanggung Jawab:** `DevOps`

**Sumber Data:** `Internal System & Third-Party API — Github Actions & Docker Hub/VPS`

**Deskripsi & Ekspektasi:**
`Fitur infrastruktur untuk mengotomatiskan pengujian (*testing*), pembuatan *image* aplikasi, hingga peluncuran (*deployment*) kode terbaru baik dari Frontend maupun Backend ke server produksi (VPS / Cloud Hosting).

Alur Kerja: Setiap kali Backend (Dinna) atau Frontend (Arifa) melakukan push atau merge kode ke main branch di GitHub, GitHub Actions secara otomatis akan memicu workflow. Proses ini akan menjalankan pengujian kode, membungkus aplikasi ke dalam kontainer Docker, dan secara otomatis memperbarui aplikasi yang berjalan di server (VPS) tanpa mengganggu pengguna aktif (zero-downtime deployment).
Ekspektasi: Proses rilis fitur baru atau perbaikan bug menjadi sangat cepat, mengurangi risiko kesalahan konfigurasi manual di server, dan menjaga aplikasi tetap stabil dan sinkron antara tim developer.`

---



