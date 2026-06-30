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