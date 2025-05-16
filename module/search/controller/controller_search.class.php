<?php
class controller_search {
    public function buscar_categoria() {
        echo json_encode(
            common::load_model('search_model', 'buscarCategoria')
        );
    }

    public function buscar_marca() {
        echo json_encode(
            common::load_model('search_model', 'buscarMarca')
        );
    }

    public function buscar_marca_por_categoria() {
        echo json_encode(
            common::load_model('search_model', 'buscarMarcaPorCategoria', [
                $_POST['categoria'] ?? ''
            ])
        );
    }

    public function autocomplete() {
        echo json_encode(
            common::load_model('search_model', 'autocomplete', [
                $_POST['marca']     ?? null,
                $_POST['categoria'] ?? null,
                $_POST['complete']  ?? ''
            ])
        );
    }
}
