Documentacion de la API*** 

Descripcion 
Api tipo REST para ofrecer servicios CRUD, con opcion de Filtrado, Ordenamiento. Acepta Recursos "Autos" y "Categorias". No esta autenticada.

Endpoints
URL: http://localhost/infoautomotriz-rest/api/recurso Metodo: GET 
-Devuelve una coleccion de entidades del recurso especificado.
-Codigo de respuesta: 200 OK, 400 Bad Request

URL: http://localhost/infoautomotriz-rest/api/recurso/id Metodo: GET 
-Si se introduce un parametro ID, devulve un item especifico del recurso solicitado. Devuelve el objeto del item. -Codigo de respuesta: 200 OK, 404 Not Found

URL: http://localhost/infoautomotriz-rest/api/recurso Metodo: POST 
-Permite insertar un nuevo item a la tabla del recurso determinado. Devuelve el ID del ultimo item insertado sin necesidad de introducirle un ID.
-Codigo de respuesta: 201 Created, 400 Bad Request

URL: http://localhost/infoautomotriz-rest/api/recurso/id Método: DELETE 
-Permite borrar un item especifico a travéz de un ID del recurso solicitado. Devuelve el objeto del item eliminado. -Codigo de respuesta: 200 OK, 404 Not Found

URL: http://localhost/infoautomotriz-rest/api/recurso/id Método: PUT 
-Permite modificar un item especifico a travéz de un ID. Devuelve el nuevo objeto modificado del item. 
-Codigo de respuesta: 201 Created, 404 Not Found

URL: http://localhost/infoautomotriz-rest/api/recurso?sort=id&order=desc Método: GET 
-Al introducir los parametros sort y order con valores sort=id y order=desc permite ordenar todos los items del JSON mediante el ID de manera descendente. Si el valor es igual a order=asc ordena de forma ascendente (como estaba en un principio). No se requiere estar autenticado. Por seguridad, si el parametro order no guarda valores igual a 'asc' o 'desc' la api rechazara la solicitud (400 Bad request), al igual que con el parametro Sort: Si la variable es diferente a algunos de los campos de la Base de Datos tambien la API rechazara la solicitud (Ver linea 32 y 33). -Codigo de respuesta: 200 OK, 400 Bad Request

URL: http://localhost/infoautomotriz-rest/api/recurso?value=valor Método: GET 
-Si introducimos el parametro value con valores de la columna, permite filtrar valores que usted desee. SOLO se puede filtrar por el campo Marca (del recurso autos) y el campo Caracteristicas (del recurso categorias). Como sucede con el ordenar, solo se puede filtrar valores especificos que se encuentren en ese campo, si no la API rechazara la solicitud (Ver linea 34). En caso del recurso categoria, las caracteristicas se buscan por palabras claves, pero no cualquiera, si no las que se permiten (Ver linea 35). 
-Codigo de respuesta: 200 OK, 400 Bad request

-Campos del recurso Autos: id_auto, nombres, anio, motor, marca, id_categoria_ext, caracteristicas.
-Campos del recurso Categorias: id_categoria, nombre, caracteristicas. 
-Valores del campo Marca del recurso Autos: Bugatti, BMW, Renault, Ferrari, Lamborghini. 
-Palabras clave del campo Caracteristicas del recurso Categoria: mejor, aceleracion.