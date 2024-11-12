<?php
require_once "./app/models/autos.api.model.php";
require_once "./app/views/motor.api.view.php";

class AutosApiController{

    private $view;
    private $model;
    private $data;

    public function __construct(){
        $this->view = new MotorApiView();
        $this->model = new AutosApiModel();

        $this->data = file_get_contents("php://input");
    }

    public function getData(){
        return json_decode($this->data);
    }

    public function getAutos(){
        if(isset($_GET['value']) && !empty($_GET['value'])){
            $value = $_GET['value'];
            $value = strtolower($value);
            if($this->verifyValue($value)) {
                $autos = $this->model->getAllByFilter($value);
                if($autos) {
                    $this->view->response($autos, 200);
                } else {
                    $this->view->response("No se pudo filtrar", 400);
                }
            } else {
                $this->view->response("El valor ingresado no es valido", 400);
            }
        } else if(isset($_GET['sort']) && !empty($_GET['sort']) && isset($_GET['order']) && !empty($_GET['order'])) {
            $sort = $_GET['sort'];
            $order = $_GET['order'];
            if($this->verifyField($sort) && $this->verifyValue($order)) {
                $autos = $this->model->getAllByOrder($sort, $order);
                if($autos){
                    $this->view->response($autos, 200);
                } else {
                    $this->view->response("No se pudo ordenar", 400);
                }
            } else {
                $this->view->response("El campo o el valor ingresado no son validos", 400);
            }
        } else {
            $autos = $this->model->getAll();
            if($autos){
                $this->view->response($autos, 200);
            }
            else{
                $this->view->response("No se encontro el recurso solicitado", 400);
            }
        }
    }

    public function getAutoById($params = null) {
        $id = $params[":ID"];
        $auto = $this->model->getById($id);
        if($auto) {
            $this->view->response($auto, 200);
        } else {
            $this->view->response("No se pudo encontrar el auto solicitado", 404);
        }
    }

    public function addAuto($params = null){
        $autos = $this->getData();
        if(!empty($autos->nombres) || !empty($autos->anio) || !empty($autos->motor) || !empty($autos->marca) || !empty($autos->id_categoria_ext) || !empty($autos->caracteristicas) ){
            $id = $this->model->add($autos->nombres, $autos->anio, $autos->motor, $autos->marca, $autos->id_categoria_ext, $autos->caracteristicas);
            if($id) {
                $auto = $this->model->getById($id);
                $this->view->response($auto , 201);
            } else {
                $this->view->response("No se encontro el auto", 404);
            }
        } else {
            $this->view->response("Debe completar los datos solicitados!!", 400);
        }
    }


    public function deleteAuto($params = null){
        $id = $params[":ID"];
        $autos = $this->model->getById($id);
        if($autos){
            $this->model->delete($id);
            $this->view->response("El id= $id se encontro", 200);
        } else {
            $this->view->response("No se encontro el auto", 404);
        }
    }

    public function editAuto($params = null){
        $id = $params[":ID"];
        $autos = $this->model->getById($id);
        if($autos){
            if(!empty($autos->nombres) || !empty($autos->anio) || !empty($autos->motor) || !empty($autos->marca) || !empty($autos->id_categoria_ext) || !empty($autos->caracteristicas)) {
                $auto = $this->getData(); 
                $nombres = $auto->nombres;
                $anio = $auto->anio;
                $motor = $auto->motor;
                $marca = $auto->marca;
                $id_categoria = $auto->id_categoria_ext;
                $caracteristicas = $auto->caracteristicas;
                
                $this->model->edit($id, $nombres, $anio, $motor, $marca, $id_categoria, $caracteristicas);
                $this->view->response($this->model->getById($id), 201);
                
            } else {
                $this->view->response("Debe completar los datos solicitados!!", 400);
            }
        } else{
            $this->view->response("No se encontro el auto", 404);
        }
    }

    private function verifyField($sort) {
        $whitelist = array (
            0 => "id_auto",
            1 => "nombres",
            2 => "anio",
            3 => "motor",
            4 => "marca",
            5 => "id_categoria_ext",
        );

        return in_array($sort, $whitelist);
    }

    private function verifyValue($value) {
        $whitelist = array (
            0 => "desc",
            1 => "asc",
            2 => "bugatti",
            3 => "BMW",
            4 => "RENAULT",
            5 => "FERRARI",
            6 => "LAMBORGHINI"
        );

        return in_array($value, $whitelist);
    }
}





