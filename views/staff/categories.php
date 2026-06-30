<?php

$page_title = "Data Kategori";
$active_menu = "categories";
include 'views/layout/header.php';
include 'views/staff/sidebar.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Manajemen Kategori</h4>
    <button class="btn btn-primary d-flex align-items-center gap-2" onclick="promptAddCategory()">
        <i class="ph-bold ph-plus"></i> Tambah Kategori
    </button>
</div>

<div class="row" id="categories-list">
    <!-- Loaded via JS -->
</div>

<script>
    let categories = [];
    document.addEventListener('DOMContentLoaded', loadCategories);

    async function loadCategories() {
        const res = await fetch('api/categories.php');
        categories = await res.json();
        let html = '';
        categories.forEach(c => {
            html += `
            <div class="col-md-3 mb-4">
                <div class="stat-card position-relative">
                    <div class="dropdown position-absolute" style="top:15px; right:15px;">
                        <button class="btn btn-sm btn-light border-0" data-bs-toggle="dropdown"><i class="ph ph-dots-three-vertical"></i></button>
                        <ul class="dropdown-menu shadow border-0">
                            <li><a class="dropdown-item" href="#" onclick="editCategory(${c.id}, '${c.nama_kategori}')"><i class="ph ph-pencil me-2"></i>Edit</a></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteCategory(${c.id}, ${c.total_barang})"><i class="ph ph-trash me-2"></i>Hapus</a></li>
                        </ul>
                    </div>
                    <div class="stat-icon icon-green mb-3"><i class="ph-bold ph-tag"></i></div>
                    <h6 class="fw-bold mb-1">${c.nama_kategori}</h6>
                    <div class="badge bg-light text-dark border fw-normal">
                        <i class="ph ph-cube me-1"></i> ${c.total_barang} Barang
                    </div>
                </div>
            </div>`;
        });
        document.getElementById('categories-list').innerHTML = html || '<div class="col-12 text-center text-muted">Belum ada kategori</div>';
    }

    async function promptAddCategory() {
        const { value: name } = await Swal.fire({
            title: 'Tambah Kategori',
            input: 'text',
            inputLabel: 'Nama Kategori',
            showCancelButton: true
        });
        if (name) {
            await fetch('api/categories.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ nama_kategori: name })
            });
            loadCategories();
        }
    }

    async function editCategory(id, currentName) {
        const { value: name } = await Swal.fire({
            title: 'Edit Kategori',
            input: 'text',
            inputValue: currentName,
            showCancelButton: true
        });
        if (name && name !== currentName) {
            await fetch('api/categories.php', {
                method: 'PUT',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ id, nama_kategori: name })
            });
            loadCategories();
        }
    }

    async function deleteCategory(id, count) {
        if(count > 0) {
            Swal.fire({
                title: 'Tidak Bisa Menghapus!',
                text: `Terdapat ${count} barang dalam kategori ini. Kosongkan barang terlebih dahulu.`,
                icon: 'error'
            });
            return;
        }

        const result = await Swal.fire({
            title: 'Hapus Kategori?',
            text: "Data yang dihapus tidak bisa dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        });

        if(result.isConfirmed) {
            const res = await fetch(`api/categories.php?id=${id}`, { method: 'DELETE' });
            if(res.ok) {
                Swal.fire('Terhapus!', 'Kategori telah dihapus.', 'success');
                loadCategories();
            } else {
                const err = await res.json();
                Swal.fire('Gagal', err.message, 'error');
            }
        }
    }
</script>

<?php include 'views/layout/footer.php'; ?>
