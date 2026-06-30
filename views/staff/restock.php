<?php
$page_title = "Barang Masuk (Restock)";
$active_menu = "restock";
include 'views/layout/header.php';
include 'views/staff/sidebar.php';
?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="stat-card">
            <h4 class="fw-bold mb-4">Form Barang Masuk</h4>
            <div class="alert alert-info border-0 bg-info bg-opacity-10 text-info mb-4">
                <i class="ph-bold ph-info me-2"></i><strong>Aturan Sistem:</strong> Menambah stok melalui form ini adalah cara yang benar karena akan terekam ke dalam histori (Audit Log).
            </div>
            <form id="restockForm">
                <div class="mb-3">
                    <label class="form-label">Pilih Barang</label>
                    <select class="form-select" id="item_id" required>
                        <option value="">-- Pilih Barang --</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah Masuk (QTY)</label>
                    <input type="number" class="form-control" id="qty" min="1" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Sumber / Keterangan Ketersediaan</label>
                    <textarea class="form-control" id="keterangan" rows="2" placeholder="Contoh: Stok dari Supplier A"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                    <i class="ph-bold ph-download-simple me-2"></i> Tambah Ke Sistem Gudang
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const res = await fetch('api/items.php');
        const items = await res.json();
        const select = document.getElementById('item_id');
        items.forEach(i => {
            select.innerHTML += `<option value="${i.id}">${i.nama_barang} (Stok Saat ini: ${i.stok})</option>`;
        });
    });

    document.getElementById('restockForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const data = {
            item_id: document.getElementById('item_id').value,
            qty: document.getElementById('qty').value,
            keterangan: document.getElementById('keterangan').value || 'Penjumlahan Stok (Barang Masuk)'
        };

        const res = await fetch('api/restock.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data)
        });

        if(res.ok) {
            Swal.fire('Berhasil!', 'Stok barang masuk berhasil ditambahkan.', 'success').then(() => {
                window.location.href = 'index.php?p=history';
            });
        }
    });
</script>

<?php include 'views/layout/footer.php'; ?>