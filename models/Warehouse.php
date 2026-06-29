<?php
class Warehouse {
    private $conn;
    private $table_name = "warehouses";

    public $id;
    public $nama_gudang;
    public $alamat;
    public $telepon;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nama_gudang ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nama_gudang=:nama_gudang, alamat=:alamat, telepon=:telepon";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nama_gudang", $this->nama_gudang);
        $stmt->bindParam(":alamat", $this->alamat);
        $stmt->bindParam(":telepon", $this->telepon);
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nama_gudang=:nama_gudang, alamat=:alamat, telepon=:telepon WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nama_gudang", $this->nama_gudang);
        $stmt->bindParam(":alamat", $this->alamat);
        $stmt->bindParam(":telepon", $this->telepon);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}
