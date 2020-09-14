<?php
require_once './lib/Slim/Slim.php';
require_once 'funciones.php';
require_once 'Conexion.php';

// Autocarga de la librería
\Slim\Slim::registerAutoloader();

// Creando una instancia del Slim
$app = new \Slim\Slim();
$app->response->header('Content-Type', 'application/json');

// Servicio 1
$app->get('/usuarios', function(){  
    $lista = listarUsuarios();    
    echo json_encode($lista);    
});

// Servicio 2
$app->get('/usuario/:dni', function($dni){   
    $lista = buscarUsuarioPorDni($dni);    
    echo json_encode($lista);    
});

//Servicio Validar nuevo usuario
$app->get('/existecorreo/:correo', function($correo){   
    $mensaje = existecorreo($correo);    
    echo json_encode($mensaje);  
});

// Servicio Crear nuevo usuario
$app->post('/usuarios', function () use ($app) { 
   insertarUsuario($_REQUEST['nombres'],
    $_REQUEST['apellidos'],
     $_REQUEST['correo'],
      $_REQUEST['dni'],
       null,
        $_REQUEST['password'],
         0,
          "usuario",
           "activo");
echo json_encode(array('mensaje' => "Usuario registrado satisfactoriamente"));      
});

//Servicio ModificarUsuario
$app->post('/modificarUsuario', function () use ($app) { 
actualizarViviendaDelUsuario($_REQUEST['id'],$_REQUEST['idvivienda']);
echo json_encode(array('mensaje' => "Vivienda asignado correctamente"));      
});

//Servicio registrar vivienda (UNIR CON MODIFICAR USUARIO)
$app->post('/nuevavivienda', function () use ($app) { 
registrarvivienda($_REQUEST['direccion'],$_REQUEST['latitud'],$_REQUEST['longitud']);
echo json_encode(array('mensaje' => "Vivienda registrado correctamente"));      
});

//Servicio ModificarUsuario
$app->post('/eliminarUsuario', function () use ($app) { 
eliminarUsuario($_REQUEST['id']);
echo json_encode(array('mensaje' => "Usuario eliminado correctamente"));      
});
//Servicio Registrar Solicitud
$app->post('/registrarsolicitud', function () use ($app) { 
registrarsolicitud($_REQUEST['usuario'],$_REQUEST['apellidos'],$_REQUEST['dni'],"Pendiente");
echo json_encode(array('mensaje' => "Solicitud registrado correctamente"));      
});
//Servicio Registrar DetalleSolicitud
$app->post('/registrardetallesolicitud', function () use ($app) { 
registrardetallesolicitud($_REQUEST['idsolicitud'],$_REQUEST['tipo']);
echo json_encode(array('mensaje' => "Detalle solicitud registrado correctamente"));      
});
//Servicio Actualizar solicitud - Fotos
$app->post('/registrarfoto', function () use ($app) { 
actualizardetallesolicitud($_REQUEST['iddetalle'],$_REQUEST['foto']);
echo json_encode(array('mensaje' => "Foto registrado correctamente"));      
});
$id, $foto
// Servicio 4
$app->get('/avisos', function(){  
    $lista = listarAvisos();    
    echo json_encode($lista);    
});


// Servicio 5
$app->get('/avisos/:fecha', function($fecha){  
    $lista = buscarAvisos($fecha);    
    echo json_encode($lista);    
});


// Servicio 6
$app->post('/avisos', function() use ($app){     
   /*
   $request = $app->request();
   $body = $request->getBody();
   $data = json_decode($body);       
   insertarAviso($data->titulo, $data->fecha_inicio, $data->fecha_fin);
   */
   $titulo = $app->request()->post('titulo');
   $fecha_inicio = $app->request()->post('fecha_inicio');
   $fecha_fin = $app->request()->post('fecha_fin');
   insertarAviso($titulo, $fecha_inicio, $fecha_fin);
   echo json_encode(array('mensaje' => "Aviso registrado!"));    
});


$app->run();