<?php
    // $data = 'hola crtl user';
    // die('<script>console.log('.json_encode( $data ) .');</script>');

    //include ("module/cursos/model/DAOCurso.php");
    //session_start();
    $path = $_SERVER['DOCUMENT_ROOT'] . '/Fashe/';
    include($path . 'module/shop/model/DAOShop.php');
    
    switch($_GET['op']){
        case 'list';
        include("views/html/shop.html"); 
        break;
 
        case 'list-productos';
            try{
                $daoshop = new DAOShop();
                $rdo = $daoshop->select_productos_list();
                }catch (Exception $e){
                    echo json_encode("error");
                    exit;
                }
                if(!$rdo){
                    echo json_encode("error");
                    exit;
            }else{
                    echo json_encode($rdo);
                    //echo json_encode("error");
                    exit;
            } // $data = 'hola crtl user';
            
        // die('<script>console.log('.json_encode( $data ) .');</script>');

            
            
    } 
     