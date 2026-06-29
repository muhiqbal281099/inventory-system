<?php
session_start();
if(!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$page_title = "Data Barang"; $active_menu = "items";
include 'views/layout/header.php'; include 'views/layout/sidebar.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Manajemen Barang</h4>
    <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#itemModal" onclick="resetItemForm()">
        <i class="ph-bold ph-plus"></i> Tambah Barang
    </button>
</div>

<div class="table-card">
    <div class="table-header flex-column flex-md-row gap-3">
        <div class="d-flex gap-2 w-100">
            <div class="input-group" style="max-width: 300px;">
                <span class="input-group-text bg-white border-end-0"><i class="ph ph-magnifying-glass"></i></span>
                <input type="text" class="form-control border-start-0" id="itemSearch" placeholder="Cari barang..." onkeyup="loadItems()">
            </div>
            <select class="form-select" id="categoryFilter" style="max-width: 200px;" onchange="loadItems()">
                <option value="">Semua Kategori</option>
            </select>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Gudang</th>
                    <th>Stok</th>
                    <th>Tgl Masuk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="items-body"></tbody>
        </table>
    </div>
</div>

<!-- ITEM MODAL -->
<div class="modal fade" id="itemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="itemModalLabel">Tambah Barang Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="itemForm">
                <input type="hidden" id="itemId">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Kode Barang</label>
                            <input type="text" class="form-control" id="kode_barang" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" id="kategori_id" required>
                                <option value="">Pilih Kategori</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gudang Penyimpanan</label>
                            <select class="form-select" id="warehouse_id" required>
                                <option value="">Pilih Gudang</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jumlah Stok</label>
                            <input type="number" class="form-control" id="stok" value="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Masuk</label>
                            <input type="date" class="form-control" id="tanggal_masuk" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let items = [];
    document.addEventListener('DOMContentLoaded', () => {
        loadOptions();
        loadItems();
    });

    async function loadOptions() {
        const [catsRes, warehousesRes] = await Promise.all([
            fetch('api/categories.php'),
            fetch('api/warehouses.php')
        ]);
        const cats = await catsRes.json();
        const warehouses = await warehousesRes.json();

        // Populate Categories
        let catHtml = '<option value="">Semua Kategori</option>';
        let catFormHtml = '<option value="">Pilih Kategori</option>';
        cats.forEach(c => {
            catHtml += `<option value="${c.id}">${c.nama_kategori}</option>`;
            catFormHtml += `<option value="${c.id}">${c.nama_kategori}</option>`;
        });
        document.getElementById('categoryFilter').innerHTML = catHtml;
        document.getElementById('kategori_id').innerHTML = catFormHtml;

        // Populate Warehouses
        let whHtml = '<option value="">Pilih Gudang</option>';
        warehouses.forEach(w => {
            whHtml += `<option value="${w.id}">${w.nama_gudang}</option>`;
        });
        document.getElementById('warehouse_id').innerHTML = whHtml;
    }

    async function loadItems() {
        const search = document.getElementById('itemSearch').value;
        const cat = document.getElementById('categoryFilter').value;
        const res = await fetch(`api/items.php?search=${search}&category=${cat}`);
        items = await res.json();
        renderItems();
    }

    function renderItems() {
        const tbody = document.getElementById('items-body');
        let html = '';
        items.forEach(item => {
            html += `<tr>
                <td><span class="fw-bold text-primary">${item.kode_barang}</span></td>
                <td>${item.nama_barang}</td>
                <td><span class="badge-kategori">${item.nama_kategori || 'N/A'}</span></td>
                <td><small class="text-muted"><i class="ph ph-factory me-1"></i>${item.nama_gudang || '-'}</small></td>
                <td><span class="fw-bold ${item.stok < 10 ? 'text-danger' : ''}">${item.stok}</span></td>
                <td>${item.tanggal_masuk}</td>
                <td>
                    <button class="btn btn-action btn-light" onclick="editItem(${item.id})"><i class="ph ph-pencil"></i></button>
                    <button class="btn btn-action btn-light text-danger" onclick="deleteItem(${item.id})"><i class="ph ph-trash"></i></button>
                </td>
            </tr>`;
        });
        tbody.innerHTML = html || '<tr><td colspan="7" class="text-center py-4">Tidak ada data</td></tr>';
    }

    document.getElementById('itemForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('itemId').value;
        const data = {
            id,
            kode_barang: document.getElementById('kode_barang').value,
            nama_barang: document.getElementById('nama_barang').value,
            kategori_id: document.getElementById('kategori_id').value,
            warehouse_id: document.getElementById('warehouse_id').value,
            stok: document.getElementById('stok').value,
            tanggal_masuk: document.getElementById('tanggal_masuk').value
        };
        const method = id ? 'PUT' : 'POST';
        const res = await fetch('api/items.php', {
            method,
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data)
        });
        if(res.ok) {
            bootstrap.Modal.getInstance(document.getElementById('itemModal')).hide();
            Swal.fire('Berhasil', 'Data barang disimpan', 'success');
            loadItems();
        }
    });

    function resetItemForm() {
        document.getElementById('itemForm').reset();
        document.getElementById('itemId').value = '';
    }

    function editItem(id) {
        const item = items.find(i => i.id == id);
        document.getElementById('itemId').value = item.id;
        document.getElementById('kode_barang').value = item.kode_barang;
        document.getElementById('nama_barang').value = item.nama_barang;
        document.getElementById('kategori_id').value = item.kategori_id;
        document.getElementById('warehouse_id').value = item.warehouse_id;
        document.getElementById('stok').value = item.stok;
        document.getElementById('tanggal_masuk').value = item.tanggal_masuk;
        new bootstrap.Modal(document.getElementById('itemModal')).show();
    }

    async function deleteItem(id) {
        const result = await Swal.fire({title:'Hapus?', icon:'warning', showCancelButton:true});
        if(result.isConfirmed) {
            await fetch(`api/items.php?id=${id}`, {method:'DELETE'});
            loadItems();
        }
    }
</script>

<?php include 'views/layout/footer.php'; ?>
