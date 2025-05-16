<?php
    // $data = 'hola crtl user';
    // die('<script>console.log('.json_encode( $data ) .');</script>');

    //include ("module/cursos/model/DAOCurso.php");
    //session_start();
    $path = $_SERVER['DOCUMENT_ROOT'] . '/Fashe/';
    include($path . 'module/shop/model/DAOShop.php');
    include($path . "model/middleware_auth.php");
    
    switch($_GET['op']){
        case 'list';
        include("module/shop/view/shop.html"); 
        break;
        case 'prueba';
        include("module/shop/view/details.html"); 
        break;
        case 'list-productos';
            try{
                $daoshop = new DAOShop();
                $rdo = $daoshop->select_productos_list($_POST['offset'], $_POST['limit'], $_POST['order']);
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

            case 'count_list-productos';
            try{
                $daoshop = new DAOShop();
                $rdo = $daoshop->select_count_productos_list();
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
            case 'count_relacionados';
                try{
                    $daoshop = new DAOShop();
                    $rdo = $daoshop->contar_accesorios_relacionados($_POST['categoria']);
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



                    case 'count_complementos_relacionados';
                    try{
                        $daoshop = new DAOShop();
                        $rdo = $daoshop->count_complementos_relacionados($_POST['categoria']);
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


                    
        case 'relacionados';
                try{
                    $daoshop = new DAOShop();
                    $rdo = $daoshop->select_accesorios_relacionados($_POST['id_accesorio'], $_POST['offset'], $_POST['limit']);
                    }catch (Exception $e){
                        echo json_encode("error");
                        exit;
                    } 
                    if(!$rdo){
                        echo json_encode("error");
                        exit;
                }else{
                        echo json_encode(value: $rdo); 
                        //echo json_encode("error");
                        exit;
            
                    } // $data = 'hola crtl user';


                    case 'complementos';
                    try{
                        $daoshop = new DAOShop();
                        $rdo = $daoshop->select_complementos_relacionados($_POST['id_accesorio'], $_POST['offset'], $_POST['limit']);
                        }catch (Exception $e){
                            echo json_encode("error");
                            exit;
                        } 
                        if(!$rdo){
                            echo json_encode("error");
                            exit;
                    }else{
                            echo json_encode(value: $rdo); 
                            //echo json_encode("error");
                            exit;
                
                        } // $data = 'hola crtl user';

        case 'añadir_visitas_categoria';
        try{
            $daoshop = new DAOShop();
            $rdo = $daoshop->update_categoria_visitados($_POST['categoria']);
            }catch (Exception $e){
                echo json_encode("error");
                exit;
            } 
            if(!$rdo){
                echo json_encode("error");
                exit;
        }else{
            echo json_encode(value: $rdo); 
            //echo json_encode("error");
                exit;
    
            } // $data = 'hola crtl user';
            
        case 'rating';
        try{
            $daoshop = new DAOShop();
            $rdo = $daoshop->añadir_rating($_POST['id_accesorio'], $_POST['rating']);
            }catch (Exception $e){
                echo json_encode("error");
                exit;
            } 
            if(!$rdo){
                echo json_encode("error");
                exit;
        }else{
                echo json_encode("ok"); 
                //echo json_encode("error");
                exit;
    
            } // $data = 'hola crtl user';
    

        case 'print_filters'; 
            $homeQuery = new DAOShop();
            $selSlide = $homeQuery -> print_filters();
            if (!empty($selSlide)) {
                echo json_encode($selSlide);
            }
            else {
                echo "error";
            }
            break;

            case 'filtros':
                $homeQuery = new DAOShop(); 
                $selSlide = $homeQuery->filters($_POST['filter'], $_POST['offset'], $_POST['limit'], $_POST['order']);
            
                if (!empty($selSlide)) {
                    echo json_encode($selSlide);
                } else {
                    echo json_encode(["error" => "No se encontraron resultados"]);
                }
                exit;


                case 'count_filtros':
                    $homeQuery = new DAOShop(); 
                    $selSlide = $homeQuery->count_filters($_POST['filter']);
                
                    if (!empty($selSlide)) {
                        echo json_encode($selSlide);
                    } else {
                        echo json_encode(["error" => "No se encontraron resultados"]);
                    }
                    exit;



                    
            
        // die('<script>console.log('.json_encode( $data ) .');</script>');
        case 'details':
            try{
                $daoshop = new DAOShop();
                $rdo_details = $daoshop->select_details_producto($_POST['id_accesorio']);
              }catch (Exception $e){
                  echo json_encode("error");
                  exit;
            }
            try{
                $daoshop_img = new DAOShop();
                $rdo_img = $daoshop_img->select_images_producto($_POST['id_accesorio']);
                }catch (Exception $e){
                    echo json_encode("error");
                    exit;
            } 
            try{
                $daoshop_icon = new DAOShop();
                $rdo_icon = $daoshop_icon->select_extras_icono($_POST['id_accesorio']);
                }catch (Exception $e){
                    echo json_encode("error");
                    exit;
            } 
            try{
                $daoshop_pupulat = new DAOShop();
                $rdo_popular = $daoshop_icon->añadir_popularidad($_POST['id_accesorio']);
                }catch (Exception $e){
                    echo json_encode("error");
                    exit;
            } 
            try{
                $daoshop_categoria = new DAOShop();
                $rdo_categoria = $daoshop_categoria->select_categorias($_POST['id_accesorio']);
                }catch (Exception $e){
                    echo json_encode("error");
                    exit;
            } 
            try{
                $daoshop_accesorios = new DAOShop();
                $rdo_accesorios = $daoshop_accesorios->select_accesorios_relacionados($_POST['id_accesorio'], 0, 100);
                }catch (Exception $e){
                    echo json_encode(value: "error");
                    exit;
            } 

            try{
                $daoshop_accesorios = new DAOShop();
                $rdo_complementos = $daoshop_accesorios->select_complementos_relacionados($_POST['id_accesorio'], 0, 100);
                }catch (Exception $e){
                    echo json_encode(value: "error");
                    exit;
            } 
            
                if (!empty($rdo_details || $rdo_img || $rdo_icon) || $rdo_accesorios ||$rdo_complementos) {
                    $rdo = array();
                    $rdo[0] = $rdo_details;
                    $rdo[1][] = $rdo_img;
                    $rdo[2][] = $rdo_icon;
                    $rdo[3][] = $rdo_accesorios;
                    $rdo[4][] = $rdo_categoria;
                    $rdo[5][] = $rdo_complementos;
                    echo json_encode($rdo);
                } else {
                    echo json_encode("error");
                }
                break;
                case 'tipos':
                    try {
                        $dao = new DAOShop();
                        $rdo_ciudades = $dao->select_city();
                    } catch (Exception $e) {
                        echo json_encode("error");
                        exit;
                    }
                    try {
                        $dao = new DAOShop();
                        $rdo_marcas = $dao->select_marcas();
                    } catch (Exception $e) {
                        echo json_encode("error");
                        exit;
                    }
                    try {
                        $dao = new DAOShop();
                        $rdo_estados = $dao->select_estados();
                    } catch (Exception $e) {
                        echo json_encode("error");
                        exit;
                    }
                    try {
                        $dao = new DAOShop();
                        $rdo_categorias = $dao->select_all_categorias();
                    } catch (Exception $e) {
                        echo json_encode("error");
                        exit;
                    }
                    try {
                        $dao = new DAOShop();
                        $rdo_tipo_formato = $dao->select_tipo_formato();
                    } catch (Exception $e) {
                        echo json_encode("error");
                        exit;
                    }
                    if (!empty($rdo_ciudades || $rdo_marcas || $rdo_estados || $rdo_categorias || $rdo_tipo_formato)) {
                        $rdo = array();
                        $rdo[0] = "no funciona esta posicion";
                        $rdo[1][] = $rdo_ciudades;
                        $rdo[2][] = $rdo_marcas ;
                        $rdo[3][] = $rdo_estados;
                        $rdo[4][] = $rdo_categorias;
                        $rdo[5][] = $rdo_tipo_formato;
                        echo json_encode($rdo);
                    } else {
                        echo json_encode("error");
                    }
                    break;

                    case 'control_likes':                
                        try {
                            $json = decode_token($_POST['token']);
                            $dao  = new DAOShop();
                            $res  = $dao->select_like($_POST['id_accesorio'], $json['correo']);
                        } catch (Exception $e) {
                            echo json_encode("error");
                            exit;
                        }
                        if (!$res) {
                            echo json_encode("error");
                            exit;
                        }
                        if (mysqli_num_rows($res) > 0) {
                            // Ya tenía like → lo quitamos
                            $dao->remove_like($_POST['id_accesorio'], $json['correo']);
                            echo json_encode("1");  // 1 = unlike
                        } else {
                            // No lo tenía → lo añadimos
                            $dao->add_like($_POST['id_accesorio'], $json['correo']);
                            echo json_encode("0");  // 0 = like
                        }
                        exit;
                
                    case 'load_likes_user':
                        $token = $_POST['token'];
                        try {
                            $json  = decode_token($token);
                            $dao   = new DAOShop();
                            $likes = $dao->select_likes_usuario($json['correo']);
                        } catch (Exception $e) {
                            echo json_encode("error");
                            exit;
                        }
                
                        if (!is_array($likes)) {
                            echo json_encode("error");
                            exit;
                        }
                
                        echo json_encode($likes);
                        exit;
                
                    case 'count_likes':
                        $id_accesorio = (int) $_POST['id_accesorio'];
                        try {
                            $dao = new DAOShop();
                            $cnt = $dao->count_likes($id_accesorio);
                        } catch (Exception $e) {
                            echo json_encode("error");
                            exit;
                        }
                        echo json_encode($cnt);
                        exit;
                    


    } 
     