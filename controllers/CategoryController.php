<?php
class CategoryController {
    private $db;
    private $category;

    public function __construct($db) {
        $this->db = $db;
        include_once '../models/Category.php';
        $this->category = new Category($db);
    }

    public function getAll() {
        $stmt = $this->category->read();
        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = $row;
        }
        return $categories;
    }

    public function create($data) {
        if(!empty($data->nama_kategori)) {
            $this->category->nama_kategori = $data->nama_kategori;
            return $this->category->create();
        }
        return false;
    }

    public function update($data) {
        if(!empty($data->id) && !empty($data->nama_kategori)) {
            $this->category->id = $data->id;
            $this->category->nama_kategori = $data->nama_kategori;
            return $this->category->update();
        }
        return false;
    }

    public function delete($id) {
        if(!empty($id)) {
            $this->category->id = $id;
            return $this->category->delete();
        }
        return false;
    }
}
?>
