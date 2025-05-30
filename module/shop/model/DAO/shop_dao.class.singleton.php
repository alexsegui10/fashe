<?php
class shop_dao {
    static $_instance;
    private function __construct() {}
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function select_productos_list($db, $offset, $limit, $order) {
        $sql = "SELECT a.*, GROUP_CONCAT(i.image SEPARATOR ':') AS imagenes
                FROM accesorios a
                LEFT JOIN imagenes i ON a.id_imagen = i.id_producto
                GROUP BY a.id_accesorio";
        switch($order) {
            case 'popular':
                $sql .= ' ORDER BY a.popular DESC';
                break;
            case 'mayor_menor':
                $sql .= ' ORDER BY a.precio DESC';
                break;
            case 'menor_mayor':
                $sql .= ' ORDER BY a.precio ASC';
                break;
            case 'rating':
                $sql .= ' ORDER BY a.rating DESC';
                break;
        }
        $sql .= " LIMIT $offset, $limit;";
        $stmt = $db->ejecutar($sql);
        $rows = $db->listar($stmt);
        foreach ($rows as &$row) {
        if (isset($row['imagenes']) && $row['imagenes'] !== null) {
            $row['imagenes'] = explode(':', $row['imagenes']);
        } else {
            $row['imagenes'] = [];
        }
    }
    
    return $rows;
    }

    public function select_count_productos_list($db) {
        $sql = "SELECT COUNT(*) AS contador FROM accesorios;";
        $stmt = $db->ejecutar($sql);
        $row = mysqli_fetch_assoc($stmt);
        return (int)$row['contador'];
    }

    public function count_accesorios_relacionados($db, $categoria) {
        $categoria = is_array($categoria) ? (int)($categoria[0] ?? 0) : (int)$categoria;

        $sql = "SELECT COUNT(*) AS total
                FROM accesorios
                WHERE id_categoria = (
                    SELECT id_categoria FROM accesorios WHERE id_accesorio = $categoria
                )
                AND id_accesorio != $categoria;";
        $stmt = $db->ejecutar($sql);
        $row = mysqli_fetch_assoc($stmt);
        return (int)$row['total'];
    }

    public function count_complementos_relacionados($db, $categoria) {
                $categoria = is_array($categoria) ? (int)($categoria[0] ?? 0) : (int)$categoria;

        $sql = "SELECT COUNT(*) AS total
                FROM complementos c
                INNER JOIN accesorios_complemento ac ON c.id_complemento = ac.id_complemento
                WHERE ac.id_accesorio = $categoria;";
        $stmt = $db->ejecutar($sql);
        $row = mysqli_fetch_assoc($stmt);
        return (int)$row['total'];
    }

    public function select_accesorios_relacionados($db, $id, $offset, $limit) {
        $sql = "SELECT a.*, i.image AS imagen_principal, c.name as categoria
                FROM accesorios a
                LEFT JOIN imagenes i ON i.id_imagen = (
                    SELECT MIN(id_imagen) FROM imagenes WHERE id_producto = a.id_accesorio
                )
                JOIN categorias c ON a.id_categoria = c.id_categoria
                WHERE a.id_categoria = (
                    SELECT id_categoria FROM accesorios WHERE id_accesorio = $id
                ) AND a.id_accesorio != $id
                LIMIT $limit OFFSET $offset;";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function select_complementos_relacionados($db, $id, $offset, $limit) {
        $sql = "SELECT *
                FROM complementos c
                INNER JOIN accesorios_complemento ac ON c.id_complemento = ac.id_complemento
                WHERE ac.id_accesorio = $id
                LIMIT $limit OFFSET $offset;";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function update_categoria_visitados($db, $categoria) {
        $categoria = is_array($categoria) ? (int)($categoria[0] ?? 0) : (int)$categoria;
        $sql = "UPDATE categorias SET visitado = visitado + 1 WHERE name  = '$categoria'";
        $db->ejecutar($sql);
        return true;
    }

    public function añadir_rating($db, $id, $rating) {
        $sql = "UPDATE accesorios SET rating = $rating WHERE id_accesorio = $id;";
        $db->ejecutar($sql);
        return true;
    }

    public function print_filters($db) {
        
        $sql = "SELECT *, 'ciudades' as tabla, 'select' as tipo FROM ciudades
                UNION ALL SELECT *, 'marcas' as tabla, 'checkbox' as tipo FROM marcas
                UNION ALL SELECT *, 'estados' as tabla, 'select' as tipo FROM estados
                UNION ALL SELECT *, 'categorias' as tabla, 'select' as tipo FROM categorias";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function filters($db, $filter, $offset, $limit, $order) {
    $filter = is_array($filter) && isset($filter[0]) && is_array($filter[0]) ? $filter : [];
            

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
                         WHERE " . $filter[$i][2] . ".name IN ('" . $values . "')
                    )";
                } else {
                    $consulta .= " WHERE a." . $filter[$i][0] . " = (
                        SELECT " . $filter[$i][2] . "." . $filter[$i][0] . " 
                          FROM " . $filter[$i][2] . " 
                         WHERE " . $filter[$i][2] . ".name = '" . $filter[$i][1] . "'
                    )";
                }
            } else {
                if ($filter[$i][0] == "id_marca") {
                    $values = implode("', '", $filter[$i][1]);
                    $consulta .= " AND a." . $filter[$i][0] . " IN (
                        SELECT " . $filter[$i][2] . "." . $filter[$i][0] . " 
                          FROM " . $filter[$i][2] . " 
                         WHERE " . $filter[$i][2] . ".name IN ('" . $values . "')
                    )";
                } else {
                    $consulta .= " AND a." . $filter[$i][0] . " = (
                        SELECT " . $filter[$i][2] . "." . $filter[$i][0] . " 
                          FROM " . $filter[$i][2] . " 
                         WHERE " . $filter[$i][2] . ".name = '" . $filter[$i][1] . "'
                    )";
                }
            }
        }
    
        $consulta .= " GROUP BY a.id_accesorio";
    
        if ($order == "popular") {
            $consulta .= " ORDER BY a.popular DESC";
        } elseif ($order == "mayor_menor") {
            $consulta .= " ORDER BY a.precio DESC";
        } elseif ($order == "menor_mayor") {
            $consulta .= " ORDER BY a.precio ASC";
        } elseif ($order == "rating") {
            $consulta .= " ORDER BY a.rating DESC";
        }
    
        $consulta .= " LIMIT $offset, $limit";
    
        $stmt = $db->ejecutar($consulta);
        $rows = $db->listar($stmt);
        foreach ($rows as &$row) {
        if (isset($row['imagenes']) && $row['imagenes'] !== null) {
            $row['imagenes'] = explode(':', $row['imagenes']);
        } else {
            $row['imagenes'] = [];
        }
    }
    
    return $rows;
    }
    
    public function count_filters($db, $filter) {
    $filter = is_array($filter) && isset($filter[0]) && is_array($filter[0]) ? $filter : [];

        $consulta = "SELECT COUNT(DISTINCT a.id_accesorio) AS contador
                     FROM accesorios a";
        if (! empty($filter)) {
            $consulta .= " LEFT JOIN imagenes i
                           ON a.id_imagen = i.id_producto";
        }
        for ($i = 0; $i < count($filter); $i++) {
            $col = $filter[$i][0];
            $val = $filter[$i][1];
            $tbl = $filter[$i][2];
    
            if ($i === 0) {
                if ($col === 'id_marca') {
                    $values = implode("','", $val);
                    $consulta .= " WHERE a." . $col . " IN (
                        SELECT " . $tbl . "." . $col . "
                          FROM " . $tbl . "
                         WHERE " . $tbl . ".name IN ('" . $values . "')
                    )";
                } else {
                    $consulta .= " WHERE a." . $col . " = (
                        SELECT " . $tbl . "." . $col . "
                          FROM " . $tbl . "
                         WHERE " . $tbl . ".name = '" . $val . "'
                    )";
                }
            } else {
                if ($col === 'id_marca') {
                    $values = implode("','", $val);
                    $consulta .= " AND a." . $col . " IN (
                        SELECT " . $tbl . "." . $col . "
                          FROM " . $tbl . "
                         WHERE " . $tbl . ".name IN ('" . $values . "')
                    )";
                } else {
                    $consulta .= " AND a." . $col . " = (
                        SELECT " . $tbl . "." . $col . "
                          FROM " . $tbl . "
                         WHERE " . $tbl . ".name = '" . $val . "'
                    )";
                }
            }
        }
    
        $stmt = $db->ejecutar($consulta);
        $row  = mysqli_fetch_assoc($stmt);
        return (int) $row['contador'];
    }
public function select_details_producto($db, int $id) {
    $sql = "
        SELECT 
            accesorios.*,
            (SELECT m.name FROM marcas m WHERE m.id_marca = $id) AS marca,
            estados.name AS estado
        FROM accesorios
        LEFT JOIN estados ON accesorios.id_estado = estados.id_estado
        WHERE id_accesorio = $id
    ";
    $stmt = $db->ejecutar($sql);
    $rows = $db->listar($stmt);
    return isset($rows[0]) ? $rows[0] : null;
}

public function select_images_producto($db, $id) {
    $sql = "SELECT image FROM imagenes WHERE id_producto = $id";
    $stmt = $db->ejecutar($sql);
    return $db->listar($stmt);
}

public function select_extras_icono($db, $id) {
    $sql = "
        SELECT e.* 
        FROM extras e
        JOIN accesorios_extras ae ON e.id_extra = ae.id_extra
        WHERE ae.id_accesorio = $id
    ";
    $stmt = $db->ejecutar($sql);
    return $db->listar($stmt);
}

public function select_categorias($db, $id) {
    $sql = "
        SELECT DISTINCT c.id_categoria, c.name, c.image
        FROM categorias c
        JOIN accesorios_categorias ac ON c.id_categoria = ac.id_categoria
        WHERE ac.id_accesorio = $id
    ";
    $stmt = $db->ejecutar($sql);
    return $db->listar($stmt);
}
    public function grouped_details($db, $id) {
        $details     = $this->select_details_producto($db, $id);
        $images      = $this->select_images_producto($db, $id); 
        $extras      = $this->select_extras_icono($db, $id);
        $related     = $this->select_accesorios_relacionados($db, $id, 0, 100);
        $complements = $this->select_complementos_relacionados($db, $id, 0, 100);
        $categories  = $this->select_categorias($db, $id);
    
        return [
            $details,      // data[0]
            [ $images ],      // data[1][0]
            [ $extras ],      // data[2][0]
            [ $related ],     // data[3][0]
            [ $categories ],  // data[4][0]
            [ $complements ]  // data[5][0]
        ];
    }
    public function select_city($db) {
        $sql = "SELECT *, 'ciudades' as tabla, 'select' as tipo FROM ciudades";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function select_marcas($db) {
        $sql = "SELECT *, 'marcas' as tabla, 'checkbox' as tipo FROM marcas";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function select_estados($db) {
        $sql = "SELECT *, 'estados' as tabla, 'select' as tipo FROM estados";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function select_all_categorias($db) {
        $sql = "SELECT *, 'categorias' as tabla, 'select' as tipo FROM categorias";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function select_tipo_formato($db) {
        $sql = "SELECT * FROM tipo_formato";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }
    public function selectLike($db, $id_accesorio, $correo) {
        $correo_esc = addslashes($correo);
        $sql = "
            SELECT id_accesorio
              FROM likes
             WHERE id_accesorio = $id_accesorio
               AND correo        = '$correo_esc'
        ";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function addLike($db, $id_accesorio, $correo) {
        $correo_esc = addslashes($correo);
        $sql = "
            INSERT IGNORE INTO likes (id_accesorio, correo)
            VALUES ($id_accesorio, '$correo_esc')
        ";
        return $db->ejecutar($sql);
    }

    public function removeLike($db, $id_accesorio, $correo) {
        $correo_esc = addslashes($correo);
        $sql = "
            DELETE FROM likes
             WHERE id_accesorio = $id_accesorio
               AND correo        = '$correo_esc'
        ";
        return $db->ejecutar($sql);
    }

    public function selectLikesUsuario($db, $correo) {
        $correo_esc = addslashes($correo);
        $sql = "
            SELECT id_accesorio
              FROM likes
             WHERE correo = '$correo_esc'
        ";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }
}