<?php    
function listarSolicitud($usuario){	
	try { 	
		$db = Conexion::getConexion();
		$stmt = $db->prepare("select * from solicitud where usuario=:usuario");
		$stmt->bindValue(1, "%$usuario%", PDO::PARAM_STR);
		$stmt->execute(array(':usuario'=>$usuario));
		$solicitud = $stmt->fetchAll(PDO::FETCH_ASSOC);	
		$arreglo = array();
		foreach($solicitud as $fila) {			
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
		return $arreglo;
		
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}		
}

function listarSolicitudEvaluar($banco){	
	try { 	
		$db = Conexion::getConexion();
		//select * from solicitud where banco="Interbank" and estado="Evaluar"
		$stmt = $db->prepare("select * from solicitud where banco=:banco and estado='Evaluar'");
		$stmt->bindValue(1, "%$banco%", PDO::PARAM_STR);
		$stmt->execute(array(':banco'=>$banco));
		$solicitud = $stmt->fetchAll(PDO::FETCH_ASSOC);	
		$arreglo = array();
		foreach($solicitud as $fila) {			
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
		return $arreglo;
		
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}		
}

function listarDetalleSolicitud($idsolicitud){	
	try { 	
		$db = Conexion::getConexion();
		$stmt = $db->prepare("select id, idsolicitud, TO_BASE64(foto) as foto , descripcion ,tipo from detallesolicitud where idsolicitud = $idsolicitud");
		$stmt->bindValue(1, "%$idsolicitud%", PDO::PARAM_STR);

		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);		
		$arreglo = array();
		foreach($filas as $fila) {			
			$elemento = array();
			$elemento['id'] = $fila['id'];
			$elemento['idsolicitud'] = $fila['idsolicitud'];
			$elemento['foto'] = $fila['foto'];
			$elemento['descripcion'] = $fila['descripcion'];
			$elemento['tipo'] = $fila['tipo'];
			$arreglo[] = $elemento;
		}
		return $arreglo;
		
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}		
}

function obtenerultimasolicitud(){	
	try { 	
		$db = Conexion::getConexion();
		$stmt = $db->prepare("select * from solicitud order by id desc limit 1");
		$stmt->bindValue(1, "%$idsolicitud%", PDO::PARAM_STR);

		$stmt->execute();
		$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);		
		$arreglo = array();
		foreach($filas as $fila) {			
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
		return $filas[0];
		
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}		
}

function registrarsolicitud($usuario, $nombres, $apellidos, $dni, $banco, $estado){
	try { 
		$db = Conexion::getConexion();			
		$stmt = $db->prepare("insert into solicitud (usuario, nombres, apellidos, dni, banco, estado) values (?,?,?,?,?,?)");
		$datos = array($usuario, $nombres, $apellidos, $dni, $banco, $estado);
		$db->beginTransaction();
		$stmt->execute($datos);
		$db->commit();
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}		
}

function registrardetallesolicitud($id,$idsolicitud, $descripcion ,$tipo){
	try { 
		$db = Conexion::getConexion();			
		$stmt = $db->prepare("insert into detallesolicitud (id, idsolicitud, descripcion,tipo) values (?,?,?,?)");
		$datos = array($id,$idsolicitud, $descripcion ,$tipo);
		$db->beginTransaction();
		$stmt->execute($datos);
		$db->commit();
	} catch (PDOException $e) {
		$db->rollback();
		$mensaje  = '<b>Consulta inválida:</b> ' . $e->getMessage() . "<br/>";
		die($mensaje);
	}		
}

function actualizardetallesolicitud($id,$idsolicitud, $foto){
	try { 
		$db = Conexion::getConexion();		
		$stmt = $db->prepare("update detallesolicitud set foto=? where id=? and idsolicitud=?");
		$datos = array(base64_decode($foto),$id,$idsolicitud);
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