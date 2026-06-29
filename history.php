<?php
session_start();
if(!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$page_title = "Riwayat Pergerakan Stok";
$active_menu = "history";
include 'views/layout/header.php';
include 'views/layout/sidebar.php';
?>

<div class="table-card">
    <div class="table-header">
        <h5 class="fw-bold mb-0">Log Transaksi Stok</h5>
        <button class="btn btn-sm btn-outline-secondary" onclick="loadHistory()"><i class="ph ph-arrows-clockwise"></i> Refresh</button>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Barang</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Tujuan/Toko</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody id="history-body"></tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', loadHistory);

    async function loadHistory() {
        const res = await fetch('api/transfer.php');
        const history = await res.json();
        const tbody = document.getElementById('history-body');
        let html = '';
        history.forEach(h => {
            let badge = '';
            if(h.type == 'TRANSFER') badge = '<span class="badge bg-primary">Transfer</span>';
            else if(h.type == 'IN') badge = '<span class="badge bg-success">Masuk</span>';
            else badge = '<span class="badge bg-danger">Keluar</span>';

            html += `<tr>
                <td><small class="text-muted">${h.created_at}</small></td>
                <td class="fw-bold">${h.nama_barang}</td>
                <td>${badge}</td>
                <td class="fw-bold">${h.qty}</td>
                <td>${h.nama_toko || '-'}</td>
                <td><small>${h.keterangan || '-'}</small></td>
            </tr>`;
        });
        tbody.innerHTML = html || '<tr><td colspan="6" class="text-center py-4">Belum ada riwayat</td></tr>';
    }
</script>

<?php include 'views/layout/footer.php'; ?>
