<?php
require_once '../lib/Slim/Slim.php';
require_once '../db/db_usuario.php';
require_once '../Conexion.php';

// Autocarga de la librería
\Slim\Slim::registerAutoloader();

// Creando una instancia del Slim
$app = new \Slim\Slim();
$app->response->header('Content-Type', 'application/json');

// GET USUARIOS
$app->get('/usuarios', function(){  
    $lista = listarUsuarios(); 
    echo json_encode($lista);    
});
$app->get('/usuario/dni/:dni', function($dni){   
    $lista = buscarUsuarioPorDni($dni);    
    echo json_encode($lista);    
});
$app->get('/usuario/correo/:correo', function($correo){   
    $lista = buscarUsuarioPorCorreo($correo);    
    echo json_encode($lista);    
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
echo json_encode(array('mensaje' => "Usuario actualizado correctamente"));      
});

//Servicio Cambiar contrasenia
$app->post('/resetpassword', function () use ($app) { 
cambiarContrasena($_REQUEST['correo'],$_REQUEST['password']);
echo json_encode(array('mensaje' => "Se cambio el password"));      
});

//Eliminar Usuario
$app->post('/eliminarUsuario', function () use ($app) { 
eliminarUsuario($_REQUEST['id']);
echo json_encode(array('mensaje' => "Usuario eliminado correctamente"));      
});
$app->run();