<?php
session_start();
if(!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$page_title = "Data Toko / Cabang";
$active_menu = "stores";
include 'views/layout/header.php';
include 'views/layout/sidebar.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Manajemen Toko</h4>
    <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#storeModal" onclick="resetForm()">
        <i class="ph-bold ph-plus"></i> Tambah Toko
    </button>
</div>

<div class="row" id="stores-list">
    <!-- Loaded via JS -->
</div>

<!-- STORE MODAL -->
<div class="modal fade" id="storeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalTitle">Tambah Toko Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="storeForm">
                <input type="hidden" id="storeId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Toko</label>
                        <input type="text" class="form-control" id="nama_toko" required>
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
                    <button type="submit" class="btn btn-primary w-100">Simpan Toko</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let stores = [];
    document.addEventListener('DOMContentLoaded', loadStores);

    async function loadStores() {
        const res = await fetch('api/stores.php');
        stores = await res.json();
        let html = '';
        stores.forEach(s => {
            html += `
            <div class="col-md-4 mb-4">
                <div class="stat-card position-relative">
                    <button class="btn btn-action btn-light position-absolute" style="top:20px; right:20px;" onclick="editStore(${s.id})">
                        <i class="ph ph-pencil"></i>
                    </button>
                    <div class="stat-icon icon-purple"><i class="ph-bold ph-storefront"></i></div>
                    <h5 class="fw-bold mb-1">${s.nama_toko}</h5>
                    <p class="text-muted small mb-3"><i class="ph ph-map-pin me-1"></i> ${s.alamat || '-'}</p>
                    <div class="d-flex align-items-center gap-2 text-primary small">
                        <i class="ph ph-phone"></i> <span>${s.telepon || '-'}</span>
                    </div>
                </div>
            </div>`;
        });
        document.getElementById('stores-list').innerHTML = html || '<div class="col-12 text-center text-muted">Belum ada toko</div>';
    }

    document.getElementById('storeForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('storeId').value;
        const data = {
            id,
            nama_toko: document.getElementById('nama_toko').value,
            alamat: document.getElementById('alamat').value,
            telepon: document.getElementById('telepon').value
        };
        const method = id ? 'PUT' : 'POST';
        const res = await fetch('api/stores.php', {
            method: method,
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data)
        });
        if(res.ok) {
            bootstrap.Modal.getInstance(document.getElementById('storeModal')).hide();
            Swal.fire('Berhasil', 'Data toko disimpan', 'success');
            loadStores();
        }
    });

    function resetForm() {
        document.getElementById('storeForm').reset();
        document.getElementById('storeId').value = '';
        document.getElementById('modalTitle').textContent = 'Tambah Toko Baru';
    }

    function editStore(id) {
        const s = stores.find(x => x.id == id);
        document.getElementById('storeId').value = s.id;
        document.getElementById('nama_toko').value = s.nama_toko;
        document.getElementById('alamat').value = s.alamat;
        document.getElementById('telepon').value = s.telepon;
        document.getElementById('modalTitle').textContent = 'Edit Toko';
        new bootstrap.Modal(document.getElementById('storeModal')).show();
    }
</script>

<?php include 'views/layout/footer.php'; ?>
