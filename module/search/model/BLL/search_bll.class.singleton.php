<?php
class search_bll {
    private $dao;
    private $db;
    static $_instance;

    private function __construct() {
        $this->dao = search_dao::getInstance();
        $this->db  = db::getInstance();
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function buscarCategoria() {
        return $this->dao->buscarCategoria($this->db);
    }

    public function buscarMarca() {
        return $this->dao->buscarMarca($this->db);
    }

    public function buscarMarcaPorCategoria($category) {
        return $this->dao->buscarMarcaPorCategoria($this->db, $category);
    }

    public function autocomplete($marca, $categoria, $complete) {
        if ($marca && !$categoria) {
            return $this->dao->buscarCiudadPorMarca($this->db, $marca, $complete);
        } elseif ($marca && $categoria) {
            return $this->dao->buscarCiudadPorMarcaYCategoria($this->db, $categoria, $marca, $complete);
        } elseif (!$marca && $categoria) {
            return $this->dao->buscarCiudadPorCategoria($this->db, $categoria, $complete);
        } else {
            return $this->dao->selectCity($this->db, $complete);
        }
    }
}
