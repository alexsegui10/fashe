<?php
class home_bll {
    private $dao;
    private $db;
    static $_instance;

    private function __construct() {
        $this->dao = home_dao::getInstance();
        $this->db  = db::getInstance();
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function carrusel_ciudad() {
        return $this->dao->carrusel_ciudad($this->db);
    }

      public function carrusel_marcas() {
        return $this->dao->carrusel_marcas($this->db);
    } 

    public function categorias() {
        return $this->dao->categorias($this->db);
    }

    public function categorias_visitado() {
        return $this->dao->categorias_visitado($this->db);
    }

    public function rating() {
        return $this->dao->rating($this->db);
    } 
}
?>
