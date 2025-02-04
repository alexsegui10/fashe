<?php
    // $data = 'hola crtl user';
    // die('<script>console.log('.json_encode( $data ) .');</script>');

    //include ("module/cursos/model/DAOCurso.php");
    //session_start();
    
    switch($_GET['op']){
        case 'precio';
        // $data = 'hola crtl user';
        // die('<script>console.log('.json_encode( $data ) .');</script>');
          
        try{
            $daocurso = new DAOHome();
            $rdo = $daocurso->select_productos_precio();
            //die('<script>console.log('.json_encode( $rdo->num_rows ) .');</script>');
        }catch (Exception $e){
            $callback = 'index.php?seccion=503';
            die('<script>window.location.href="'.$callback .'";</script>');
        }
        
        if(!$rdo){
            $callback = 'index.php?seccion=503';
            die('<script>window.location.href="'.$callback .'";</script>');
        }else{
            include("views/html/home.php");
        }

        break;
        case 'list';
        include("views/html/home.html");
        echo '<script>cargarprecio();</script>';
        break;
 
        case 'prueba';
        header('Content-Type: application/json');
            try{
                $daocurso = new DAOHome();
                $rdo = $daocurso->select_productos_precio();
                }catch (Exception $e){
                    echo json_encode("error");
                    exit;
                }
                if(!$rdo){
                    echo json_encode("error");
                    exit;
            }else{
                    $curso=get_object_vars($rdo);
                    echo json_encode($curso);
                    //echo json_encode("error");
                    exit;
            } // $data = 'hola crtl user';
            
        // die('<script>console.log('.json_encode( $data ) .');</script>');
            
    } 
     