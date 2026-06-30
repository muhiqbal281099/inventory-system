<?php

$page_title = "Data Barang"; $active_menu = "items";
include 'views/layout/header.php'; include 'views/staff/sidebar.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Manajemen Barang</h4>
    
</div>

<div class="table-card">
    <div class="table-header d-flex flex-column flex-md-row gap-3">
        <div class="d-flex w-100">
            <select class="form-select" id="categoryFilter" style="max-width: 250px;" onchange="loadItems()">
                <option value="">Semua Kategori</option>
            </select>
        </div>
    </div>
    <div class="table-responsive mt-3">
        <table id="itemsTable" class="table table-hover mb-0 w-100">
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

<!-- BARCODE MODAL -->
<div class="modal fade" id="barcodeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Label Barcode</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center" id="printableBarcode">
                <h6 id="barcodeItemName" class="fw-bold mb-2" style="font-size:0.85rem;"></h6>
                <svg id="barcodeCanvas"></svg>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-dark w-100" onclick="printBarcode()"><i class="ph-bold ph-printer me-2"></i> Print Barcode</button>
            </div>
        </div>
    </div>
</div>

<script>
    let items = [];
    let dataTableInst = null;
    let userRole = '<?php echo $_SESSION["role"] ?? "Staff Gudang"; ?>';

    document.addEventListener('DOMContentLoaded', () => {
        loadOptions();
        loadItems();
    });

    function showBarcode(id) {
        const item = items.find(i => i.id == id);
        document.getElementById('barcodeItemName').textContent = item.nama_barang;
        JsBarcode("#barcodeCanvas", item.kode_barang, {
            format: "CODE128",
            width: 2,
            height: 60,
            displayValue: true
        });
        new bootstrap.Modal(document.getElementById('barcodeModal')).show();
    }

    function printBarcode() {
        const printContent = document.getElementById('printableBarcode').innerHTML;
        const originalContent = document.body.innerHTML;
        document.body.innerHTML = `<div style="display:flex; justify-content:center; align-items:center; height:100vh;">
            <div style="text-align:center;">${printContent}</div>
        </div>`;
        window.print();
        document.body.innerHTML = originalContent;
        window.location.reload();
    }

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
        const cat = document.getElementById('categoryFilter').value;
        const res = await fetch(`api/items.php?category=${cat}`);
        items = await res.json();
        renderItems();
    }

    function renderItems() {
        if(dataTableInst) { dataTableInst.destroy(); }
        
        const tbody = document.getElementById('items-body');
        let html = '';
        items.forEach(item => {
            let deleteBtn = userRole === 'Administrator' ? 
                `<button class="btn btn-action btn-light text-danger" onclick="deleteItem(${item.id})"><i class="ph ph-trash"></i></button>` : '';

            html += `<tr>
                <td><span class="fw-bold text-primary">${item.kode_barang}</span></td>
                <td>${item.nama_barang}</td>
                <td><span class="badge-kategori">${item.nama_kategori || 'N/A'}</span></td>
                <td><small class="text-muted"><i class="ph ph-factory me-1"></i>${item.nama_gudang || '-'}</small></td>
                <td><span class="fw-bold ${item.stok < 10 ? 'text-danger' : ''}">${item.stok}</span></td>
                <td>${item.tanggal_masuk}</td>
                <td>
                    <button class="btn btn-action btn-light text-dark" title="Cetak Barcode" onclick="showBarcode(${item.id})"><i class="ph ph-barcode"></i></button>
                    
                    ${deleteBtn}
                </td>
            </tr>`;
        });
        tbody.innerHTML = html;
        
        dataTableInst = $('#itemsTable').DataTable({
            dom: '<"row align-items-center mb-3"<"col-md-6"B><"col-md-6"f>>rt<"row align-items-center mt-3"<"col-md-6"i><"col-md-6"p>>',
            buttons: [
                { extend: 'excel', className: 'btn btn-sm btn-success', text: '<i class="ph-bold ph-file-xls me-1"></i> Excel' },
                { extend: 'pdf', className: 'btn btn-sm btn-danger', text: '<i class="ph-bold ph-file-pdf me-1"></i> PDF' },
                { extend: 'print', className: 'btn btn-sm btn-info text-white', text: '<i class="ph-bold ph-printer me-1"></i> Print' }
            ],
            language: { search: "_INPUT_", searchPlaceholder: "Cari data..." },
            pageLength: 10
        });
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
