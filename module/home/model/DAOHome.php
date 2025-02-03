<?php
	$path = $_SERVER['DOCUMENT_ROOT'] . '/Cursos/';
	include($path . "model/connect.php");

	class DAOHome{
		

		function select_productos_precio(){
			// $data = 'hola DAO select_user';
            // die('<script>console.log('.json_encode( $data ) .');</script>');
			$sql = "SELECT * FROM productos ORDER BY precio DESC LIMIT 5";
			
			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion);
            return $res;
		}
		function select_producto_ciudad(){
			// $data = 'hola DAO select_user';
            // die('<script>console.log('.json_encode( $data ) .');</script>');
			$sql = "SELECT * FROM cursos ORDER BY `fecha_inicio` ASC LIMIT 5";
			
			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion);
            return $res;
		}
		
		
	
		

	}