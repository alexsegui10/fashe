<?php
    class controller_home {
        public function view() {
            echo "<p>VIEW_PATH_INC = " . VIEW_PATH_INC . "</p>";
            echo "<p>VIEW_HOME     = " . VIEW_HOME . "</p>";
            common::load_view('top-page_home.html', VIEW_HOME . 'home.html');
        }
         public function carrusel_ciudad() {
            echo json_encode(common::load_model('home_model', 'carrusel_ciudad'));
        } 
        public function carrusel_marcas() {
            echo json_encode(common::load_model(model: 'home_model', function: 'carrusel_marcas'));
        } 
        

     public function categorias() {
        echo json_encode(common::load_model('home_model', 'categorias'));
    }

    public function categorias_visitado() {
        echo json_encode(common::load_model('home_model', 'categorias_visitado'));
    }

    public function rating() {
        echo json_encode(common::load_model('home_model', 'rating'));
    } 
    }
?>