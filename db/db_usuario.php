<?php    
function listarUsuarios(){	
	try { 	
		$db = Conexion::getConexion();
		$stmt = $db->prepare("select * from usuario");
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
			$elemento['empresa'] = $fila['empresa'];
			$arreglo[] = $elemento;
		}
		return $arreglo;
		
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

function actualizarViviendaDelUsuario($id, $idvivienda){
	try { 
		$db = Conexion::getConexion();		
		$stmt = $db->prepare("update vivienda set idvivienda=? where id=?");
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

function cambiarContrasena($correo, $password){
	try { 
		$db = Conexion::getConexion();		
		$stmt = $db->prepare("update usuario set password=? where correo=?");
		$datos = array($password, $correo);
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