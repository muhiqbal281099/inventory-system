<?php
class ItemController {
    private $db;
    private $item;

    public function __construct($db) {
        $this->db = $db;
        include_once '../models/Item.php';
        $this->item = new Item($db);
    }

    public function getAll($search = "", $category = "") {
        $stmt = $this->item->read($search, $category);
        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = $row;
        }
        return $items;
    }

    public function create($data) {
        if(!empty($data->kode_barang) && !empty($data->nama_barang)) {
            $this->item->kode_barang = $data->kode_barang;
            $this->item->nama_barang = $data->nama_barang;
            $this->item->kategori_id = $data->kategori_id;
            $this->item->stok = $data->stok;
            $this->item->lokasi = $data->lokasi;
            $this->item->tanggal_masuk = $data->tanggal_masuk;
            return $this->item->create();
        }
        return false;
    }

    public function update($data) {
        if(!empty($data->id)) {
            $this->item->id = $data->id;
            $this->item->kode_barang = $data->kode_barang;
            $this->item->nama_barang = $data->nama_barang;
            $this->item->kategori_id = $data->kategori_id;
            $this->item->stok = $data->stok;
            $this->item->lokasi = $data->lokasi;
            $this->item->tanggal_masuk = $data->tanggal_masuk;
            return $this->item->update();
        }
        return false;
    }

    public function delete($id) {
        if(!empty($id)) {
            $this->item->id = $id;
            return $this->item->delete();
        }
        return false;
    }
}
?>
