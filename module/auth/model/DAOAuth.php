<?php
    $path = $_SERVER['DOCUMENT_ROOT'] . '/Fashe/';
	include($path . "model/connect.php");

    class DAOAuth{

        
        function select_email($email){
			$sql = "SELECT correo FROM usuarios WHERE correo='$email'";
			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql)->fetch_object();
            connect::close($conexion);
            return $res;
		}

        function insert_user($username, $email, $password){
            $hashed_pass = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
            //$hashavatar = md5(strtolower(trim($username))); 
            $avatar = "https://api.dicebear.com/7.x/adventurer/svg?seed=$username";
            $sql ="   INSERT INTO `usuarios`(`nombre`, `correo`, `contraseña`, `tipo`, `avatar`) 
            VALUES ('$username','$email','$hashed_pass','client','$avatar')";

            $conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion);
            return $res;
        }



        function select_user($correo){
			$sql = "SELECT `nombre`, `correo`, `contraseña`, `tipo`, `avatar` FROM `usuarios` WHERE correo='$correo'";
			$conexion = connect::con();
            $res = mysqli_query($conexion, $sql)->fetch_object();
            connect::close($conexion);

            if ($res) {
                $value = get_object_vars($res);
                return $value;
            }else {
                return "error_user";
            }
        }        
    }
