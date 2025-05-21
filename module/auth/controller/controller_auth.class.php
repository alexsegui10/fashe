<?php
class controller_auth {
    public function register() {
        $data = [
            $_POST['username_reg'] ,
            $_POST['correo_reg']  ,
            $_POST['password_reg'] 
        ];
        echo json_encode(
            common::load_model('auth_model', 'register', $data)
        );
    }

// module/auth/controller/controller_auth.class.php

public function verify() {
    $token = $_GET['token'] ?? '';
    $result = common::load_model('auth_model', 'verify', [$token]);
    echo json_encode($result);
}


    public function login() {
        $data = [
            $_POST['correo_reg']   ?? '',
            $_POST['password_reg'] ?? ''
        ];
        echo json_encode(
            common::load_model('auth_model', 'login', $data)
        );
    }

    public function data_user() {
        $token = $_POST['token'] ?? '';
        echo json_encode(
            common::load_model('auth_model', 'dataUser', [$token])
        );
    }

    public function actividad() {
        echo json_encode(
            common::load_model('auth_model', 'actividad')
        );
    }

    public function controluser() {
        $token = $_POST['token'] ?? '';
        echo json_encode(
            common::load_model('auth_model', 'controlUser', [$token])
        );
    }

    public function refresh_token() {
        $old = $_POST['token'] ?? '';
        echo json_encode(
            common::load_model('auth_model', 'refreshToken', [$old])
        );
    }

    public function refresh_cookie() {
        echo json_encode(
            common::load_model('auth_model', 'refreshCookie')
        );
    }
}
