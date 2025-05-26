<?php
/*     @session_start();
     if (isset($_SESSION["tiempo"])) {
        $_SESSION["tiempo"] = time(); 
    } else {
        $_SESSION["tiempo"] = time(); 
    }   */
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


public function recover_activo() {
    $token = $_GET['token'] ?? '';
    $result = common::load_model('auth_model', 'recover_activo', [$token]);
    
    if ($result === 'ok') {
        header('Location: index.php?module=home&op=view&recovered=1&token=' . $token);
        exit;
    }

    echo '<h1>Error de recuperación</h1>';
    echo '<p>Token inválido o caducado.</p>';
    echo '<p><a href="index.php?module=home&op=view">Volver al inicio</a></p>';
}
    

public function resetPassword() {
    $token    = $_POST['token_recover'] ?? '';
    $password = $_POST['password_new']  ?? '';
    echo json_encode(
        common::load_model('auth_model', 'resetPassword', [$token, $password])
    );
}

public function verify() {
    $token  = $_GET['token'] ?? '';
    $result = common::load_model('auth_model', 'verify', [$token]);
    
    if ($result === 'ok') {
        header('Location: index.php?module=home&op=view&verified=1');
        exit;
    }

    echo '<h1>Error de verificación</h1>';
    echo '<p>Token inválido o caducado.</p>';
    echo '<p><a href="index.php?module=home&op=view">Volver al inicio</a></p>';
}



public function recover() {
    $email = $_POST['correo_recover'];
    echo json_encode(
        common::load_model('auth_model', 'recover', [$email])
    );
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

 public function controluser() {
        $token  = $_POST['token'] ?? '';
        $result = common::load_model('auth_model', 'controlUser', [$token]);
        echo json_encode($result);
        exit;
    }

    public function actividad() {
        $result = common::load_model('auth_model', 'actividad', []);
        echo json_encode($result);
        exit;
    }

    public function refresh_token() {
        $oldToken = $_POST['token'] ?? '';
        $newToken = common::load_model('auth_model', 'refreshToken', [$oldToken]);
        echo json_encode($newToken);
        exit;
    }

    public function refresh_cookie() {
        $result = common::load_model('auth_model', 'refreshCookie', []);
        echo json_encode($result);
        exit;
    }
}
