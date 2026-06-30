<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Inventory System'; ?> - INV SYS</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <!-- JsBarcode -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    
    <style>
        :root {
            --primary: #2563EB;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --sidebar-width: 260px;
            --topbar-height: 70px;
            --bg-body: #F8FAFC;
            --white: #FFFFFF;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: #1E293B;
            margin: 0;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: #0F172A;
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            transition: all 0.3s ease;
            z-index: 1001;
        }

        @media (max-width: 991.98px) {
            .sidebar { left: -100%; }
            .sidebar.active { left: 0; }
            .main-content { margin-left: 0 !important; }
        }

        .sidebar-brand {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            padding: 0 25px;
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand span { color: var(--primary); }

        .nav-list { padding: 20px 0; list-style: none; margin: 0; }
        .nav-item { padding: 2px 15px; }
        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: #94A3B8;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.2s;
            font-weight: 500;
        }

        .nav-link i { font-size: 1.25rem; margin-right: 12px; }
        .nav-link:hover, .nav-link.active { background: rgba(37, 99, 235, 0.1); color: white; }
        .nav-link.active { background: var(--primary); color: white; }

        /* Main Content Styles */
        .main-content { margin-left: var(--sidebar-width); min-height: 100vh; display: flex; flex-direction: column; }
        .topbar {
            height: var(--topbar-height);
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .content-body { padding: 30px; flex: 1; }

        /* Footer Styles */
        .footer {
            background: var(--white);
            padding: 20px 30px;
            border-top: 1px solid #E2E8F0;
            color: #64748B;
            font-size: 0.875rem;
            text-align: center;
        }

        /* Generic CSS for cards and tables */
        .stat-card { background: var(--white); border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #F1F5F9; }
        .table-card { background: var(--white); border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #F1F5F9; overflow: hidden; }
        .table-header { padding: 20px 24px; border-bottom: 1px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center; }
        
        .badge-kategori { background: #F1F5F9; color: #475569; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; }
        .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; font-size: 1.5rem; }
        .icon-blue { background: rgba(37,99,235,0.1); color: var(--primary); }
        .icon-green { background: rgba(16,185,129,0.1); color: var(--success); }
        .icon-red { background: rgba(239,68,68,0.1); color: var(--danger); }
        .icon-purple { background: rgba(139, 92, 246, 0.1); color: #8B5CF6; }

        .btn-action { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; margin: 0 2px; }
    </style>
</head>
<body>
