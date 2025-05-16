<?php
class shop_bll {
    private $dao;
    private $db;
    static $_instance;

    private function __construct() {
        $this->dao = shop_dao::getInstance();
        $this->db  = db::getInstance();
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function listProductos($offset, $limit, $order) {
        return $this->dao->select_productos_list($this->db, $offset, $limit, $order);
    }
    public function countListProductos() {
        return $this->dao->select_count_productos_list($this->db);
    }
    public function countRelacionados($categoria) {
        return $this->dao->count_accesorios_relacionados($this->db, $categoria);
    }
    public function countComplementosRelacionados($categoria) {
        return $this->dao->count_complementos_relacionados($this->db, $categoria);
    }
    public function getRelacionados($id, $offset, $limit) {
        return $this->dao->select_accesorios_relacionados($this->db, $id, $offset, $limit);
    }
    public function getComplementos($id, $offset, $limit) {
        return $this->dao->select_complementos_relacionados($this->db, $id, $offset, $limit);
    }
    public function addVisitasCategoria($categoria) {
        return $this->dao->update_categoria_visitados($this->db, $categoria);
    }
    public function updateRating($id, $rating) {
        return $this->dao->añadir_rating($this->db, $id, $rating);
    }
    public function printFilters() {
        return $this->dao->print_filters($this->db);
    }
    public function filtros($filter, $offset, $limit, $order) {
        return $this->dao->filters($this->db, $filter, $offset, $limit, $order);
    }
    public function countFiltros($filter) {
        return $this->dao->count_filters($this->db, $filter);
    }
    public function getDetails($id) {
        return $this->dao->grouped_details($this->db, $id);
    }
    public function getTipos() {
        return [
            "no funciona esta posicion",
            [ $this->dao->select_city(         $this->db ) ],
            [ $this->dao->select_marcas(       $this->db ) ],
            [ $this->dao->select_estados(      $this->db ) ],
            [ $this->dao->select_all_categorias($this->db ) ],
            [ $this->dao->select_tipo_formato($this->db ) ],
        ];
    }
    
    public function toggleLike($token, $id) {
        return $this->dao->toggle_like($this->db, $token, $id);
    }
    public function getUserLikes($token) {
        return $this->dao->select_likes_usuario($this->db, $token);
    }
    public function countLikes($id) {
        return $this->dao->count_likes($this->db, $id);
    }
}