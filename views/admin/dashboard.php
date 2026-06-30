<?php
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$page_title = "Dashboard Overview";
$active_menu = "dashboard";

include 'views/layout/header.php';
include 'views/admin/sidebar.php';
?>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="ph-duotone ph-package" style="font-size: 1.2em;"></i></div>
            <div class="stat-label">Total Barang</div>
            <div class="stat-value" id="stat-total-items">...</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon icon-green"><i class="ph-duotone ph-squares-four" style="font-size: 1.2em;"></i></div>
            <div class="stat-label">Total Kategori</div>
            <div class="stat-value" id="stat-total-categories">...</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon icon-red"><i class="ph-duotone ph-warning-circle" style="font-size: 1.2em;"></i></div>
            <div class="stat-label">Stok Rendah (< 10)</div>
            <div class="stat-value" id="stat-low-stock">...</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="table-card">
            <div class="table-header">
                <h5 class="mb-0 fw-bold">Barang Terbaru</h5>
                <a href="items.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody id="latest-items-body">
                        <!-- Data loaded via JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="stat-card" style="height: 100%;">
            <h5 class="mb-4 fw-bold">Distribusi Kategori</h5>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    let categoryChartInstance = null;

    async function loadDashboardData() {
        try {
            const response = await fetch('api/stats.php');
            const data = await response.json();
            
            document.getElementById('stat-total-items').textContent = data.total_items;
            document.getElementById('stat-total-categories').textContent = data.total_categories;
            document.getElementById('stat-low-stock').textContent = data.low_stock;
            
            // Render Table
            const tbody = document.getElementById('latest-items-body');
            let html = '';
            data.latest_items.forEach(item => {
                html += `<tr>
                    <td><small class="fw-bold text-primary">${item.kode_barang}</small></td>
                    <td>${item.nama_barang}</td>
                    <td><span class="badge-kategori">${item.nama_kategori || 'N/A'}</span></td>
                    <td><span class="fw-bold">${item.stok}</span></td>
                </tr>`;
            });
            tbody.innerHTML = html || '<tr><td colspan="4" class="text-center py-4">Belum ada barang</td></tr>';
            
            // Update Chart
            if (categoryChartInstance) {
                categoryChartInstance.data.labels = data.chart_labels;
                categoryChartInstance.data.datasets[0].data = data.chart_data;
                categoryChartInstance.update();
            } else {
                categoryChartInstance = new Chart(document.getElementById('categoryChart'), {
                    type: 'doughnut',
                    data: {
                        labels: data.chart_labels,
                        datasets: [{
                            data: data.chart_data,
                            backgroundColor: ['#2563EB', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'bottom' } },
                        cutout: '70%',
                        animation: categoryChartInstance ? false : true // Animate only on first load
                    }
                });
            }
        } catch (err) { console.error(err); }
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadDashboardData();
        // Update automatically every 5 seconds
        setInterval(loadDashboardData, 5000);
    });
</script>

<?php include 'views/layout/footer.php'; ?>
