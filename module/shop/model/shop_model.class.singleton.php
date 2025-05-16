<?php
class shop_model {
    private $bll;
    static $_instance;

    private function __construct() {
        $this->bll = shop_bll::getInstance();
    }
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function view() {
        return; 
    }
    public function listProductos(...$args) {
        if (count($args) === 1 && is_array($args[0])) {
            $args = $args[0];
        }

        $offset = $args[0] ?? 0;
        $limit  = $args[1] ?? 20;
        $order  = $args[2] ?? 'popular';

        return $this->bll->listProductos($offset, $limit, $order);
    }

    public function countListProductos() { return $this->bll->countListProductos(); }
    public function countRelacionados($categoria) { return $this->bll->countRelacionados($categoria); }
    public function countComplementosRelacionados($categoria) { return $this->bll->countComplementosRelacionados($categoria); }
public function getRelacionados($params) {
    [$id, $offset, $limit] = $params;

    return $this->bll->getRelacionados($id, $offset, $limit);
    }    
    public function getComplementos($args) {
      [$id, $offset, $limit] = $args;
    return $this->bll->getComplementos($id, $offset, $limit); 
    }
    public function añadirVisitasCategoria($categoria): mixed { return $this->bll->addVisitasCategoria($categoria); }
    public function updateRating($id, $rating) { return $this->bll->updateRating($id, $rating); }
    public function printFilters() { return $this->bll->printFilters(); }
    public function filtros($args) {
        [$filter, $offset, $limit, $order] = $args;

        return $this->bll->filtros($filter, $offset, $limit, $order);
    }

    public function countFiltros($args) {
        [$filter] = $args;

        return $this->bll->countFiltros($filter);
    }
    public function getDetails($id) { return $this->bll->getDetails($id); }
    public function getTipos() { return $this->bll->getTipos(); }
    public function toggleLike($token, $id) { return $this->bll->toggleLike($token, $id); }
    public function getUserLikes($token) { return $this->bll->getUserLikes($token); }
    public function countLikes($id) { return $this->bll->countLikes($id); }
}