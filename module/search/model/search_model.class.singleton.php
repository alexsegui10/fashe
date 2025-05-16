<?php
class search_model {
    private $bll;
    static $_instance;

    private function __construct() {
        $this->bll = search_bll::getInstance();
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function buscarCategoria() {
        return $this->bll->buscarCategoria();
    }

    public function buscarMarca() {
        return $this->bll->buscarMarca();
    }

    public function buscarMarcaPorCategoria($category) {
        return $this->bll->buscarMarcaPorCategoria($category);
    }

    public function autocomplete($args) {
                if (count($args) === 1 && is_array($args[0])) {
            $args = $args[0];
        }

        $marca = $args[0] ?? null;
        $categoria  = $args[1] ?? null;
        $complete  = $args[2] ?? '';
        return $this->bll->autocomplete($marca, $categoria, $complete);
    }
}
