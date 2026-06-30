<?php

$page_title = "Riwayat Pergerakan Stok";
$active_menu = "history";
include 'views/layout/header.php';
include 'views/admin/sidebar.php';
?>

<div class="table-card">
    <div class="table-header flex-column flex-md-row gap-3">
        <h5 class="fw-bold mb-0">Log Transaksi Stok</h5>
        <button class="btn btn-sm btn-outline-secondary" onclick="loadHistory()"><i class="ph ph-arrows-clockwise"></i> Refresh</button>
    </div>
    <div class="table-responsive mt-3">
        <table id="historyTable" class="table table-hover mb-0 w-100">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Barang</th>
                    <th>Jenis</th>
                    <th>Tujuan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="history-body"></tbody>
        </table>
    </div>
</div>

<script>
    let userRole = '<?php echo $_SESSION["role"] ?? "Staff Gudang"; ?>';
    let dataTableInst = null;

    document.addEventListener('DOMContentLoaded', loadHistory);

    async function loadHistory() {
        const res = await fetch('api/transfer.php');
        const history = await res.json();
        
        if (dataTableInst) { dataTableInst.destroy(); }
        
        const tbody = document.getElementById('history-body');
        let html = '';
        history.forEach(h => {
            let badge = '';
            if(h.type == 'TRANSFER') badge = '<span class="badge bg-primary">Transfer</span>';
            else if(h.type == 'IN') badge = '<span class="badge bg-success" title="Masuk"><i class="ph-bold ph-arrow-down-left"></i></span>';
            else badge = '<span class="badge bg-danger" title="Keluar"><i class="ph-bold ph-arrow-up-right"></i></span>';

            let statusBadge = '';
            if(h.status == 'APPROVED') statusBadge = '<span class="badge bg-success bg-opacity-10 text-success">Approved</span>';
            else if(h.status == 'PENDING') statusBadge = '<span class="badge bg-warning bg-opacity-10 text-warning">Pending</span>';
            else statusBadge = '<span class="badge bg-danger bg-opacity-10 text-danger">Rejected</span>';

            let actions = '';
            if(h.status == 'PENDING' && (userRole === 'Administrator' || userRole === 'Manager')) {
                actions = `
                    <button class="btn btn-action btn-success text-white" title="Approve" onclick="approveTransfer(${h.id})"><i class="ph-bold ph-check"></i></button>
                    <button class="btn btn-action btn-danger text-white" title="Reject" onclick="rejectTransfer(${h.id})"><i class="ph-bold ph-x"></i></button>
                `;
            }

            html += `<tr>
                <td><small class="text-muted">${h.created_at}</small></td>
                <td><span class="fw-bold">${h.nama_barang}</span><br><small class="text-muted">Qty: ${h.qty}</small></td>
                <td>${badge}</td>
                <td>${h.nama_toko || '-'}</td>
                <td>${statusBadge}</td>
                <td>${actions}</td>
            </tr>`;
        });
        tbody.innerHTML = html;
        
        dataTableInst = $('#historyTable').DataTable({
            dom: '<"row align-items-center mb-3"<"col-md-6"B><"col-md-6"f>>rt<"row align-items-center mt-3"<"col-md-6"i><"col-md-6"p>>',
            buttons: ['excel', 'pdf', 'print'],
            order: [[0, 'desc']],
            language: { search: "_INPUT_", searchPlaceholder: "Cari riwayat..." }
        });
    }

    async function approveTransfer(id) {
        if(await confirmAction('Approve pengiriman ini?')) {
            await fetch('api/transfer.php', { method: 'PUT', body: JSON.stringify({id, action: 'approve'}) });
            loadHistory();
        }
    }

    async function rejectTransfer(id) {
        if(await confirmAction('Tolak pengiriman ini?')) {
            await fetch('api/transfer.php', { method: 'PUT', body: JSON.stringify({id, action: 'reject'}) });
            loadHistory();
        }
    }

    async function confirmAction(text) {
        const result = await Swal.fire({ title: 'Konfirmasi', text, icon: 'question', showCancelButton: true });
        return result.isConfirmed;
    }
</script>

<?php include 'views/layout/footer.php'; ?>
