<?php
class StockMovement {
    private $conn;
    private $table_name = "stock_movements";

    public $id;
    public $item_id;
    public $store_id;
    public $type;
    public $qty;
    public $keterangan;
    public $status = 'APPROVED';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET item_id=:item_id, store_id=:store_id, type=:type, qty=:qty, keterangan=:keterangan, status=:status";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":item_id", $this->item_id);
        $stmt->bindParam(":store_id", $this->store_id);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":qty", $this->qty);
        $stmt->bindParam(":keterangan", $this->keterangan);
        $stmt->bindParam(":status", $this->status);

        if($stmt->execute()) {
            if ($this->status === 'APPROVED') {
                $stock_change = ($this->type == 'IN' ? $this->qty : -$this->qty);
                $update_query = "UPDATE items SET stok = stok + :change WHERE id = :id";
                $update_stmt = $this->conn->prepare($update_query);
                $update_stmt->bindParam(":change", $stock_change);
                $update_stmt->bindParam(":id", $this->item_id);
                return $update_stmt->execute();
            }
            return true;
        }
        return false;
    }

    public function approve($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row && $row['status'] == 'PENDING') {
            $upd = "UPDATE " . $this->table_name . " SET status = 'APPROVED' WHERE id = :id";
            $updStmt = $this->conn->prepare($upd);
            $updStmt->bindParam(":id", $id);
            if($updStmt->execute()) {
                $stock_change = ($row['type'] == 'IN' ? $row['qty'] : -$row['qty']);
                $update_query = "UPDATE items SET stok = stok + :change WHERE id = :item_id";
                $update_stmt = $this->conn->prepare($update_query);
                $update_stmt->bindParam(":change", $stock_change);
                $update_stmt->bindParam(":item_id", $row['item_id']);
                return $update_stmt->execute();
            }
        }
        return false;
    }

    public function reject($id) {
        $upd = "UPDATE " . $this->table_name . " SET status = 'REJECTED' WHERE id = :id AND status = 'PENDING'";
        $updStmt = $this->conn->prepare($upd);
        $updStmt->bindParam(":id", $id);
        return $updStmt->execute();
    }

    public function readAll() {
        $query = "SELECT sm.*, i.nama_barang, s.nama_toko 
                  FROM " . $this->table_name . " sm
                  LEFT JOIN items i ON sm.item_id = i.id
                  LEFT JOIN stores s ON sm.store_id = s.id
                  ORDER BY sm.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
