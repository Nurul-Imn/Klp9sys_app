# API Specification

> Dokumentasikan setiap endpoint yang dikembangkan maupun yang dikonsumsi dari layanan eksternal.
> Salin dan ulangi blok di bawah untuk setiap endpoint tambahan.

---

## 1. User Login

**Method:** `POST`

**URL:** `api/v1/auth/login`

**Deskripsi:** `Digunakan oleh pelanggan atau admin untuk masuk ke sistem menggunakan email dan password. Endpoint ini akan mengembalikan bearer token (Laravel Sanctum) jika autentikasi berhasil.`

**Autentikasi Diperlukan:** `Tidak`

**Sumber:** `Internal System`

**Request Headers:**
```
Content-Type: application/json
```

**Request Body:**
```json
{
  "email": "string (email)",
  "password": "string"
}
```

**Response Sukses (`200 OK`):**
```json
{
  "status": "success",
  "message": "Login successful",
  "data": {
    "token": "1|xlKj9283hJasd... (Sanctum Token)",
    "user": {
      "id": 1,
      "name": "Arifa Nabila",
      "email": "arifa@example.com",
      "role": "customer"
    }
  }
}
```

**Response Gagal (`401 Unauthorized / 422 Unprocessable Entity`):**
```json
{
  "status": "error",
  "message": "These credentials do not match our records."
}
```

---

## 2. Get All Products & Services

**Method:** `GET`

**URL:** `/api/v1/products`

**Deskripsi:** `Mengambil daftar semua produk (makanan/aksesori) atau layanan (grooming/penitipan) yang tersedia di Petshop. Mendukung query parameter untuk pencarian atau filter kategori.`

**Autentikasi Diperlukan:** `Tidak`

**Sumber:** `Internal System`

**Request Headers:**
```
Content-Type: application/json
```

**Request Body:** `-`

**Response Sukses (`200 OK`):**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "name": "Cat Grooming Paket Lengkap",
      "category": "service",
      "price": 85000,
      "stock": null,
      "description": "Memandikan kucing, potong kuku, dan pembersihan telinga."
    },
    {
      "id": 2,
      "name": "Premium Cat Food 1kg",
      "category": "product",
      "price": 120000,
      "stock": 15,
      "description": "Makanan kucing kaya nutrisi untuk bulu sehat."
    }
  ]
}
```

**Response Gagal (`500 Internal Server Error`):**
```json
{
  "status": "error",
  "message": "Failed to fetch products data."
}
```

---

## 3. Create Reservation (Booking)

**Method:** `POST`

**URL:** `/api/v1/reservations`

**Deskripsi:** `Digunakan oleh pelanggan untuk memesan/booking jadwal layanan grooming atau penitipan hewan.`

**Autentikasi Diperlukan:** `Ya`

**Sumber:** `Internal System`

**Request Headers:**
```
Authorization: Bearer <token>
Content-Type: application/json
```

**Request Body:**
```json
{
  "service_id": "integer",
  "pet_name": "string",
  "reservation_date": "string (YYYY-MM-DD)",
  "notes": "string (optional)"
}
```

**Response Sukses (`201 Created`):**
```json
{
  "status": "success",
  "message": "Reservation created successfully",
  "data": {
    "reservation_id": "RES-20260605-001",
    "pet_name": "Milo",
    "reservation_date": "2026-06-10",
    "total_price": 85000,
    "payment_status": "pending"
  }
}
```

**Response Gagal (`400 Bad Request / 422 Unprocessable Entity`):**
```json
{
  "status": "error",
  "message": "The selected date slot is fully booked."
}
```

---

## 4. Request Payment Token (Midtrans Snap)

**Method:** `POST`

**URL:** `/api/v1/payments/charge`

**Deskripsi:** `Meminta token pembayaran resmi ke pihak Payment Gateway (Midtrans) berdasarkan total biaya transaksi/reservasi dari sistem Petshop. Token ini nantinya dipakai Frontend untuk memunculkan pop-up pembayaran.`

**Autentikasi Diperlukan:** `Ya`

**Sumber:** `Third-Party API — Midtrans`

**Request Headers:**
```
Authorization: Bearer <token>
Content-Type: application/json
```

**Request Body:**
```json
{
  "reservation_id": "string",
  "amount": "integer"
}
```

**Response Sukses (`200 OK`):**
```json
{
  "status": "success",
  "data": {
    "snap_token": "4691c28c-bfd5-45a8-bf2b-e4359... (Midtrans Token)",
    "redirect_url": "[https://app.sandbox.midtrans.com/snap/v2/vtweb/4691c28c](https://app.sandbox.midtrans.com/snap/v2/vtweb/4691c28c)..."
  }
}
```

**Response Gagal (`500 Internal Server Error`):**
```json
{
  "status": "error",
  "message": "Midtrans API Connection Error."
}
```

---

## 5. Payment Webhook Notification

**Method:** `POST`

**URL:** `/api/v1/payments/webhook`

**Deskripsi:** `Endpoint khusus (URL Callback) yang akan dipanggil secara otomatis oleh sistem Midtrans ke server Backend Laravel ketika pelanggan menyelesaikan pembayaran untuk mengubah status transaksi secara real-time.`

**Autentikasi Diperlukan:** `Tidak (Menggunakan sistem verifikasi signature key dari Midtrans)`

**Sumber:** `Third-Party API — Midtrans`

**Request Headers:**
```
Content-Type: application/json
```

**Request Body:**
```json
{
  "order_id": "RES-20260605-001",
  "transaction_status": "settlement",
  "payment_type": "qris",
  "gross_amount": "85000.00",
  "signature_key": "abc123xyz... (dikirim Midtrans untuk validasi)"
}
```

**Response Sukses (`200 OK`):**
```json
{
  "status": "success",
  "message": "Payment status updated to success"
}
```

**Response Gagal (`400 Bad Request`):**
```json
{
  "status": "error",
  "message": "Invalid signature key."
}
```

---


