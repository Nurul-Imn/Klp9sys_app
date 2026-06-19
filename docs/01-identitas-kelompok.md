# Identitas Kelompok

---

**Nama Kelompok:** `Klp9sys_app`

**Nama Proyek / Aplikasi:** `Petshop`

**Jumlah Anggota:** `3` orang

**Repositori:** `https://github.com/Nurul-Imn/Klp9sys_app.git'

---

## Anggota & Role

**Anggota 1**
- Nama Lengkap: `Nurul Iman`
- NIM: `230705160`
- Role: `DevOps`
- Teknologi: `github`

**Anggota 2**
- Nama Lengkap: `Dinna Muliana Diza`
- NIM: `230705155`
- Role: `Backend`
- Teknologi: `laravel`

**Anggota 3**
- Nama Lengkap: `Arifa Nabila`
- NIM: `230705129`
- Role: `Frontend`
- Teknologi: `Next.js`


---

## Stack Teknologi

**Frontend:** `Next.js`
*(Bebas, contoh: React, Vue, Next.js, Nuxt, Svelte)*

**Backend:** `Laravel` *(wajib)*
*(Versi dan pilihan database driver menyesuaikan kebutuhan kelompok)*

**DevOps / Infrastruktur:** `Github Actions`
*(Contoh: Docker, GitHub Actions, Nginx, Railway, VPS)*

---

## Arsitektur Aplikasi

*(Jelaskan secara singkat bagaimana aplikasi-aplikasi dalam proyek ini saling terhubung)*

**Aplikasi 1 — Frontend (Next.js)**
- Nama Aplikasi: `Petshop Client App`
- Deskripsi Singkat: `Aplikasi web publik dan panel admin yang diakses oleh pengguna/pelanggan petshop untuk melihat layanan, melakukan reservasi (grooming/penitipan), atau membeli produk hewan`
- Berkomunikasi dengan: `Aplikasi 2 - Backend (Laravel) - menggunakan API Request (mengirim token autentikasi dan menerima data dalam format JSON).`

**Aplikasi 2 — Backend (Laravel)**
- Nama Aplikasi / Service: `Petshop Core API`
- Deskripsi Singkat: Aplikasi server berbasis RESTful API yang berfungsi mengolah seluruh logika bisnis (business logic) dari sistem Petshop. Server ini bertugas menangani manajemen database, sistem autentikasi pengguna, pengolahan data transaksi/reservasi, serta menyediakan endpoint data yang aman untuk digunakan oleh aplikasi Frontend.
- Menyediakan layanan untuk: `Mengelola logika bisnis utama (autentikasi, manajemen stok, reservasi), berinteraksi langsung dengan database, dan menyediakan endpoint API yang aman untuk dikonsumsi oleh Frontend Next.js.`

---
