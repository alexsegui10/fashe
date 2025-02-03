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
            $daocurso = new DAOCurso();
            $rdo = $daocurso->select_curso_precio();
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
        echo '<script>hola();</script>';
        include("views/html/home.html");
        break;
 
        case 'prueba';
        echo '<script>cargarprecio();</script>';
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

            
    }
     