<?php
require_once '../lib/Slim/Slim.php';
require_once '../db/db_solicitud.php';
require_once '../Conexion.php';

// Autocarga de la librería
\Slim\Slim::registerAutoloader();

// Creando una instancia del Slim
$app = new \Slim\Slim();
$app->response->header('Content-Type', 'application/json');


// GET SOLICITUDES
$app->get('/solicitudes/:usuario', function($dni){  
    $lista = listarSolicitud($dni);    
    echo json_encode($lista);    
});

// GET SOLICITUDES
$app->get('/dsolicitud/:solicitud', function($solicitud){  
    $lista = listarDetalleSolicitud($solicitud);    
    echo json_encode($lista);    
});


$app->post('/solicitud', function () use ($app) { 
registrarsolicitud($_REQUEST['usuario'],$_REQUEST['apellidos'],$_REQUEST['dni'],"Pendiente");
echo json_encode(array('mensaje' => "Solicitud registrado correctamente"));      
});
//Servicio Registrar DetalleSolicitud
$app->post('/detallesolicitud', function () use ($app) { 
registrardetallesolicitud($_REQUEST['id'],$_REQUEST['idsolicitud'],$_REQUEST['descripcion'],$_REQUEST['tipo']);
echo json_encode(array('mensaje' => "Detalle solicitud registrado correctamente"));      
});
//Servicio Actualizar solicitud - Fotos
$app->post('/registrarfoto', function () use ($app) { 
actualizardetallesolicitud($_REQUEST['id'],$_REQUEST['idsolicitud'],$_REQUEST['foto']);
echo json_encode(array('mensaje' => "Foto registrado correctamente"));      
});

$app->run();