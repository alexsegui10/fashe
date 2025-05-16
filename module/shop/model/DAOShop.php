<?php
    $path = $_SERVER['DOCUMENT_ROOT'] . '/Fashe/';
	include($path . "model/connect.php");

	class DAOShop{
		
		function select_productos_list($offset, $limit, $order){
			$sql = "SELECT a.*, GROUP_CONCAT(i.image SEPARATOR ':') AS imagenes 
			FROM accesorios a 
			LEFT JOIN imagenes i ON a.id_imagen = i.id_producto  
			GROUP BY a.id_accesorio";
			if ($order == "popular") {
				$orderby = " ORDER BY a.popular DESC";
			} elseif ($order == "mayor_menor") {
				$orderby = " ORDER BY a.precio DESC";
			} elseif ($order == "menor_mayor") {
				$orderby = " ORDER BY a.precio ASC";
			} elseif ($order == "rating") {
				$orderby = " ORDER BY a.rating DESC";
			} else {
				$orderby = ""; 
			}
			
			$sql .= $orderby . " LIMIT $offset, $limit;";

			$conexion = connect::con();
			$res = mysqli_query($conexion, $sql);
			connect::close($conexion); 
			$retrArray = array();
			if (mysqli_num_rows($res) > 0) {
				while ($row = mysqli_fetch_assoc($res)) {
					$retrArray[] = array(
						"id_accesorio" => $row["id_accesorio"],
						"name" => $row["name"],
						"descripcion" => $row["descripcion"],
						"precio" => $row["precio"],
						"lon" => $row["lon"],
						"lat" => $row["lat"],
						"imagenes" => explode(":", $row['imagenes'])
					);
				}
			}
			return $retrArray;
		}
		


		function select_count_productos_list(){
			$sql = "SELECT COUNT(*) AS contador FROM accesorios;";
			$conexion = connect::con();
			$res = mysqli_query($conexion, $sql);
			connect::close($conexion); 
			if ($res && mysqli_num_rows($res) > 0) {
				$row = mysqli_fetch_assoc($res);
				return $row["contador"];
			}
			return 0;
		}
		


		function select_details_producto($id){
			$sql = "SELECT accesorios.*,(SELECT m.name marca FROM marcas as m WHERE m.id_marca = $id) as marca ,estados.name as estado FROM accesorios LEFT JOIN estados ON accesorios.id_estado = estados.id_estado where id_accesorio = $id;";
			
			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql)->fetch_object();
            connect::close($conexion);
            return $res;
		}


		function select_city(){
			$sql = "SELECT * , 'ciudades' as tabla, 'select' as tipo FROM ciudades";
			
			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
			$array_resultados = array();
			while ($fila = mysqli_fetch_assoc($res)) {
				$array_resultados[] = $fila;
			}
            connect::close($conexion);
            return $array_resultados;
		}


		function select_marcas(){
			$sql = "SELECT *, 'marcas' as tabla, 'checkbox' as tipo FROM marcas";
			
			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
			$array_resultados = array();
			while ($fila = mysqli_fetch_assoc($res)) {
				$array_resultados[] = $fila;
			}
            connect::close($conexion);
            return $array_resultados;
		}


		function select_estados(){
			$sql = "SELECT *, 'estados' as tabla, 'select' as tipo FROM estados";
			
			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
			$array_resultados = array();
			while ($fila = mysqli_fetch_assoc($res)) {
				$array_resultados[] = $fila;
			}
            connect::close($conexion);
            return $array_resultados;
		}


		function select_all_categorias(){
			$sql = "SELECT * , 'categorias' as tabla, 'select' as tipo FROM categorias";
			
			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
			$array_resultados = array();
			while ($fila = mysqli_fetch_assoc($res)) {
				$array_resultados[] = $fila;
			}
            connect::close($conexion);
            return $array_resultados;
		}


		
		function select_tipo_formato(){
			$sql = "SELECT * FROM tipo_formato";
			
			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
			$array_resultados = array();
			while ($fila = mysqli_fetch_assoc($res)) {
				$array_resultados[] = $fila;
			}
            connect::close($conexion);
            return $array_resultados;
		}




		function select_images_producto($id){
			$sql = "SELECT image FROM imagenes WHERE id_producto = $id";
			
			$conexion = connect::con();
			$res = mysqli_query($conexion, $sql);
			
			$array_resultados = array();
			while ($fila = mysqli_fetch_assoc($res)) {
				$array_resultados[] = $fila;
			}
			
			connect::close($conexion);
			
			return $array_resultados;
		}
		function select_categorias($id){
			$sql = "SELECT DISTINCT c.id_categoria, c.name, c.image FROM categorias c JOIN accesorios_categorias ac ON c.id_categoria = ac.id_categoria WHERE ac.id_accesorio = $id";
			
			$conexion = connect::con();
			$res = mysqli_query($conexion, $sql);
			
			$array_resultados = array();
			while ($fila = mysqli_fetch_assoc($res)) {
				$array_resultados[] = $fila;
			}
			
			connect::close($conexion);
			
			return $array_resultados;
		}
		
		function print_filters() {
			 $select = "SELECT * FROM accesorios";
			 $conexion = connect::con();
			 $res = mysqli_query($conexion, $select);
			 connect::close($conexion);
	
			 $retrArray = array();
			 if ($res -> num_rows > 0) {
				 while ($row = mysqli_fetch_assoc($res)) {
					 $retrArray[] = $row;
				 } 
			 }
			 return $retrArray;
		}
	
		function filters($filter, $offset, $limit, $order){
			$consulta = "SELECT a.*, GROUP_CONCAT(i.image SEPARATOR ':') AS imagenes 
			FROM accesorios a 
			LEFT JOIN imagenes i ON a.id_imagen = i.id_producto";
		
			for ($i = 0; $i < count($filter); $i++) {
				if ($i == 0) {
					if ($filter[$i][0] == "id_marca") {
						$values = implode("', '", $filter[$i][1]);
						$consulta .= " WHERE a." . $filter[$i][0] . " IN (
							SELECT " . $filter[$i][2] . "." . $filter[$i][0] . " 
							FROM " . $filter[$i][2] . " 
							WHERE " . $filter[$i][2] . ".name IN ('" . $values . "'))";
					} else {
						$consulta .= " WHERE a." . $filter[$i][0] . " = (
							SELECT " . $filter[$i][2] . "." . $filter[$i][0] . " 
							FROM " . $filter[$i][2] . " 
							WHERE " . $filter[$i][2] . ".name = '" . $filter[$i][1] . "' )";
					}
				} else {
					if ($filter[$i][0] == "id_marca") {
						$values = implode("', '", $filter[$i][1]);
						$consulta .= " AND a." . $filter[$i][0] . " IN (
							SELECT " . $filter[$i][2] . "." . $filter[$i][0] . " 
							FROM " . $filter[$i][2] . " 
							WHERE " . $filter[$i][2] . ".name IN ('" . $values . "'))";
					} else {
						$consulta .= " AND a." . $filter[$i][0] . " = (
							SELECT " . $filter[$i][2] . "." . $filter[$i][0] . " 
							FROM " . $filter[$i][2] . " 
							WHERE " . $filter[$i][2] . ".name = '" . $filter[$i][1] . "' )";
					}
				}
			}
		
			$consulta .= " GROUP BY a.id_accesorio ";

			if ($order == "popular") {
				$orderby = " ORDER BY a.popular DESC";
			} elseif ($order == "mayor_menor") {
				$orderby = " ORDER BY a.precio DESC";
			} elseif ($order == "menor_mayor") {
				$orderby = " ORDER BY a.precio ASC";
			} elseif ($order == "rating") {
				$orderby = " ORDER BY a.rating DESC";
			} else {
				$orderby = "";
			}
			
			$consulta .= $orderby . " LIMIT $offset, $limit;";
			$conexion = connect::con();
			$res = mysqli_query($conexion, $consulta);
			connect::close($conexion);
			$retrArray = array();
			if (mysqli_num_rows($res) > 0) {
				while ($row = mysqli_fetch_assoc($res)) {
					$retrArray[] = array(
						"id_accesorio" => $row["id_accesorio"],
						"name" => $row["name"],
						"descripcion" => $row["descripcion"],
						"precio" => $row["precio"],
						"lon" => $row["lon"],
						"lat" => $row["lat"],
						"imagenes" => explode(":", $row['imagenes'])
					);
				}
			}
			return $retrArray;
		}
		



		
		function update_categoria_visitados($id) {
			$conexion = connect::con();
			$id = mysqli_real_escape_string($conexion, $id);
			$update_sql = "UPDATE categorias SET visitado = visitado + 1 WHERE name = '$id'";
			mysqli_query($conexion, $update_sql);
			connect::close($conexion);
		}



		function añadir_popularidad($id) {
			$conexion = connect::con();
			$update_sql = "UPDATE accesorios SET popular = popular + 1 WHERE id_accesorio = $id;";
			mysqli_query($conexion, $update_sql);
			connect::close($conexion);
		}



		function añadir_rating($id, $rating) {
			$conexion = connect::con();
			$update_sql = "UPDATE accesorios SET rating = $rating WHERE id_accesorio = $id;";
			mysqli_query($conexion, $update_sql);
			connect::close($conexion);
		}
		

		function count_filters($filter){
			$consulta = "SELECT COUNT(DISTINCT a.id_accesorio) AS contador
			FROM accesorios a ";
		
			if (!empty($filter)) {
				$consulta .= "LEFT JOIN imagenes i ON a.id_imagen = i.id_producto ";
			}
		
			for ($i = 0; $i < count($filter); $i++) {
				if ($i == 0) {
					if ($filter[$i][0] == "id_marca") {
						$values = implode("', '", $filter[$i][1]);
						$consulta .= " WHERE a." . $filter[$i][0] . " IN (
							SELECT " . $filter[$i][2] . "." . $filter[$i][0] . "
							FROM " . $filter[$i][2] . "
							WHERE " . $filter[$i][2] . ".name IN ('" . $values . "'))";
					} else {
						$consulta .= " WHERE a." . $filter[$i][0] . " = (
							SELECT " . $filter[$i][2] . "." . $filter[$i][0] . "
							FROM " . $filter[$i][2] . "
							WHERE " . $filter[$i][2] . ".name = '" . $filter[$i][1] . "')";
					}
				} else {
					if ($filter[$i][0] == "id_marca") {
						$values = implode("', '", $filter[$i][1]);
						$consulta .= " AND a." . $filter[$i][0] . " IN (
							SELECT " . $filter[$i][2] . "." . $filter[$i][0] . "
							FROM " . $filter[$i][2] . "
							WHERE " . $filter[$i][2] . ".name IN ('" . $values . "'))";
					} else {
						$consulta .= " AND a." . $filter[$i][0] . " = (
							SELECT " . $filter[$i][2] . "." . $filter[$i][0] . "
							FROM " . $filter[$i][2] . "
							WHERE " . $filter[$i][2] . ".name = '" . $filter[$i][1] . "')";
					}
				}
			}
		
			$conexion = connect::con();
			$res = mysqli_query($conexion, $consulta);
			connect::close($conexion);
		
			if ($res && mysqli_num_rows($res) > 0) {
				$row = mysqli_fetch_assoc($res);
				return $row["contador"];
			}
		
			return 0;
		}
		

		function select_extras_icono($id){
			$sql = "SELECT * FROM extras e JOIN accesorios_extras ae ON e.id_extra = ae.id_extra WHERE ae.id_accesorio = $id;";
			$conexion = connect::con();
			$res = mysqli_query($conexion, $sql);
			
			$array_resultados = array();
			while ($fila = mysqli_fetch_assoc($res)) {
				$array_resultados[] = $fila;
			}
			
			connect::close($conexion);
			
			return $array_resultados;
		}



		function select_accesorios_relacionados($id, $offset, $limit) {
			$sql = "SELECT 
						a.*, 
						i.image AS imagen_principal, 
						c.name as categoria
					FROM 
						accesorios a
					LEFT JOIN 
						imagenes i 
						ON i.id_imagen = (
							SELECT MIN(id_imagen) 
							FROM imagenes 
							WHERE id_producto = a.id_accesorio
						)
					JOIN 
						categorias c 
						ON a.id_categoria = c.id_categoria
					WHERE 
						a.id_categoria = (
							SELECT id_categoria 
							FROM accesorios 
							WHERE id_accesorio = $id
						)
						AND a.id_accesorio != $id
					LIMIT $limit OFFSET $offset";
		
			$conexion = connect::con();
			$res = mysqli_query($conexion, $sql);
		
			$array_resultados = array();
			while ($fila = mysqli_fetch_assoc($res)) {
				$array_resultados[] = $fila;
			}
		
			connect::close($conexion);
		
			return $array_resultados;
		}


		function select_complementos_relacionados($id, $offset, $limit) {
			$sql = "SELECT * FROM `complementos` c INNER JOIN accesorios_complemento ac ON c.id_complemento = ac.id_complemento WHERE ac.id_accesorio = $id LIMIT $limit OFFSET $offset";
		
			$conexion = connect::con();
			$res = mysqli_query($conexion, $sql);
		
			$array_resultados = array();
			while ($fila = mysqli_fetch_assoc($res)) {
				$array_resultados[] = $fila;
			}
		
			connect::close($conexion);
		
			return $array_resultados;
		}
		function count_complementos_relacionados($id) {
			$sql = "SELECT COUNT(*) AS total FROM `complementos` c INNER JOIN accesorios_complemento ac ON c.id_complemento = ac.id_complemento WHERE ac.id_accesorio = $id";
		
			$conexion = connect::con();
			$res = mysqli_query($conexion, $sql);
			
			$total = 0;
			if ($fila = mysqli_fetch_assoc($res)) {
				$total = $fila['total'];
			}
			
			connect::close($conexion);
			
			return $total;
		}


		function contar_accesorios_relacionados($id) {
			$sql = "SELECT COUNT(*) AS total 
					FROM accesorios 
					WHERE id_categoria = (SELECT id_categoria FROM accesorios WHERE id_accesorio = $id) 
					AND id_accesorio != $id;";
			
			$conexion = connect::con();
			$res = mysqli_query($conexion, $sql);
			
			$total = 0;
			if ($fila = mysqli_fetch_assoc($res)) {
				$total = $fila['total'];
			}
			
			connect::close($conexion);
			
			return $total;
		}


    // Comprueba si ya existe el like para este accesorio y usuario (por correo)
    public function select_like(int $id_accesorio, string $correo) {
        $conexion = connect::con();
        $correo_esc = mysqli_real_escape_string($conexion, $correo);
        $sql = "
            SELECT id_accesorio
              FROM likes
             WHERE id_accesorio = $id_accesorio
               AND correo        = '$correo_esc'
        ";
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    public function add_like(int $id_accesorio, string $correo): bool {
        $conexion = connect::con();
        $correo_esc = mysqli_real_escape_string($conexion, $correo);
        $sql = "
            INSERT IGNORE INTO likes (id_accesorio, correo)
            VALUES ($id_accesorio, '$correo_esc')
        ";
        $ok = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $ok;
    }

    public function remove_like(int $id_accesorio, string $correo): bool {
        $conexion = connect::con();
        $correo_esc = mysqli_real_escape_string($conexion, $correo);
        $sql = "
            DELETE FROM likes
             WHERE id_accesorio = $id_accesorio
               AND correo        = '$correo_esc'
        ";
        $ok = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $ok;
    }

    // Cuenta likes de un accesorio
    public function count_likes(int $id_accesorio): int {
        $conexion = connect::con();
        $sql = "
            SELECT COUNT(*) AS contador
              FROM likes
             WHERE id_accesorio = $id_accesorio
        ";
        $res  = mysqli_query($conexion, $sql);
        $fila = mysqli_fetch_assoc($res);
        connect::close($conexion);
        return isset($fila['contador']) ? (int)$fila['contador'] : 0;
    }

    // (Opcional) Método para cargar todos los likes de un usuario
    public function select_likes_usuario(string $correo): array {
        $conexion   = connect::con();
        $correo_esc = mysqli_real_escape_string($conexion, $correo);
        $sql = "
            SELECT id_accesorio
              FROM likes
             WHERE correo = '$correo_esc'
        ";
        $res = mysqli_query($conexion, $sql);
        $likes = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $likes[] = $row;
        }
        connect::close($conexion);
        return $likes;
    }

		
	}