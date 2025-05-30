
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    // $data = 'hola crtl user';
    // die('<script>console.log('.json_encode( $data ) .');</script>');
    @session_start();
    //include ("module/cursos/model/DAOCurso.php");
    //session_start();
    $path = $_SERVER['DOCUMENT_ROOT'] . '/Fashe/';
    include($path . 'module/auth/model/DAOAuth.php');
    include($path . "model/middleware_auth.php");
    //
/*     if (isset($_SESSION["tiempo"])) {
        $_SESSION["tiempo"] = time(); // Reinicia el tiempo de sesión
    } else {
        $_SESSION["tiempo"] = time(); // Inicializa la sesión si no existe
    } */

switch ($_GET['op']) {
    case 'register': 
        try {
            $daoLog = new DAOAuth(); 
            $check = $daoLog->select_email($_POST['correo_reg']);
        } catch (Exception $e) {
            echo json_encode("error1");
            exit;
        }
        if ($check) {
            $check_email = false;
        } else {
            $check_email = true;
        }
        if ($check_email) {
            try {
                $daoLog = new DAOAuth();
                $rdo = $daoLog->insert_user($_POST['username_reg'], $_POST['correo_reg'], $_POST['password_reg']);
            } catch (Exception $e) {
                echo json_encode("error2");
                exit;
            }
            if (!$rdo) {
                echo json_encode("error_user");
                exit;
            } else {
                echo json_encode("ok");
                exit;
            }
        } else {
            echo json_encode("error_correo");
            exit;
        }
        break;

    case 'login':
        try {
            $daoLog = new DAOAuth();
            $rdo = $daoLog->select_user($_POST['correo_reg']);

            if ($rdo == "error_user") {
                echo json_encode("error_correo");
                exit;
            } else {
                if (password_verify($_POST['password_reg'], $rdo['contraseña'])) {
                    $token= create_token($rdo["correo"]);
                    echo json_encode($token);
                    exit;
                } else {
                    echo json_encode("error_passwd");
                    exit;
                }
            }
        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        break;
    case 'data_user':
        $json = decode_token($_POST['token']);
        $daoLog = new DAOAuth();
        $rdo = $daoLog->select_user($json['correo']);
        echo json_encode($rdo);
        exit;
        break; 
    } 