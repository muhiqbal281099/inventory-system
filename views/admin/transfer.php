<?php

$page_title = "Kirim Barang ke Toko";
$active_menu = "transfer";
include 'views/layout/header.php';
include 'views/admin/sidebar.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="stat-card">
            <h4 class="fw-bold mb-4">Form Pengiriman Barang</h4>
            <form id="transferForm">
                <div class="mb-3">
                    <label class="form-label">Pilih Barang</label>
                    <select class="form-select" id="item_id" required>
                        <option value="">-- Pilih Barang --</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Toko Tujuan</label>
                    <select class="form-select" id="store_id" required>
                        <option value="">-- Pilih Toko --</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah Barang (QTY)</label>
                    <input type="number" class="form-control" id="qty" min="1" required>
                    <div id="stock-hint" class="form-text"></div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Keterangan Tambahan</label>
                    <textarea class="form-control" id="keterangan" rows="2" placeholder="Contoh: Stok bulanan rutin"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                    <i class="ph-bold ph-paper-plane-tilt me-2"></i> Kirim Barang Sekarang
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    let items = [];
    document.addEventListener('DOMContentLoaded', () => {
        fetchData();
    });

    async function fetchData() {
        const [itemsRes, storesRes] = await Promise.all([
            fetch('api/items.php'),
            fetch('api/stores.php')
        ]);
        
        items = await itemsRes.json();
        const stores = await storesRes.json();
        
        // Items select
        const itemSelect = document.getElementById('item_id');
        items.forEach(i => {
            itemSelect.innerHTML += `<option value="${i.id}">${i.nama_barang} (Stok: ${i.stok})</option>`;
        });

        // Stores select
        const storeSelect = document.getElementById('store_id');
        stores.forEach(s => {
            storeSelect.innerHTML += `<option value="${s.id}">${s.nama_toko}</option>`;
        });
    }

    document.getElementById('item_id').addEventListener('change', (e) => {
        const item = items.find(i => i.id == e.target.value);
        if(item) {
            document.getElementById('stock-hint').textContent = `Stok tersedia: ${item.stok}`;
            document.getElementById('qty').max = item.stok;
        }
    });

    document.getElementById('transferForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const item_id = document.getElementById('item_id').value;
        const store_id = document.getElementById('store_id').value;
        const qty = document.getElementById('qty').value;
        
        const item = items.find(i => i.id == item_id);
        if(parseInt(qty) > parseInt(item.stok)) {
            Swal.fire('Error', 'Stok tidak mencukupi!', 'error');
            return;
        }

        const data = {
            item_id,
            store_id,
            qty,
            store_name: document.getElementById('store_id').options[document.getElementById('store_id').selectedIndex].text
        };

        const res = await fetch('api/transfer.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data)
        });

        if(res.ok) {
            Swal.fire('Berhasil!', 'Barang telah dikirim ke toko.', 'success').then(() => {
                window.location.href = 'index.php?p=history';
            });
        } else {
            const err = await res.json();
            Swal.fire('Gagal', err.message || 'Error occurred', 'error');
        }
    });
</script>

<?php include 'views/layout/footer.php'; ?>
