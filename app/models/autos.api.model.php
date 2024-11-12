<?php
class AutosApiModel{
    
    private $db;

    public function __construct(){
        $this->db = $this->getDb();
    }

    private function getDB() {
        $db = new PDO('mysql:host=localhost;'.'dbname=automotrizinfo_bd;charset=utf8', 'root', '');
        return $db;
    }

    public function getAll(){
        $query=$this->db->prepare("SELECT * FROM autos");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getById($id) {
        $query = $this->db->prepare("SELECT * FROM autos WHERE id_auto = ?");
        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function getAllByOrder($sort, $order){
        $query = $this->db->prepare("SELECT * FROM autos ORDER BY $sort $order");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAllByFilter($value) {
        $query = $this->db->prepare("SELECT * FROM autos WHERE marca = ?");
        $query->execute([$value]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function add($nombres, $anio, $motor, $marca, $id_categoria_ext, $caracteristicas){
        $query = $this->db->prepare("INSERT INTO autos (nombres, anio, motor, marca, id_categoria_ext, caracteristicas) VALUES (?,?,?,?,?,?)");
        $query->execute([$nombres, $anio, $motor, $marca, $id_categoria_ext, $caracteristicas]);

        return $this->db->lastInsertId();
    }

    public function delete($id) {
        $query = $this->db->prepare("DELETE FROM autos WhERE id_auto = ?");
        $query->execute([$id]);
    }

    public function edit($id, $nombres, $anio, $motor, $marca, $id_categoria, $caracteristicas){
        $query = $this->db->prepare("UPDATE `autos` SET `nombres` = ?, `anio` = ?, `motor` = ?, `marca` = ?, `id_categoria_ext` = ?, `caracteristicas` = ? WHERE `id_auto` = ?");
        $query->execute([$nombres, $anio, $motor, $marca, $id_categoria, $caracteristicas, $id]);
    }

    
}