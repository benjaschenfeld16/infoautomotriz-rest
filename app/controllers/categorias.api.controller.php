<?php
require_once "./app/models/categorias.api.model.php";
require_once "./app/views/motor.api.view.php";

class CategoriasApiController{

    private $view;
    private $model;
    private $data;

    public function __construct(){
        $this->view = new MotorApiView();
        $this->model = new CategoriasApiModel();

        $this->data = file_get_contents("php://input");
    }

    public function getData(){
        return json_decode($this->data);
    }


    public function getCategorias(){
        if(isset($_GET['value']) && !empty($_GET['value'])) {
            $value = $_GET['value'];
            $categorias = $this->model->getAllByFilter($value);
            if($this->verifyValue($value)) {
                if($categorias) {
                    $this->view->response($categorias, 200);
                } else {
                    $this->view->response("No se puedo filtrar", 400);
                }
            } else {
                $this->view->response("El valor ingresado no es valido", 400);
            }
        } else if(isset($_GET['sort']) && !empty($_GET['sort']) && isset($_GET['order']) && !empty($_GET['order'])) {
            $sort = $_GET['sort'];
            $order = $_GET['order'];
            if($this->verifyField($sort) && $this->verifyValue($order)) {
                $categorias = $this->model->getAllByOrder($sort, $order);
                if($categorias){
                    $this->view->response($categorias, 200);
                } else {
                    $this->view->response("No se pudo ordenar", 400);
                }
            } else {
                $this->view->response("El campo o el valor ingresado no son validos", 400);
            }
        } else {
            $categorias = $this->model->getAll();
            if($categorias){
                $this->view->response($categorias, 200);
            }
            else{
                $this->view->response("No se encontro el recurso solicitado", 400);
            }
        }
    }

    public function getCategoriaById($params = null) {
        $id = $params[":ID"];
        $categoria = $this->model->getById($id);
        if($categoria) {
            $this->view->response($categoria, 200);
        } else {
            $this->view->response("No se pudo encontrar el auto solicitado", 404);
        }
    }

    public function addCategoria($params = null){
        $categorias = $this->getData();
        if(!empty($categorias->nombre) || !empty($categorias->caracteristicas)){
            $id = $this->model->add($categorias->nombre, $categorias->caracteristicas);
            if($id) {
                $categorias = $this->model->getById($id);
                $this->view->response($categorias , 201);
            } else {
                $this->view->response("No se encontro la categoria", 404);
            }
        } else {
            $this->view->response("Debe completar los datos solicitados!!", 400);
        }
    }

    public function deleteCategoria($params = null){
        $id = $params[":ID"];
        $categorias = $this->model->getById($id);
        if($categorias){
           
            if($this->model->delete($id)) {
                $this->view->response("No se puede eliminar porque debe eliminar los items asociados a la categoria con id = $id primero", 400);
                die();
            } else {
                $this->view->response("El id = $id se elimino correctamente", 200);
            }
        } else {
            $this->view->response("No se encontro el auto", 404);
        }
    }

    public function editCategoria($params = null){
        $id = $params[":ID"];
        $categorias = $this->model->getById($id);
        if($categorias){
            if(!empty($categorias->nombre) || !empty($categorias->caracteristicas)) {
                $categorias = $this->getData(); 
                $nombres = $categorias->nombre;
                $caracteristicas = $categorias->caracteristicas;
                
                $this->model->edit($id, $nombres, $caracteristicas);
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
            0 => "id_categoria",
            1 => "nombre",
            2 => "caracteristicas",
        );

        return in_array($sort, $whitelist);
    }

    private function verifyValue($value) {
        $whitelist = array (
            0 => "desc",
            1 => "asc",
            2 => "aceleracion",
            3 => "mejor"
        );

        return in_array($value, $whitelist);
    }
}
