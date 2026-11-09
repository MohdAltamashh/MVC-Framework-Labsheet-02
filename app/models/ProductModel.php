<?php
class ProductModel {
    private PDO $db; public function __construct(){ $this->db=Database::connection(); }
    public function create(array $d): int {
        $s=$this->db->prepare('INSERT INTO products(name,price,quantity,image_name) VALUES(?,?,?,?)');
        $s->execute([$d['name'],$d['price'],$d['quantity'],$d['image_name']]); return (int)$this->db->lastInsertId();
    }
    public function all(): array { return $this->db->query('SELECT * FROM products ORDER BY id DESC')->fetchAll(); }
}
