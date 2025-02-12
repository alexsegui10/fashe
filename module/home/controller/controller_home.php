<?php
    // $data = 'hola crtl user';
    // die('<script>console.log('.json_encode( $data ) .');</script>');

    //include ("module/cursos/model/DAOCurso.php");
    //session_start();
    $path = $_SERVER['DOCUMENT_ROOT'] . '/Fashe/';
    include($path . 'module/home/model/DAOHome.php');
    
    switch($_GET['op']){
        case 'list';
        include("views/html/home.html");
        break;
 
        case 'prueba';
            try{
                $daohome = new DAOHome();
                $rdo = $daohome->select_productos_precio();
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

        case 'ciudad';
            try{
                $daohome = new DAOHome();
                $rdo = $daohome->select_producto_ciudad();
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



            case 'categorias';
            try{
                $daohome = new DAOHome();
                $rdo = $daohome->select_categorias();
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
            } 
            
            
    } 
     