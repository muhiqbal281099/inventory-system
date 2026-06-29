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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
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