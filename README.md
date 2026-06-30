# Inventory System (INV SYS)

Sistem Informasi Manajemen Inventori dan Logistik berbasis web menggunakan **PHP Native (Arsitektur Restful API - MVC)** dan **MySQL**, dikembangkan dengan antarmuka yang sangat modern dan cepat menggunakan ekosistem *Vanilla JS* dan *Bootstrap 5*.

Sistem ini juga mendukung multi-gudang, cetak barcode barang otomatis, log pergerakan stok antar toko, integrasi peringatan cerdas via dashboard (Smart Notifications), serta fungsi persetujuan (Transfer Approval).

## Cara Mengakses / Menjalankan Sistem
Proyek ini dibuat dan siap digunakan pada lingkungan server *local* (XAMPP / Laragon dsb):
1. *Clone* atau pindahkan (copy/paste) direktori folder ini ke dalam *document root* web server Anda, seperti `C:\laragon\www\` (jika pakai Laragon) atau `C:\xampp\htdocs\` (jika pakai XAMPP).
2. Pastikan service modul **Apache** dan **MySQL** Anda sudah dihidupkan (Running).
3. Buat database kosong baru di MySQL/MariaDB anda dengan nama: `inventory_system`.
4. Lakukan Import atau _execute_ file skema SQL yang telah saya unggah di dalam: `database/schema.sql` ke dalam database `inventory_system` yang baru dibuat tadi (bisa melalui **phpMyAdmin**, HeidiSQL, ataupun terminal MySQL langsung).
5. Pada *web browser* Anda, buka alamat url tempat anda menaruh proyek ini. Misalnya: `http://localhost/uas_softdev/`.

## Data Login Akun (Berdasarkan Role)

Sistem ini memakai mekanisme keamanan operasional berbasis **Role-Based Access Control (RBAC)** untuk membedakan apa saja yang bisa dilihat dan dilakukan oleh *user* berdasarkan posisi/jabatannya. 

Berikut adalah ketiga data profil pengguna uji coba (yang telah terekam di dalam file _schema.sql_ dan bisa langsung digunakan):

| Role User | Username | Password | Deskripsi Hak Akses |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin` | `password` | Mengakses seluruh kendali penuh di web. Mampu melihat, menambah, mengubah, menyetujui riwayat, hingga **menghapus** data secara permanen. |
| **Manager** | `manager` | `password` | Mengakses dan melihat operasional gudang, menyortir/unduh laporan dan **menyetujui / menolak** perpindahan (transfer) stok gudang. Namun tidak dapat menekan opsi _Hapus_. |
| **Staff Gudang** | `staff` | `password` | Dapat login, mendaftarkan dan mengajukan form _Kirim Barang_. Namun tidak memiliki wewenang untuk menyetujui/menolak *transfer history* dan operasi hapus. |

> **Catatan Tambahan:**
> Setelah berhasil *login*, disarankan untuk menelusuri halaman Data Barang untuk melihat fitur `Print Barcode` dan Export laporan menjadi PDF/Excel, lalu cek menu History untuk praktik mutasi persetujuan barang!

---
*Developed by Muhammad Iqbal Fathur Rozi (2313020245).*
