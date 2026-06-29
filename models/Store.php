<?php
class Store {
    private $conn;
    private $table_name = "stores";

    public $id;
    public $nama_toko;
    public $alamat;
    public $telepon;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nama_toko ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nama_toko=:nama_toko, alamat=:alamat, telepon=:telepon";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nama_toko", $this->nama_toko);
        $stmt->bindParam(":alamat", $this->alamat);
        $stmt->bindParam(":telepon", $this->telepon);
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nama_toko=:nama_toko, alamat=:alamat, telepon=:telepon WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nama_toko", $this->nama_toko);
        $stmt->bindParam(":alamat", $this->alamat);
        $stmt->bindParam(":telepon", $this->telepon);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}
