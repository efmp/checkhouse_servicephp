<?php
    



function listarSolicitud($usuario){	
	try { 	
		$db = Conexion::getConexion();
		$stmt = $db->prepare("select * from solicitud where usuario=:usuario");
		$stmt->bindValue(1, "%$usuario%", PDO::PARAM_STR);
		$stmt->execute(array(':usuario'=>$usuario));
		$users = $stmt->fetchAll(PDO::FETCH_ASSOC);	
		$arreglo = array();
		foreach($users as $fila) {			
			$elemento['id'] = $fila['id'];
			$elemento['usuario'] = $fila['usuario'];
			$elemento['nombres'] = $fila['nombres'];
			$elemento['apellidos'] = $fila['apellidos'];
			$elemento['dni'] = $fila['dni'];
			$elemento['vivienda'] = $fila['vivienda'];
			$elemento['banco'] = $fila['banco'];
			$elemento['estado'] = $fila['estado'];
			$arreglo[] = $elemento;
		}
		return $users;
		
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}		
}

function listarDetalleSolicitud($idsolicitud){	
	try { 	
		$db = Conexion::getConexion();
		$stmt = $db->prepare("select * from detallesolicitud where idsolicitud=:idsolicitud");
		$stmt->bindValue(1, "%$idsolicitud%", PDO::PARAM_STR);
		$stmt->execute(array(':idsolicitud'=>$usuario));
		$users = $stmt->fetchAll(PDO::FETCH_ASSOC);	
		$arreglo = array();
		foreach($users as $fila) {			
			$elemento['id'] = $fila['id'];
			$elemento['idsolicitud'] = $fila['idsolicitud'];
			$elemento['foto'] = $fila['foto'];
			$elemento['descripcion'] = $fila['descripcion'];
			$elemento['tipo'] = $fila['tipo'];
			$arreglo[] = $elemento;
		}
		return $users;
		
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}		
}


function buscarUsuarioPorDni($dni){	
	try { 	
		$db = Conexion::getConexion();
		$stmt = $db->prepare("select * from usuario where dni like ?");
		$stmt->bindValue(1, "%$dni%", PDO::PARAM_STR);

		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);		
		$arreglo = array();
		foreach($filas as $fila) {			
			$elemento = array();
			$elemento['id'] = $fila['id'];
			$elemento['nombres'] = $fila['nombres'];
			$elemento['apellidos'] = $fila['apellidos'];
			$elemento['correo'] = $fila['correo'];
			$elemento['dni'] = $fila['dni'];
			$elemento['idvivienda'] = $fila['idvivienda'];
			$elemento['password'] = $fila['password'];
			$elemento['intentos'] = $fila['intentos'];
			$elemento['tipo'] = $fila['tipo'];
			$elemento['estado'] = $fila['estado'];
			$arreglo[] = $elemento;
		}
		return $arreglo;
		
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}		
}





function buscarUsuarioPorCorreo($correo){	
	try { 	
		$db = Conexion::getConexion();
		$stmt = $db->prepare("select * from usuario where correo=:correo");
		$stmt->bindValue(1, "%$correo%", PDO::PARAM_STR);
		$stmt->execute(array(':correo'=>$correo));

		$users = $stmt->fetchAll(PDO::FETCH_ASSOC);	

		$arreglo = array();
		foreach($users as $fila) {			
			$elemento = array();
			$elemento['id'] = $fila['id'];
			$elemento['nombres'] = $fila['nombres'];
			$elemento['apellidos'] = $fila['apellidos'];
			$elemento['correo'] = $fila['correo'];
			$elemento['dni'] = $fila['dni'];
			$elemento['idvivienda'] = $fila['idvivienda'];
			$elemento['password'] = $fila['password'];
			$elemento['intentos'] = $fila['intentos'];
			$elemento['tipo'] = $fila['tipo'];
			$elemento['estado'] = $fila['estado'];
			$elemento['empresa'] = $fila['empresa'];
			$arreglo[] = $elemento;
		}
		return $users[0];
		
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}		
}

function existecorreo($correo){	
	try { 	
		$db = Conexion::getConexion();
		$stmt = $db->prepare("select * from usuario where correo=:correo");
		$stmt->bindValue(1, "%$correo%", PDO::PARAM_STR);
                $stmt->execute(array(':correo'=>$correo));
		$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
               
		$total =  $stmt->rowCount();
                
                $estado = "false";
                if($total>0){
			$estado = "true";
		}else{
			$estado = "false";
		}
		return $estado;
		
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}		
}


function insertarUsuario($nombres, $apellidos, $correo, $dni, $idvivienda, $password, $intentos, $tipo, $estado){
	try { 
		$db = Conexion::getConexion();			
		$stmt = $db->prepare("insert into usuario (nombres, apellidos, correo, dni, idvivienda, password, intentos, tipo, estado) values (?,?,?,?,?,?,?,?,?)");
		$datos = array($nombres, $apellidos, $correo,
					   $dni, $idvivienda, $password,
					   $intentos, $tipo, $estado);
		$db->beginTransaction();
		$stmt->execute($datos);
		$db->commit();
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}		
}

function actualizarViviendaDelUsuario($id, $idvivienda){
	try { 
		$db = Conexion::getConexion();		
		$stmt = $db->prepare("update producto set idvivienda=? where id=?");
		$datos = array($idvivienda, $id);
		$db->beginTransaction();						
		$stmt->execute($datos);			
		$db->commit();
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}	
}


function eliminarUsuario($id){
	try { 
		$db = Conexion::getConexion();  
		$stmt = $db->prepare("delete from usuario where id=?");
		$datos = array($id);
		$db->beginTransaction();			
		$stmt->execute($datos);			
		$db->commit();
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}	
}

function registrarvivienda($direccion, $latitud, $longitud){
	try { 
		$db = Conexion::getConexion();			
		$stmt = $db->prepare("insert into vivienda (direccion, latitud, longitud) values (?,?,?)");
		$datos = array($direccion, $latitud, $longitud);
		$db->beginTransaction();
		$stmt->execute($datos);
		$db->commit();
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}		
}


function registrarsolicitud($usuario, $nombres, $apellidos, $dni, $estado){
	try { 
		$db = Conexion::getConexion();			
		$stmt = $db->prepare("insert into solicitud (usuario, nombres, apellidos, dni, estado) values (?,?,?,?,?)");
		$datos = array($usuario, $nombres, $apellidos, $dni, $estado);
		$db->beginTransaction();
		$stmt->execute($datos);
		$db->commit();
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}		
}

function registrardetallesolicitud($idsolicitud, $tipo){
	try { 
		$db = Conexion::getConexion();			
		$stmt = $db->prepare("insert into detallesolicitud (idsolicitud, tipo) values (?,?)");
		$datos = array($idsolicitud, $tipo);
		$db->beginTransaction();
		$stmt->execute($datos);
		$db->commit();
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}		
}

function actualizardetallesolicitud($id, $foto){
	try { 
		$db = Conexion::getConexion();		
		$stmt = $db->prepare("update producto set foto=? where id=?");
		$datos = array($foto, $id);
		$db->beginTransaction();						
		$stmt->execute($datos);			
		$db->commit();
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}	
}


function listarAvisos(){	
	try { 	
		$db = Conexion::getConexion();
		$stmt = $db->prepare("select * from aviso");
		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$arreglo = array();
		foreach($filas as $fila) {			
		    $elemento = array();
			$elemento['id_aviso'] = $fila['id_aviso'];
			$elemento['titulo'] = $fila['titulo'];
			$elemento['fecha_inicio'] = $fila['fecha_inicio'];
			$elemento['fecha_fin'] = $fila['fecha_fin'];
			$elemento['estado'] = $fila['estado'];
			$elemento['id_usuario'] = $fila['id_usuario'];
			
			$arreglo[] = $elemento;
		}
		return $arreglo;
		
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}		
}

function buscarAvisos($fecha){	
	try { 	
		$db = Conexion::getConexion();
		$stmt = $db->prepare("select * from aviso where ? between fecha_inicio and fecha_fin");
		$stmt->bindValue(1, $fecha, PDO::PARAM_STR);

		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);		
		$arreglo = array();
		foreach($filas as $fila) {			
			$elemento = array();
			$elemento['titulo'] = $fila['titulo'];
			$elemento['fecha_inicio'] = $fila['fecha_inicio'];
			$elemento['fecha_fin'] = $fila['fecha_fin'];
			$elemento['estado'] = $fila['estado'];
                        $arreglo[] = $elemento;
		}
		return $arreglo;
		
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}		
}


function insertarAviso($titulo, $fecha_inicio, $fecha_fin){
	try { 
		$db = Conexion::getConexion();			
		$stmt = $db->prepare("insert into aviso (titulo,fecha_inicio,fecha_fin,estado) values (?,?,?,'1')");
		$datos = array($titulo, $fecha_inicio, $fecha_fin);
		$db->beginTransaction();
		$stmt->execute($datos);
		$db->commit();
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}		
}

?>