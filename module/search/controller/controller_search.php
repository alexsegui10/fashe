<?php
    $path = $_SERVER['DOCUMENT_ROOT'] . '/Fashe/';
    include($path . 'module/search/model/DAOSearch.php');

switch ($_GET['op']) {
    case 'buscar_categoria';
        $homeQuery = new DAO_search();
        $selSlide = $homeQuery -> buscar_categoria();
        if (!empty($selSlide)) {
            echo json_encode($selSlide);
        }
        else {
            echo "error";
        }
        break;

        case 'buscar_marca';
        $homeQuery = new DAO_search();
        $selSlide = $homeQuery -> buscar_marca();
        if (!empty($selSlide)) {
            echo json_encode($selSlide);
        }
        else {
            echo "error";
        }
        break;

        case 'buscar_marca_por_categoria';
        $homeQuery = new DAO_search();
        $selSlide = $homeQuery -> buscar_marca_por_categoria($_POST['categoria']);
        if (!empty($selSlide)) {
            echo json_encode($selSlide);
        }
        else {
            echo "error";
        }
        break; 



    case 'autocomplete';
    try{
        $dao = new DAO_search();
        if (!empty($_POST['marca']) && empty($_POST['categoria'])){
            $rdo = $dao->buscar_ciudad_por_marca($_POST['marca'], $_POST['complete']);
        }else if(!empty($_POST['marca']) && !empty($_POST['categoria'])){
            $rdo = $dao->buscar_ciudad_por_marca_y_caregoria($_POST['categoria'], $_POST['marca'], $_POST['complete']);
        }else if(empty($_POST['marca']) && !empty($_POST['categoria'])){
            $rdo = $dao->buscar_ciudad_por_categoria($_POST['categoria'], $_POST['complete']);
        }else {
            $rdo = $dao->select_city($_POST['complete']);
        }
    }catch (Exception $e){
        echo json_encode("mal");
        exit;
    }
    if(!$rdo){
        echo json_encode("rdo!!!");
        exit;
    }else{
        $dinfo = array();
        foreach ($rdo as $row) {
            array_push($dinfo, $row);
        }
        echo json_encode($dinfo);
    }
    break; 
}