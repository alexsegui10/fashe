<?php
    class home_dao {
        static $_instance;

        private function __construct() {
        }

        public static function getInstance() {
            //return 'hola getInstance dao';
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

    public function carrusel_ciudad($db) {
        $sql = "
            SELECT
              c.name,
              c.image,
              (SELECT COUNT(a.id_accesorio)
                 FROM accesorios a
                WHERE a.id_ciudad = c.id_ciudad
              ) AS nproductos
            FROM ciudades c;
        ";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function carrusel_marcas($db) {
        $sql = "
            SELECT
              m.name,
              m.image,
              (SELECT COUNT(c.id_accesorio)
                 FROM accesorios c
                WHERE c.id_marca = m.id_marca
              ) AS nproductos
            FROM marcas m
            LIMIT 6;
        ";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function categorias($db) {
        $sql = "SELECT * FROM categorias LIMIT 3;";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function categorias_visitado($db) {
        $sql = "SELECT * FROM categorias ORDER BY visitado DESC;";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function rating($db) {
        $sql = "SELECT * FROM accesorios ORDER BY rating DESC;";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }
}
?>
