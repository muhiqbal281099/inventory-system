-- Database for Inventory System
CREATE DATABASE IF NOT EXISTS inventory_system;
USE inventory_system;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    role ENUM('Administrator', 'Manager', 'Staff Gudang') DEFAULT 'Staff Gudang',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Stores table
CREATE TABLE IF NOT EXISTS stores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_toko VARCHAR(100) NOT NULL,
    alamat TEXT,
    telepon VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Warehouses table (NEW)
CREATE TABLE IF NOT EXISTS warehouses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_gudang VARCHAR(100) NOT NULL,
    alamat TEXT,
    telepon VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Items table (Updated to use warehouse_id)
CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(50) NOT NULL UNIQUE,
    nama_barang VARCHAR(100) NOT NULL,
    kategori_id INT,
    warehouse_id INT,
    stok INT DEFAULT 0,
    tanggal_masuk DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kategori_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(id) ON DELETE SET NULL
);

-- Stock Movements table
CREATE TABLE IF NOT EXISTS stock_movements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT,
    store_id INT NULL,
    type ENUM('IN', 'OUT', 'TRANSFER') NOT NULL,
    qty INT NOT NULL,
    keterangan TEXT,
    status ENUM('PENDING', 'APPROVED', 'REJECTED') DEFAULT 'APPROVED',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE,
    FOREIGN KEY (store_id) REFERENCES stores(id) ON DELETE SET NULL
);

-- Initial Data
INSERT INTO users (username, password, nama, role) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'Administrator'),
('manager', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Kepala Cabang / Manager', 'Manager'),
('staff', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Staf Gudang', 'Staff Gudang');

INSERT INTO categories (nama_kategori) VALUES 
('Elektronik'), ('Furniture'), ('Alat Tulis'), ('Pakaian'), ('Otomotif');

INSERT INTO warehouses (nama_gudang, alamat, telepon) VALUES 
('Gudang Pusat Jakarta', 'Jl. Industri No. 1', '021-111111'),
('Gudang Regional Bandung', 'Jl. Logistik No. 45', '022-222222'),
('Gudang Timur Surabaya', 'Jl. Pelabuhan No. 7', '031-333333');

INSERT INTO stores (nama_toko, alamat, telepon) VALUES 
('Toko Cabang Jakarta', 'Jl. Merdeka No. 10', '08123456789'),
('Toko Cabang Bandung', 'Jl. Braga No. 5', '08223456789'),
('Toko Cabang Surabaya', 'Jl. Tunjungan No. 20', '08323456789');

INSERT INTO items (kode_barang, nama_barang, kategori_id, warehouse_id, stok, tanggal_masuk) VALUES 
('LAP-001', 'Laptop ASUS ROG', 1, 1, 15, '2026-06-01'),
('MOU-002', 'Mouse Logitech G502', 1, 1, 50, '2026-06-05'),
('MEA-001', 'Meja Kerja Kayu', 2, 2, 8, '2026-06-10'),
('PEN-001', 'Pulpen Pilot Black', 3, 3, 200, '2026-06-12'),
('SHI-001', 'Kaos Polos Cotton', 4, 2, 120, '2026-06-15');
