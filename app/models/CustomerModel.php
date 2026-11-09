<?php
class CustomerModel {
    private PDO $db; public function __construct(){ $this->db=Database::connection(); }
    public function create(array $d): void {
        $s=$this->db->prepare('INSERT INTO customers(name,email,phone) VALUES(?,?,?)');
        $s->execute([$d['name'],$d['email'],$d['phone']]);
    }
}
