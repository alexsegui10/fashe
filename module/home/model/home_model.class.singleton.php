<?php
    class home_model {

        private $bll;
        static $_instance;
        
        function __construct() {
            //return 'hola getInstance';
            $this -> bll = home_bll::getInstance();
        }

        public static function getInstance() {
            //return 'hola getInstance';
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }
        public function carrusel_ciudad() {
            return $this->bll->carrusel_ciudad();
        }
     
        public function carrusel_marcas() {
            return $this->bll->carrusel_marcas();
        }

        public function categorias() {
            return $this->bll->categorias();
        }

        public function categorias_visitado() {
            return $this->bll->categorias_visitado();
        }

        public function rating() {
            return $this->bll->rating();
        } 
}
?>
