<?php
class Item {
    private $conn;
    private $table_name = "items";

    public $id;
    public $kode_barang;
    public $nama_barang;
    public $kategori_id;
    public $warehouse_id;
    public $stok;
    public $tanggal_masuk;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read($search = "", $category_filter = "") {
        $query = "SELECT i.*, c.nama_kategori, w.nama_gudang 
                  FROM " . $this->table_name . " i 
                  LEFT JOIN categories c ON i.kategori_id = c.id
                  LEFT JOIN warehouses w ON i.warehouse_id = w.id";
        
        $conditions = [];
        $params = [];

        if (!empty($search)) {
            $conditions[] = "(i.nama_barang LIKE :search OR i.kode_barang LIKE :search)";
            $params[":search"] = "%$search%";
        }

        if (!empty($category_filter)) {
            $conditions[] = "i.kategori_id = :category_id";
            $params[":category_id"] = $category_filter;
        }

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $query .= " ORDER BY i.created_at DESC";
        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => &$val) { $stmt->bindParam($key, $val); }
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET kode_barang=:kode_barang, nama_barang=:nama_barang, kategori_id=:kategori_id, warehouse_id=:warehouse_id, stok=:stok, tanggal_masuk=:tanggal_masuk";
        $stmt = $this->conn->prepare($query);
        $this->sanitize();
        $stmt->bindParam(":kode_barang", $this->kode_barang);
        $stmt->bindParam(":nama_barang", $this->nama_barang);
        $stmt->bindParam(":kategori_id", $this->kategori_id);
        $stmt->bindParam(":warehouse_id", $this->warehouse_id);
        $stmt->bindParam(":stok", $this->stok);
        $stmt->bindParam(":tanggal_masuk", $this->tanggal_masuk);
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET kode_barang=:kode_barang, nama_barang=:nama_barang, kategori_id=:kategori_id, warehouse_id=:warehouse_id, stok=:stok, tanggal_masuk=:tanggal_masuk 
                  WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $this->sanitize();
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":kode_barang", $this->kode_barang);
        $stmt->bindParam(":nama_barang", $this->nama_barang);
        $stmt->bindParam(":kategori_id", $this->kategori_id);
        $stmt->bindParam(":warehouse_id", $this->warehouse_id);
        $stmt->bindParam(":stok", $this->stok);
        $stmt->bindParam(":tanggal_masuk", $this->tanggal_masuk);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    public function countAll() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    private function sanitize() {
        $this->kode_barang = htmlspecialchars(strip_tags($this->kode_barang));
        $this->nama_barang = htmlspecialchars(strip_tags($this->nama_barang));
        $this->kategori_id = htmlspecialchars(strip_tags($this->kategori_id));
        $this->warehouse_id = htmlspecialchars(strip_tags($this->warehouse_id));
        $this->stok = htmlspecialchars(strip_tags($this->stok));
        $this->tanggal_masuk = htmlspecialchars(strip_tags($this->tanggal_masuk));
    }
}
