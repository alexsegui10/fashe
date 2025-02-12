<?php
    $path = $_SERVER['DOCUMENT_ROOT'] . '/Fashe/';
	include($path . "model/connect.php");

	class DAOShop{
		

		function select_productos_list(){
			$sql = "SELECT * FROM accesorios";
			
			$conexion = connect::con();
			$res = mysqli_query($conexion, $sql);
			
			$array_resultados = array();
			while ($fila = mysqli_fetch_assoc($res)) {
				$array_resultados[] = $fila;
			}
			
			connect::close($conexion);
			
			return $array_resultados;
		}
		
	
		

	}