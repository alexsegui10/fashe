<?php
    $path = $_SERVER['DOCUMENT_ROOT'] . '/Fashe/';
	include($path . "model/connect.php");

	class DAOHome{
		

		function select_productos_precio(){
			$sql = "SELECT * FROM marcas";
			$conexion = connect::con();
			$res = mysqli_query($conexion, $sql);
			$array_resultados = array();
			while ($fila = mysqli_fetch_assoc($res)) {
				$array_resultados[] = $fila;
			}
			connect::close($conexion);
			return $array_resultados;
		}


		function select_categorias(){
			$sql = "SELECT * FROM categorias limit 3";
			$conexion = connect::con();
			$res = mysqli_query($conexion, $sql);
			$array_resultados = array();
			while ($fila = mysqli_fetch_assoc($res)) {
				$array_resultados[] = $fila;
			}
			connect::close($conexion);
			return $array_resultados;
		}

		function select_producto_ciudad(){
			$sql = "SELECT * FROM ciudades ";
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