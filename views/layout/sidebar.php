    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand justify-content-between">
            <div><i class="ph-bold ph-package me-2"></i> INV<span>SYS</span></div>
            <button class="btn text-white d-lg-none p-0" id="sidebarClose">
                <i class="ph-bold ph-x fs-4"></i>
            </button>
        </div>
        <ul class="nav-list">
            <!-- MAIN -->
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link <?php echo $active_menu == 'dashboard' ? 'active' : ''; ?>">
                    <i class="ph-fill ph-house"></i> Dashboard
                </a>
            </li>

            <!-- GROUP: MASTER DATA -->
            <li class="nav-label mt-4 mb-2 ps-4 text-uppercase fw-bold" style="font-size: 0.65rem; color: #475569; letter-spacing: 1px;">
                Master Data
            </li>
            <li class="nav-item">
                <a href="categories.php" class="nav-link <?php echo $active_menu == 'categories' ? 'active' : ''; ?>">
                    <i class="ph-fill ph-tag"></i> Data Kategori
                </a>
            </li>
            <li class="nav-item">
                <a href="items.php" class="nav-link <?php echo $active_menu == 'items' ? 'active' : ''; ?>">
                    <i class="ph-fill ph-cube"></i> Data Barang
                </a>
            </li>
            <li class="nav-item">
                <a href="warehouses.php" class="nav-link <?php echo $active_menu == 'warehouses' ? 'active' : ''; ?>">
                    <i class="ph-fill ph-factory"></i> Data Gudang
                </a>
            </li>
            <li class="nav-item">
                <a href="stores.php" class="nav-link <?php echo $active_menu == 'stores' ? 'active' : ''; ?>">
                    <i class="ph-fill ph-storefront"></i> Data Toko
                </a>
            </li>

            <!-- GROUP: LOGISTICS -->
            <li class="nav-label mt-4 mb-2 ps-4 text-uppercase fw-bold" style="font-size: 0.65rem; color: #475569; letter-spacing: 1px;">
                Pusat Logistik
            </li>
            <li class="nav-item">
                <a href="transfer.php" class="nav-link <?php echo $active_menu == 'transfer' ? 'active' : ''; ?>">
                    <i class="ph-fill ph-truck"></i> Kirim Barang
                </a>
            </li>
            <li class="nav-item">
                <a href="history.php" class="nav-link <?php echo $active_menu == 'history' ? 'active' : ''; ?>">
                    <i class="ph-fill ph-clock-counter-clockwise"></i> Riwayat Stok
                </a>
            </li>

            <!-- LOGOUT -->
            <li class="nav-item mt-5 pt-3 border-top border-secondary border-opacity-25" style="margin-top: auto !important;">
                <a href="logout.php" class="nav-link text-danger">
                    <i class="ph-fill ph-sign-out"></i> Logout
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="d-flex align-items-center">
                <button class="btn d-lg-none me-3" id="sidebarToggle">
                    <i class="ph ph-list fs-3"></i>
                </button>
                <div class="page-title d-none d-sm-block">
                    <h5 class="fw-bold mb-0"><?php echo $page_title ?? 'Dashboard'; ?></h5>
                </div>
            </div>
            <div class="user-profile dropdown">
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end d-none d-md-block">
                        <span class="fw-bold d-block small"><?php echo $_SESSION['nama'] ?? 'Admin'; ?></span>
                        <span class="text-muted small" style="text-transform: capitalize;"><?php echo $_SESSION['role'] ?? 'Staff Gudang'; ?></span>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=<?php echo $_SESSION['nama']; ?>&background=2563EB&color=fff" alt="Avatar" class="rounded-3" style="width: 40px; height: 40px;">
                </div>
            </div>
        </div>
        <div class="content-body">
