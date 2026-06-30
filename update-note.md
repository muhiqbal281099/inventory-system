# Rencana Pengembangan Inventory System (INV SYS)

Proyek sistem inventori ini memiliki landasan yang kuat dengan arsitektur MVC sederhana berbasis PHP. Berikut adalah beberapa hal yang bisa dikembangkan secara bertahap untuk menjadikannya sistem yang lebih profesional dan kaya fitur:

## Tahap 1: Peningkatan Fitur Dasar (Jangka Pendek)
Fokus pada perbaikan pengalaman pengguna dan fungsionalitas esensial.

1. **Role-Based Access Control (RBAC):**
   * Menambahkan tingkatan user seperti `Administrator`, `Manager`, dan `Staff Gudang`.
   * Membatasi akses menu atau aksi (seperti hapus data) khusus untuk Admin.

2. **Sistem Pagination dan Kolom Pencarian Lanjutan:**
   * Menerapkan pagination pada tabel *Barang*, *Kategori*, *Riwayat*, dan lainnya menggunakan datatables (Server-Side) agar ringan memuat data ribuan baris.
   * Filter rentang waktu (*Date Range*) pada data riwayat/pergerakan barang harian.

3. **Export & Import Data:**
   * Fitur download laporan dalam format **PDF/Excel/CSV** untuk operasional audit gudang.
   * Kemampuan Import (Bulk Upload) data barang baru dari spreadsheet (Excel/CSV) untuk pemasukan arsip lama secara massal.

## Tahap 2: Operasional Tingkat Lanjut (Jangka Menengah)
Fokus pada otomatisasi dan integrasi operasional.

1. **Barcode & QR Code System:**
   * Cetak label Barcode/QR code untuk tiap item atau rak barang.
   * Fitur `Scanner Integration` (bisa menggunakan kamera ponsel) untuk transfer/pencatatan barang keluar masuk agar minim kesalahan manual.

2. **Manajemen Supplier dan Purchase Order (PO):**
   * Mengintegrasikan data supplier.
   * Pencetakan surat jalan / nota faktur untuk barang keluar (Sales Order) dan barang masuk (Purchase Order).

3. **Multi-Warehouse & Transfer Approval:**
   * Pergerakan barang antar cabang gudang/toko harus melalui fase `Pending Approval` (menunggu konfirmasi dari gudang tujuan) yang memastikan riwayat perjalanan barang lebih transparan.

4. **Sistem Notifikasi Pintar:**
   * Pemberitahuan di sistem atau ke Chat/Email (Telegram Bot/Email SMTP) saat stok barang hampir habis atau pada batas *minimum stok*, serta deteksi _slow-moving_ items.

## Tahap 3: Optimasi & Ekosistem Digital (Jangka Panjang)
Fokus pada skalabilitas dan pelaporan prediktif.

1. **PWA (Progressive Web Application):**
   * Menjadikan web agar bisa di-install langsung layaknya aplikasi Native di Desktop & Smartphone, serta fitur *Offline Mode* sementara saat koneksi gudang tidak stabil.

2. **Analytics & Prediksi dengan AI:**
   * Dashboard _Advance_ yang bisa memprediksi estimasi stok habis berdasarkan rata-rata histori mutasi setiap bulannya.
   * Grafik yang bisa memperlihatkan perbandingan tren penjualan per departemen/kategori menggunakan _line chart_ tahunan.

3. **Audit Trails (Log Aktivitas Pengguna):**
   * Merekam setiap detail "Siapa, Melakukan Apa, Jam Berapa" pada database untuk setiap update/delete barang guna mempermudah investigasi/audit internal terhadap kehilangan barang. 

4. **Restful API Extensibility:**
   * Memisahkan logika backend sepenuhnya menjadi JSON API sebagai persiapan jika nantinya ingin dibangun aplikasi pendamping khusus iOS/Android menggunakan framework seperti Flutter atau React Native.
