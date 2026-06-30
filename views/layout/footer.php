</div> <!-- end content-body -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                &copy; <?php echo date('Y'); ?> <strong>Inventory System</strong>. All rights reserved.
            </div>
            <div class="col-md-6 text-center text-md-end d-none d-md-block">
                Developed by Muhammad Iqbal Fathur Rozi (2313020245).
            </div>
        </div>
    </div>
</footer>
</div> <!-- end main-content -->

<!-- Global Scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        if ($('.datatable').length) {
            $('.datatable').DataTable({
                dom: '<"row align-items-center mb-3"<"col-md-6"B><"col-md-6"f>>rt<"row align-items-center mt-3"<"col-md-6"i><"col-md-6"p>>',
                buttons: [
                    { extend: 'excel', className: 'btn btn-sm btn-success', text: '<i class="ph-bold ph-file-xls me-1"></i> Excel' },
                    { extend: 'pdf', className: 'btn btn-sm btn-danger', text: '<i class="ph-bold ph-file-pdf me-1"></i> PDF' },
                    { extend: 'print', className: 'btn btn-sm btn-info text-white', text: '<i class="ph-bold ph-printer me-1"></i> Print' }
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari data..."
                }
            });
        }
    });

    // Load Smart Notifications
    async function loadNotifications() {
        try {
            const res = await fetch('api/stats.php');
            if(res.ok) {
                const data = await res.json();
                const badge = document.getElementById('notifBadge');
                const list = document.getElementById('notifItems');
                
                if (data.low_stock > 0) {
                    badge.style.display = 'block';
                    badge.textContent = data.low_stock;
                    
                    let html = '';
                    data.low_stock_items.forEach(item => {
                        html += `
                        <a href="items.php" class="dropdown-item py-2 border-bottom ds-hover">
                            <div class="d-flex align-items-center">
                                <div class="bg-danger bg-opacity-10 text-danger rounded p-2 me-3">
                                    <i class="ph-bold ph-warning"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold" style="font-size:0.8rem;">Stok Menipis: ${item.nama_barang}</h6>
                                    <small class="text-muted" style="font-size:0.75rem;">Sisa stok: ${item.stok} (Gudang: ${item.nama_gudang || '-'})</small>
                                </div>
                            </div>
                        </a>`;
                    });
                    list.innerHTML = html;
                } else {
                    badge.style.display = 'none';
                    list.innerHTML = '<li><span class="dropdown-item text-center text-muted py-3" style="font-size:0.85rem;">Tidak ada notifikasi</span></li>';
                }
            }
        } catch (e) {
            console.error("Failed to load notifications", e);
        }
    }
    
    loadNotifications();
    setInterval(loadNotifications, 30000); // Check every 30s

    // Elements
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');
    const sidebar = document.getElementById('sidebar');

    // Open Sidebar
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.add('active');
        });
    }

    // Hide Sidebar Function
    const hideSidebar = () => {
        sidebar.classList.remove('active');
    };

    // Close Button Click
    if (sidebarClose) sidebarClose.addEventListener('click', hideSidebar);

    // Click Outside Sidebar to Close
    document.addEventListener('click', (e) => {
        if (sidebar.classList.contains('active')) {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                hideSidebar();
            }
        }
    });

    // Auto Close sidebar on desktop resize
    window.addEventListener('resize', () => {
        if (window.innerWidth > 991.98) {
            hideSidebar();
        }
    });
</script>
</body>

</html>