<?php
class controller_shop {
    public function view() {
        common::load_view('top-page_shop.html', VIEW_SHOP . 'shop.html');
    }

    public function listProductos() {
        echo json_encode(
            common::load_model('shop_model', 'listProductos', [
                (int)($_POST['offset'] ?? 0),
                (int)($_POST['limit']  ?? 4),
                $_POST['order'] ?? 'popular'
            ])
        );
    }

    public function countListProductos() {
        echo json_encode(
            common::load_model('shop_model', 'countListProductos')
        );
    }

    public function countRelacionados() {
                $categoria = $_POST['categoria'] ?? '';
                if (is_array($categoria)) {
                    $categoria = $categoria[0] ?? ''; 
                }

                echo json_encode(
                    common::load_model('shop_model', 'countRelacionados', [$categoria])
                );
    }

    public function countComplementosRelacionados() {
        echo json_encode(
            common::load_model('shop_model', 'countComplementosRelacionados', [$_POST['categoria']])
        );
    }

public function relacionados() {
    $id = $_POST['id_accesorio'] ?? 0;
    $id = is_array($id) ? (int)($id[0] ?? 0) : (int)$id;

    $offset = (int)($_POST['offset'] ?? 0);
    $limit  = (int)($_POST['limit'] ?? 4);

    echo json_encode(
        common::load_model('shop_model', 'getRelacionados', [$id, $offset, $limit])
    );
}

    public function complementos() {
            $id = $_POST['id_accesorio'] ?? 0;
            $id = is_array($id) ? (int)($id[0] ?? 0) : (int)$id;

            $offset = (int)($_POST['offset'] ?? 0);
            $limit  = (int)($_POST['limit'] ?? 4);
        echo json_encode(
            common::load_model('shop_model', 'getComplementos', [$id, $offset, $limit])
        );
    }

    public function añadirVisitasCategoria() {
        echo json_encode(
            common::load_model('shop_model', 'addVisitasCategoria', [$_POST['categoria']])
        );
    }

    public function updateRating() {
        echo json_encode(
            common::load_model('shop_model', 'updateRating', [
                $_POST['id_accesorio'],
                $_POST['rating']
            ])
        );
    }

    public function printFilters() {
        echo json_encode(
            common::load_model('shop_model', 'printFilters')
        );
    }
public function filtros() {

    $rawFilter = $_POST['filter'] ?? [];

    if (is_array($rawFilter)) {
        $filter = $rawFilter;
    } else {
        $decoded = json_decode($rawFilter, true);
        $filter = is_array($decoded) ? $decoded : [];
    }

    echo json_encode(
        common::load_model(
            'shop_model',
            'filtros',
            [
                $filter,
                (int)($_POST['offset'] ?? 0),
                (int)($_POST['limit']  ?? 4),
                $_POST['order']       ?? 'popular'
            ]
        )
    );
}
public function countFiltros() {


    $rawFilter = $_POST['filter'] ?? [];

    if (is_array($rawFilter)) {
        $filter = $rawFilter;
    } else {
        $decoded = json_decode($rawFilter, true);
        $filter = is_array($decoded) ? $decoded : [];
    }

    echo json_encode(
        common::load_model('shop_model', 'countFiltros', [ $filter ])
    );
}

    public function details() {
        echo json_encode(
            common::load_model('shop_model', 'getDetails', (int)$_POST['id_accesorio'])
        );
    }

    public function tipos() {
        echo json_encode(
            common::load_model('shop_model', 'getTipos')
        );
    }

    public function controlLikes() {
        echo json_encode(
            common::load_model('shop_model', 'toggleLike', [
                $_POST['token'],
                $_POST['id_accesorio']
            ])
        );
    } 


        public function loadLikesUser() {
        echo json_encode(
            common::load_model('shop_model', 'getUserLikes', [$_POST['token']])
        );
    }

    public function countLikes() {
        echo json_encode(
            common::load_model('shop_model', 'countLikes', [$_POST['id_accesorio']])
        );
    }
}