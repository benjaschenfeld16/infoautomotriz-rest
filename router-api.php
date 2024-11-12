<?php
require_once "./libs/Router.php";
require_once "./app/controllers/autos.api.controller.php";
require_once "./app/controllers/categorias.api.controller.php";

$router = new Router();


$router->addRoute('autos', 'GET', 'AutosApiController', 'getAutos');
$router->addRoute('autos/:ID', 'GET', 'AutosApiController', 'getAutoById');
$router->addRoute('autos/:ID', 'DELETE', 'AutosApiController', 'deleteAuto');
$router->addRoute('autos', 'POST', 'AutosApiController', 'addAuto');
$router->addRoute('autos/:ID', 'PUT', 'AutosApiController', 'editAuto');

$router->addRoute('categorias', 'GET', 'CategoriasApiController', 'getCategorias');
$router->addRoute('categorias/:ID', 'GET', 'CategoriasApiController', 'getCategoriaById');
$router->addRoute('categorias/:ID', 'DELETE', 'CategoriasApiController', 'deleteCategoria');
$router->addRoute('categorias', 'POST', 'CategoriasApiController', 'addCategoria');
$router->addRoute('categorias/:ID', 'PUT', 'CategoriasApiController', 'editCategoria');


$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);