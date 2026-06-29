<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2563EB;
            --glass-bg: rgba(255, 255, 255, 0.9);
            --bg-gradient: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-gradient);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }

        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h2 {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .login-header p {
            color: #64748b;
            font-size: 0.9rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
            border-color: var(--primary-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.4);
        }

        .alert {
            border-radius: 10px;
            font-size: 0.85rem;
            display: none;
        }

        /* Decorative blobs */
        .blob {
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(37, 99, 235, 0.1);
            filter: blur(50px);
            border-radius: 50%;
            z-index: -1;
        }
        .blob-1 { top: -100px; left: -100px; }
        .blob-2 { bottom: -100px; right: -100px; }
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="login-card">
        <div class="login-header">
            <div class="d-flex justify-content-center align-items-center mb-2 text-primary" style="font-size: 2.2rem; font-weight: 800; letter-spacing: 1px;">
                <i class="ph-bold ph-package me-2"></i> INV<span style="color: #1e293b;">SYS</span>
            </div>
            <h5 class="fw-bold text-muted mb-4" style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 2px;">Inventory App</h5>
        </div>

        <div id="loginAlert" class="alert alert-danger" role="alert"></div>

        <form id="loginForm">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter username" required>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter password" required>
            </div>
            <button type="submit" class="btn btn-primary" id="loginBtn">
                <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                Login
            </button>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const alert = document.getElementById('loginAlert');
            const btn = document.getElementById('loginBtn');
            const spinner = btn.querySelector('.spinner-border');

            // Reset UI
            alert.style.display = 'none';
            btn.disabled = true;
            spinner.classList.remove('d-none');

            try {
                const response = await fetch('api/login.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ username, password })
                });

                const text = await response.text();
                
                try {
                    const result = JSON.parse(text);
                    if (response.ok) {
                        window.location.href = 'dashboard.php';
                    } else {
                        alert.textContent = result.message || 'Login failed';
                        alert.style.display = 'block';
                    }
                } catch (parseError) {
                    console.error("Respon bukan JSON:", text);
                    alert.textContent = 'Respon Server Tidak Valid (Cek Console F12)';
                    alert.style.display = 'block';
                }

            } catch (error) {
                console.error("Fetch Error:", error);
                alert.textContent = 'Koneksi Gagal / Network Error';
                alert.style.display = 'block';
            } finally {
                btn.disabled = false;
                spinner.classList.add('d-none');
            }
        });
    </script>
</body>
</html>
