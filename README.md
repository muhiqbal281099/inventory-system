# Inventory System (INV SYS)

Sistem Informasi Manajemen Inventori dan Logistik berbasis web menggunakan **PHP Native (Arsitektur Restful API - MVC)** dan **MySQL**, dikembangkan dengan antarmuka modern dan responsif menggunakan ekosistem *Vanilla JS* dan *Bootstrap 5*.

Sistem ini mendukung pengelolaan multi-gudang, cetak barcode otomatis (JsBarcode), log pergerakan stok, peringatan stok cerdas via dashboard (*Smart Notifications*), serta alur fungsionalitas persetujuan mutasi stok (*Transfer Approval*). Seluruh modul *(Views)* telah dikelompokkan dan dikonfigurasi berdasarkan peran (Role-Based Access Control) yang sangat komprehensif.

## Cara Mengakses / Menjalankan Sistem web
Proyek ini dikembangkan agar siap digunakan pada lingkungan server *local* (XAMPP / Laragon dsb):
1. *Clone* atau pindahkan (copy/paste) direktori folder proyek ini ke dalam *document root* web server lokal Anda. Contohnya: `C:\laragon\www\` (untuk pengguna Laragon) atau `C:\xampp\htdocs\` (untuk pengguna XAMPP).
2. Nyalakan service **Apache** dan **MySQL** Anda.
3. Buat database baru di MySQL anda (bisa menggunakan phpMyAdmin atau console) dengan nama: `inventory_system`.
4. Lakukan Import file `database/schema.sql` ke dalam database `inventory_system` yang baru dibuat tersebut. File ini sudah berisi data *Dummy* untuk barang dan profil pengguna.
5. Pada *web browser* Anda, buka alamat tempat proyek dijalankan, misalnya: `http://localhost/uas_softdev/` dan login menggunakan akun yang tersedia di bawah.

## Data Login Sistem

Sistem dilengkapi mekanisme *Role-Based Access Control (RBAC)*. Seluruh tampilan menu dan kapabilitas *user* telah dipisah pada folder `views/admin`, `views/manager`, dan `views/staff` secara spesifik, sehingga aplikasi menjadi sangat aman dan fungsionalitasnya berjalan mandiri sesuai jabatannya.

| Role | Username | Password | Penjelasan Kekuasaan Menu |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin` | `password` | Super Admin. Memiliki kendali penuh seluruh menu. Dapat menambah, mengubah, melakukan hapus permanen, serta menyetujui log riwayat transfer. |
| **Manager** | `manager` | `password` | Pimpinan gudang. Mengakses dasbor, laporan data barang dan gudang (beberapa menu disempurnakan tanpa fitur kategori/hapus). Hak paling eksklusif adalah kemampuannya menyetujui mutasi transfer stok *(Approval)*. |
| **Staff Gudang** | `staff` | `password` | Operator lapangan. Tampilan sidebar sudah dibuat sangat sederhana. Ia hanya bisa melihat Dasbor, mencetak barcode Barang, mengirim transfer stok (menunggu persetujuan), dan melihat Riwayat Stok. |

## Panduan Mengunggah / Melihat Proses Git Repository
Karena pengembangan proyek dilakukan dengan integrasi *Version Control System (Git)*, Anda bisa mencatat *progress* atau mengunggah *(push)* pembaruan sistem ke Github yang sudah terkoneksi dengan urutan perintah berikut via **Terminal (CMD/Git Bash)**:

1. **Memeriksa Status Perubahan:**
   Cek daftar file apa saja yang telah ditambah/dimodifikasi:
   ```bash
   git status
   ```
2. **Menambahkan Seluruh File yang Berubah (Staging):**
   Tambahkan semua *file* ke indeks perekaman:
   ```bash
   git add .
   ```
3. **Merekam Data (Commit):**
   Simpan _checkpoint_ dengan memberikan pesan/keterangan pekerjaan apa yang baru saja dilakukan:
   ```bash
   git commit -m "Feat: tuliskan update fitur atau perbaikan disini"
   ```
4. **Mempublikasikan (Push) ke Github / Server Master:**
   Unggah pekerjaan secara daring ke *branch main*:
   ```bash
   git push --set-upstream origin main
   ```

---
*Developed by Muhammad Iqbal Fathur Rozi (2313020245).*
