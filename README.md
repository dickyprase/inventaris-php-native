# Aplikasi E-Inventaris - Sistem Informasi Stok Barang

## DESKRIPSI
Aplikasi berbasis web untuk mengelola inventaris barang, mencatat transaksi pembelian dan pengeluaran, serta manajemen stok secara efisien. Dilengkapi dengan fitur pelaporan dan tampilan responsif untuk perangkat mobile.

## REQUIREMENTS
1. Web Server (XAMPP / Apache / Nginx)
2. PHP versi 7.4 atau lebih baru (Rekomendasi PHP 8.x)
3. MySQL Database (MariaDB)
4. Web Browser modern (Google Chrome, Firefox, Edge, Safari)

## CARA INSTALASI
1. Pastikan XAMPP (Apache & MySQL) sudah terinstall dan berjalan.
2. Copy folder `inventaris` ke dalam direktori htdocs (biasanya `C:\xampp\htdocs\`).
3. Buat database baru di phpMyAdmin (`http://localhost/phpmyadmin`) dengan nama: `inventaris`.
4. Import file SQL yang ada di folder `db`:
   - `db/inventaris.sql`
5. Konfigurasi koneksi database jika perlu:
   - Buka file: `conf/config.php`
   - Sesuaikan `$host`, `$username`, `$password`, dan `$database` dengan setting lokal Anda.
   - Sesuaikan `$url` dengan alamat lokal project (misal: `http://localhost/inventaris/`).
6. Buka browser dan akses aplikasi:
   - `http://localhost/inventaris/`

## AKUN DEFAULT
Gunakan akun berikut untuk login pertama kali:

1. **LEVEL ADMIN (Akses Penuh)**
   - Username: `admin`
   - Password: `admin`

2. **LEVEL USER (Akses Terbatas)**
   - Username: `user`
   - Password: `123`

## FITUR UTAMA
1. **Dashboard Interaktif**
   - Ringkasan total produk, total aset, jumlah pembelian, dan pengeluaran.

2. **Master Data**
   - Manajemen Kategori Barang
   - Manajemen Data Barang (Stok & Harga)
   - Manajemen Supplier

3. **Transaksi**
   - Pembelian: Mencatat barang masuk dari supplier (menambah stok).
   - Pengeluaran: Mencatat barang keluar/terpakai (mengurangi stok).
   - Return: Mengelola pengembalian barang baik dari pembelian maupun pengeluaran.

4. **Laporan & History**
   - Rekapitulasi histori transaksi lengkap.
   - Tabel responsif dengan fitur pencarian dan sorting.

5. **Pengaturan Akun**
   - Manajemen pengguna aplikasi (Admin dapat menambah/mengedit user).

6. **Tampilan Mobile Friendly**
   - Bottom Navigation Bar untuk akses cepat di perangkat mobile.
   - Sidebar responsif untuk mode desktop.
   - Modal fullscreen untuk kenyamanan penggunaan di layar kecil.

---
**Dibuat dengan PHP Native & Bootstrap 5**
