	<?php
	//namespace Espacio\De\Nombres;
	class Conexion {

		static private $instance;
		
		/**
		* @return PDO Return a PDO instance representing a connection to a database
		*/
		public static function getConexion() {
			
			if(self::$instance == NULL){           
				$PDOinstance = new PDO("mysql:host=fdb29.awardspace.net;dbname=3573148_checkhousedb;charset=utf8", "3573148_checkhousedb", "T.uL8l)K8h+s^%2B");
				$PDOinstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$instance = $PDOinstance;
			}
			return self::$instance;
			
		}
		
	}
