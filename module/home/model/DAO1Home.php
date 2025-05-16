<?php
    $path = $_SERVER['DOCUMENT_ROOT'] . '/Fashe/';
	include($path . "model/connect.php");

	class DAOHome{
		

		function select_productos_precio(){
			$sql = "SELECT m.name, m.image,(SELECT COUNT(c.id_accesorio) FROM accesorios as c WHERE c.id_marca = m.id_marca ) as nproductos FROM `marcas` as m limit 6;";
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


		function select_categorias_visitado(){
			$sql = "SELECT * FROM categorias ORDER BY visitado DESC;";
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
			$sql = "SELECT c.name, c.image,(SELECT COUNT(a.id_accesorio) FROM accesorios as a WHERE a.id_ciudad = c.id_ciudad ) as nproductos FROM `ciudades` as c;";
			$conexion = connect::con();
			$res = mysqli_query($conexion, $sql);
			$array_resultados = array();
			while ($fila = mysqli_fetch_assoc($res)) {
				$array_resultados[] = $fila;
			}
			connect::close($conexion);
			return $array_resultados;
		}


		function select_rating(){
			$sql = "SELECT * FROM `accesorios` ORDER BY rating DESC;";
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
	