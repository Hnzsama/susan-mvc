# 🍲 Panduan Susan MVC (Versi Super Gampang & Bahasa Santai)
> **Untuk Pemula & Teman yang Baru Belajar:** Panduan praktis memahami cara kerja web PHP buatan sendiri tanpa pusing istilah rumit!

---

## 👶 1. Apa itu MVC? (Analogi Restoran Makanan)

Bayangkan aplikasi web ini seperti **Restoran Makanan**:

```text
 🧍‍♂️ Kamu (User/Browser)
        │ 1. Buka web (misal: klik menu /menu)
        ▼
 🗺️ Routes (Papan Petunjuk) ──► Menentukan siapa pelayan yang bertugas
        │ 2. Mengoper ke Pelayan
        ▼
 🤵 Controller (Pelayan) ─────► Menerima pesanan kamu
        │ 3. Minta data ke Koki
        ▼
 👨‍🍳 Model (Koki & Gudang) ───► Ambil bahan makanan dari Kulkas (Database)
        │ 4. Koki kasih data ke Pelayan
        ▼
 🍽️ View (Piring & Makanan) ──► Tampilan HTML/CSS cantik yang kamu lihat di layar!
```

1. **Routes (`routes/web.php`)** = **Papan Petunjuk Jalan**. Menentukan jika ada orang buka alamat `/katalog`, harus diarahkan ke Controller mana.
2. **Controller (`app/controllers/`)** = **Pelayan**. Menerima permintaan kamu, minta data ke Model, lalu menampilkan halamannya ke layar.
3. **Model (`app/models/`)** = **Koki & Database**. Tugasnya urusan ambil data, simpan data, ubah data, atau hapus data di database.
4. **View (`resources/views/`)** = **Tampilan Layar**. File HTML, CSS, dan Javascript yang dilihat oleh mata pengunjung.

---

## ⚡ 2. Cara Menyalakan Website (Cuma 1 Perintah!)

Buka Terminal di folder proyek `susan`, lalu ketik:

```bash
php susan dev
```

🎉 **Selesai!** 
- Buka browser kamu di alamat: **`http://localhost:8000`** (atau `http://127.0.0.1:8000`).
- **Fitur Keren:** Saat kamu ubah tulisan di file PHP, CSS, atau JS, halaman di browser akan otomatis refresh sendiri (*Live Reload*) tanpa perlu tekan F5 berulang-ulang!

---

## 📁 3. Di Mana Tempat Naruh File Saya?

Jangan bingung melihat banyak folder, kamu cukup tahu **4 folder penting** ini:

| Folder | Isinya Apa? | Contoh File |
| :--- | :--- | :--- |
| 🗺️ **`routes/`** | Daftar alamat URL website kamu | `web.php` |
| 🤵 **`app/controllers/`** | Logika yang ngatur halaman web | `HomeController.php`, `MenuController.php` |
| 👨‍🍳 **`app/models/`** | Penghubung ke tabel database | `Product.php`, `User.php` |
| 🍽️ **`resources/views/`** | Desain tampilan HTML & potongan halaman | `home/index.php`, `partials/navbar.php` |
| 🎨 **`resources/css/` & `js/`** | Styling CSS dan script Javascript | `app.css`, `app.js` |

---

## 🛠️ 4. Langkah Bikin Halaman Baru (Tutorial Langkah Demi Langkah)

Misalnya kita mau bikin halaman baru: **Daftar Minuman Segar (`/minuman`)**.

### Langkah 1: Daftarkan Alamat di Routes
Buka file `routes/web.php`, tambahkan di paling bawah:
```php
Route::get('/minuman', 'MinumanController@index');
```

### Langkah 2: Bikin Controller Otomatis
Buka terminal, ketik perintah sulap ini:
```bash
php susan make:controller Minuman
```
*File `app/controllers/MinumanController.php` langsung otomatis dibuatkan!*

Buka file tersebut dan isi fungsinya:
```php
<?php

class MinumanController extends Controller {
    public function index() {
        // Data yang mau dikirim ke tampilan
        $data['judul'] = 'Daftar Minuman Segar';
        $data['daftar_es'] = ['Es Teh Manis', 'Es Kopi Gula Aren', 'Es Cendol'];

        // Tampilkan ke view
        $this->view('minuman/index', $data);
    }
}
```

### Langkah 3: Bikin Tampilan (View)
Buat file baru di `resources/views/minuman/index.php`:
```php
<!DOCTYPE html>
<html>
<head>
    <title><?= $judul ?></title>
</head>
<body>
    <h1><?= $judul ?></h1>
    
    <ul>
        <?php foreach ($daftar_es as $es): ?>
            <li>🥤 <?= $es ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
```

Sekarang coba buka browser di **`http://localhost:8000/minuman`**. Halaman barumu sudah langsung muncul! ✨

---

## 🗄️ 5. Cara Mengambil & Mengelola Data Database (ORM & Relasi)

Kamu bisa menggunakan fitur **Active Record / Model ORM** yang simpel, sekaligus mendukung relasi database (1-to-1, 1-to-Many, Many-to-Many) maupun Raw SQL JOIN:

### A. Operasi Dasar CRUD (Model ORM)
```php
// 1. Ambil SEMUA data produk
$semuaProduk = Product::all();

// 2. Cari data berdasarkan ID nomor 1
$produk = Product::find(1);

// 3. Filter berdasarkan kolom tertentu
$laptop = Product::where('kategori', 'Laptop & PC');

// 4. Tambah data baru ke database
Product::create([
    'nama'     => 'Logitech MX Master 3S',
    'kategori' => 'Aksesoris',
    'harga'    => 1650000,
    'stok'     => 15
]);

// 5. Ubah data berdasarkan ID
Product::update(1, [
    'harga' => 37500000,
    'stok'  => 8
]);

// 6. Hapus data berdasarkan ID
Product::delete(1);
```

### B. Relasi Database (1-to-1, 1-to-Many, Many-to-Many)
```php
$productId = 1; // Contoh: MacBook Pro

// 1. ONE-TO-ONE (1 to 1): Ambil detail spesifikasi produk
$detail = Product::detail($productId);
echo $detail['spesifikasi']; // "RAM 36GB, SSD 1TB..."

// 2. ONE-TO-MANY (1 to Many): Ambil semua ulasan/review pembeli
$reviews = Product::reviews($productId);
foreach ($reviews as $rev) {
    echo "{$rev['reviewer_name']} ({$rev['rating']}★): {$rev['komentar']}";
}

// 3. MANY-TO-MANY (N to M via tabel pivot `product_tag`): Ambil tags produk
$tags = Product::tags($productId);
foreach ($tags as $tag) {
    echo $tag['nama_tag']; // "Best Seller", "Produktivitas Kerja"
}

// 4. Custom SQL JOIN Lengkap (Raw SQL di Model)
$dataLengkap = Product::allWithDetails();
```

---

## 🧙‍♂️ 6. Kamus Perintah Ajaib (`php susan`)

Susan punya asisten CLI (Command Line) biar kamu gak capek bikin file manual:

| Perintah Terminal | Fungsinya Buat Apa? |
| :--- | :--- |
| `php susan dev` | 🚀 Menyalakan website + live reload otomatis saat ngoding. |
| `php susan serve` | 🌐 Menyalakan server PHP biasa tanpa live reload. |
| `php susan build` | 📦 Mengompres file CSS & JS biar siap di-upload ke hosting (cepat & ringan). |
| `php susan make:controller <Nama>` | 🤵 Bikin file Controller baru secara instan. |
| `php susan make:model <Nama>` | 👨‍🍳 Bikin file Model database baru secara instan. |
| `php susan make:migration <Nama>` | 📄 Bikin file skema tabel database baru. |
| `php susan migrate` | 🏗️ Membuat tabel-tabel di database secara otomatis. |
| `php susan migrate --seed` | 🏗️ Membuat tabel sekaligus mengisi data contoh awal. |
| `php susan db:seed` | 🌱 Mengisi database dengan data contoh (dummy data). |

---

## 🧩 7. Mantra & Helper Bermanfaat (Biar Kodingan Singkat)

Di dalam file tampilan (`.php`), kamu bisa pakai shortcut praktis ini:

### 1. `url('/alamat')`
Bikin link halaman secara otomatis:
```html
<a href="<?= url('/minuman') ?>">Lihat Menu Minuman</a>
```

### 2. `include_view('nama_folder/nama_file')`
Nyelipin potongan HTML (seperti Navbar atau Footer) biar gak copy-paste di banyak halaman:
```php
<?php include_view('partials/navbar'); ?>
```

### 3. `csrf_field()`
Wajib ditaruh di dalam setiap `<form>` biar formulir kamu aman dari hacker:
```html
<form action="<?= url('/order/kirim') ?>" method="POST">
  <?= csrf_field() ?>
  
  <input type="text" name="nama" placeholder="Nama kamu">
  <button type="submit">Kirim</button>
</form>
```

### 4. `formatRupiah(angka)`
Mengubah angka polos jadi format uang Rupiah yang rapi:
```php
<!-- Hasilnya: Rp 32.000 -->
<p>Harga: <?= formatRupiah(32000) ?></p>
```

### 5. `dd($variabel)`
*Dump and Die* — Buat ngecek isi variabel saat bingung error atau datanya apa:
```php
dd($semuaMenu); // Web akan berhenti dan menampilkan seluruh isi data
```

---

## ⚙️ 8. Pengaturan File `.env`

File `.env` adalah pusat setelan website kamu:

```env
# Nama Web Kamu
APP_NAME="NyamCenter"
APP_ENV=development

# Alamat Server Lokal Kamu
APP_URL="http://127.0.0.1:8000/"

# Database Default (Pakai SQLite praktis tanpa ribet setel database server)
DB_DRIVER=sqlite
DB_FILE="../database.sqlite"
```

---

*Selamat ngoding! Kalau ada yang bingung, tinggal buka kembali panduan ini kapan saja.* 😊
