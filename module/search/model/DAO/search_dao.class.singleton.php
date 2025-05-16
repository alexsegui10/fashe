<?php
class search_dao {
    static $_instance;

    private function __construct() {}
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function buscarCategoria($db) {
        $sql  = "SELECT * FROM categorias";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function buscarMarca($db) {
        $sql  = "SELECT * FROM marcas";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function buscarMarcaPorCategoria($db, $category) {
        // Aseguramos que sea string, no array ni otro tipo
        $cat = is_array($category)
            ? (string) ($category[0] ?? '')
            : (string) $category;

        $sql = "
            SELECT DISTINCT m.*
              FROM marcas m
             INNER JOIN accesorios a ON m.id_marca     = a.id_marca
             INNER JOIN categorias c ON a.id_categoria = c.id_categoria
             WHERE c.name = '$cat'
        ";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function buscarCiudadPorMarca($db, $marca, $complete) {
        $mar = (string) $marca;
        $com = (string) $complete . '%';

        $sql = "
            SELECT DISTINCT ciu.*
              FROM ciudades ciu
             INNER JOIN accesorios acc ON ciu.id_ciudad = acc.id_ciudad
             INNER JOIN marcas mar2 ON acc.id_marca    = mar2.id_marca
             WHERE mar2.name       = '$mar'
               AND ciu.name LIKE   '$com'
        ";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function buscarCiudadPorCategoria($db, $category, $complete) {
        $cat = is_array($category)
            ? (string) ($category[0] ?? '')
            : (string) $category;
        $com = (string) $complete . '%';

        $sql = "
            SELECT DISTINCT ciu.*
              FROM ciudades ciu
             INNER JOIN accesorios acc ON ciu.id_ciudad = acc.id_ciudad
             INNER JOIN categorias cat ON acc.id_categoria = cat.id_categoria
             WHERE cat.name      = '$cat'
               AND ciu.name LIKE '$com'
        ";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function buscarCiudadPorMarcaYCategoria($db, $category, $marca, $complete) {
        $cat = is_array($category)
            ? (string) ($category[0] ?? '')
            : (string) $category;
        $mar = (string) $marca;
        $com = (string) $complete . '%';

        $sql = "
            SELECT DISTINCT ciu.*
              FROM ciudades ciu
             INNER JOIN accesorios acc ON ciu.id_ciudad  = acc.id_ciudad
             INNER JOIN categorias cat ON acc.id_categoria = cat.id_categoria
             INNER JOIN marcas mar2   ON acc.id_marca     = mar2.id_marca
             WHERE cat.name      = '$cat'
               AND mar2.name     = '$mar'
               AND ciu.name LIKE '$com'
        ";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function selectCity($db, $complete) {
        $com = (string)$complete . '%';
        $sql = "SELECT * FROM ciudades WHERE name LIKE '$com'";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }
}
