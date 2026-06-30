<?php

$page_title = "Data Gudang Penyimpanan";
$active_menu = "warehouses";
include 'views/layout/header.php';
include 'views/manager/sidebar.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Manajemen Gudang</h4>
    <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#warehouseModal" onclick="resetForm()">
        <i class="ph-bold ph-plus"></i> Tambah Gudang
    </button>
</div>

<div class="row" id="warehouses-list">
    <!-- Loaded via JS -->
</div>

<!-- WAREHOUSE MODAL -->
<div class="modal fade" id="warehouseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalTitle">Tambah Gudang Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="warehouseForm">
                <input type="hidden" id="warehouseId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Gudang</label>
                        <input type="text" class="form-control" id="nama_gudang" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Simpan Gudang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let warehouses = [];
    document.addEventListener('DOMContentLoaded', loadWarehouses);

    async function loadWarehouses() {
        const res = await fetch('api/warehouses.php');
        warehouses = await res.json();
        let html = '';
        warehouses.forEach(w => {
            html += `
            <div class="col-md-4 mb-4">
                <div class="stat-card position-relative">
                    <button class="btn btn-action btn-light position-absolute" style="top:20px; right:20px;" onclick="editWarehouse(${w.id})">
                        <i class="ph ph-pencil"></i>
                    </button>
                    <div class="stat-icon icon-blue"><i class="ph-bold ph-factory"></i></div>
                    <h5 class="fw-bold mb-1">${w.nama_gudang}</h5>
                    <p class="text-muted small mb-3"><i class="ph ph-map-pin me-1"></i> ${w.alamat || '-'}</p>
                    <div class="d-flex align-items-center gap-2 text-primary small">
                        <i class="ph ph-phone"></i> <span>${w.telepon || '-'}</span>
                    </div>
                </div>
            </div>`;
        });
        document.getElementById('warehouses-list').innerHTML = html || '<div class="col-12 text-center text-muted">Belum ada gudang</div>';
    }

    document.getElementById('warehouseForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('warehouseId').value;
        const data = {
            id,
            nama_gudang: document.getElementById('nama_gudang').value,
            alamat: document.getElementById('alamat').value,
            telepon: document.getElementById('telepon').value
        };
        const method = id ? 'PUT' : 'POST';
        const res = await fetch('api/warehouses.php', {
            method: method,
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data)
        });
        if(res.ok) {
            bootstrap.Modal.getInstance(document.getElementById('warehouseModal')).hide();
            Swal.fire('Berhasil', 'Data gudang disimpan', 'success');
            loadWarehouses();
        }
    });

    function resetForm() {
        document.getElementById('warehouseForm').reset();
        document.getElementById('warehouseId').value = '';
        document.getElementById('modalTitle').textContent = 'Tambah Gudang Baru';
    }

    function editWarehouse(id) {
        const w = warehouses.find(x => x.id == id);
        document.getElementById('warehouseId').value = w.id;
        document.getElementById('nama_gudang').value = w.nama_gudang;
        document.getElementById('alamat').value = w.alamat;
        document.getElementById('telepon').value = w.telepon;
        document.getElementById('modalTitle').textContent = 'Edit Gudang';
        new bootstrap.Modal(document.getElementById('warehouseModal')).show();
    }
</script>

<?php include 'views/layout/footer.php'; ?>
