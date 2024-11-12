<?php
class CategoriasApiModel{
    
    private $db;

    public function __construct(){
        $this->db = $this->getDb();
    }

    private function getDB() {
        $db = new PDO('mysql:host=localhost;'.'dbname=automotrizinfo_bd;charset=utf8', 'root', '');
        return $db;
    }

    public function getAll(){
        $query=$this->db->prepare("SELECT * FROM categoria");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getById($id) {
        $query = $this->db->prepare("SELECT * FROM categoria WHERE id_categoria = ?");
        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function getAllByOrder($sort, $order){
        $query = $this->db->prepare("SELECT * FROM categoria ORDER BY $sort $order");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAllByFilter($value) {
        $query = $this->db->prepare("SELECT * FROM categoria WHERE caracteristicas LIKE :value");
        $query->execute(['value' => "%$value%"]);
    
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function add($nombre, $caracteristicas){
        $query = $this->db->prepare("INSERT INTO categoria (nombre, caracteristicas) VALUES (?,?)");
        $query->execute([$nombre, $caracteristicas]);

        return $this->db->lastInsertId();
    }

    public function delete($id) {
        try {
            $query = $this->db->prepare("DELETE FROM categoria WhERE id_categoria = ?");
            $query->execute([$id]);
        }
        catch (Exception $e) {
            return $e;
        }
    }

    public function edit($id, $nombres, $caracteristicas){
        $query = $this->db->prepare("UPDATE `categoria` SET `nombre` = ?,  `caracteristicas` = ? WHERE `id_categoria` = ?");
        $query->execute([$nombres, $caracteristicas, $id]);
    }



}