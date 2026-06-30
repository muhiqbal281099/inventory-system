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
                <a href="items.php" class="nav-link <?php echo $active_menu == 'items' ? 'active' : ''; ?>">
                    <i class="ph-fill ph-cube"></i> Data Barang
                </a>
            </li>
                <li class="nav-item">
                    <a href="restock.php" class="nav-link <?= $active_menu == 'restock' ? 'active' : '' ?>">
                        <i class="ph ph-download-simple"></i>
                        <span>Barang Masuk</span>
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
                    <div class="dropdown me-2">
                        <button class="btn btn-light position-relative rounded-circle p-2 d-flex align-items-center justify-content-center" type="button" data-bs-toggle="dropdown" id="btnNotif">
                            <i class="ph ph-bell fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notifBadge" style="display: none; font-size:0.6rem;">0</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end p-0 shadow border-0 overflow-hidden" style="width: 320px;" id="notifList">
                            <li class="bg-primary text-white px-3 py-2 fw-bold" style="font-size:0.85rem;">Notifikasi Sistem</li>
                            <div id="notifItems" style="max-height: 300px; overflow-y: auto;">
                                <li><span class="dropdown-item text-center text-muted py-3" style="font-size:0.85rem;">Tidak ada notifikasi</span></li>
                            </div>
                        </ul>
                    </div>
                    <div class="text-end d-none d-md-block">
                        <span class="fw-bold d-block small"><?php echo $_SESSION['nama'] ?? 'Admin'; ?></span>
                        <span class="text-muted small" style="text-transform: capitalize;"><?php echo $_SESSION['role'] ?? 'Staff Gudang'; ?></span>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=<?php echo $_SESSION['nama']; ?>&background=2563EB&color=fff" alt="Avatar" class="rounded-3" style="width: 40px; height: 40px;">
                </div>
            </div>
        </div>
        <div class="content-body">
