<?php
class Category {
    private $conn;
    private $table_name = "categories";

    public $id;
    public $nama_kategori;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        // Gabungkan dengan tabel items untuk menghitung jumlah barang per kategori
        $query = "SELECT c.*, COUNT(i.id) as total_barang 
                  FROM " . $this->table_name . " c
                  LEFT JOIN items i ON c.id = i.kategori_id
                  GROUP BY c.id
                  ORDER BY c.nama_kategori ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function countAll() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nama_kategori=:nama_kategori";
        $stmt = $this->conn->prepare($query);
        $this->nama_kategori = htmlspecialchars(strip_tags($this->nama_kategori));
        $stmt->bindParam(":nama_kategori", $this->nama_kategori);
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nama_kategori=:nama_kategori WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $this->nama_kategori = htmlspecialchars(strip_tags($this->nama_kategori));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":nama_kategori", $this->nama_kategori);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    public function delete() {
        // Cek dulu apakah masih ada barang di kategori ini
        $check_query = "SELECT COUNT(*) as count FROM items WHERE kategori_id = :id";
        $check_stmt = $this->conn->prepare($check_query);
        $check_stmt->bindParam(":id", $this->id);
        $check_stmt->execute();
        $row = $check_stmt->fetch(PDO::FETCH_ASSOC);

        if($row['count'] > 0) {
            return false; // Gagal hapus karena ada barang
        }

        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}
