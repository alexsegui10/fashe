<?php
class auth_bll {
    private $dao;
    private $db;
    static $_instance;

    private function __construct() {
        $this->dao = auth_dao::getInstance();
        $this->db  = db::getInstance();
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function register($username, $email, $password) {
    $hashed_pass  = password_hash($password, PASSWORD_DEFAULT);
    $hashavatar   = md5(strtolower(trim($email)));
    $avatar       = "https://robohash.org/{$hashavatar}";
    $token_email  = common::generate_Token_secure(20);

    if (!empty($this->dao->findUser($this->db, $email))) {
        return 'error_correo';
    } else {
        $this->dao->insertUser(
            $this->db,
            $username,
            $email,     
            $hashed_pass,
            $avatar,       
            $activo = 0,
            $token_email
        );

        $message = [
            'type'    => 'validate',
            'token'   => $token_email,
            'toEmail' => 'alexsegui10@gmail.com',
        ];
        try {
            $response = mail::send_email($message);
        } catch (Exception $e) {
            error_log("[Resend Debug] " . $e->getMessage());
            return 'ok';
        }
        return 'ok';
    }
    }

public function confirmUserBLL($token) {
    $ok = $this->dao->updateUser($this->db, $token);
    return $ok ? 'ok' : 'error';
}


    public function recover_activo($token) {
        $ok = $this->dao->updateRecoverActivo($this->db, $token);
        return $ok ? 'ok' : 'error';
    }

public function login($email, $password) {
    $user = $this->dao->findUser($this->db, $email);

    if (!$user) { 
        return 'error_correo';
    }

    if ($user['activo'] != 1 )  {
        return 'error_activo';
        exit;
    }

    if (!password_verify($password, $user['contraseña'])) {
        return 'error_passwd';
    }

    $token = create_token($user['correo']);
    $_SESSION['correo'] = $user['correo'];
    $_SESSION['tiempo'] = time();
    return $token;
}
public function resetPassword($token, $newPassword) {
    $user = $this->dao->findByRecoverToken($this->db, $token);
    if (!$user || $user['activo'] != -1) {
        return 'error_token';
    }

    $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
    $this->dao->updatePassword($this->db, $token, $hashed);

    return 'ok';
}


public function recover($email) {
    $user = $this->dao->findUser($this->db, $email);
    if (!$user) {
        return 'error_noexist';
    }
    $token  = common::generate_Token_secure(20);
    $this->dao->updateRecover($this->db, $email, $token);
       
    $message = [
        'type'    => 'recover',
        'token'   => $token,
        'toEmail' => 'alexsegui10@gmail.com',
    ];
    try {
        mail::send_email($message);
    } catch (Exception $e) {
        error_log("[Recover Debug] " . $e->getMessage());
    } 
    return 'ok';
}


    public function dataUser($token) {
        $info = decode_token($token);
        return $this->dao->findUser($this->db, $info['correo']);
    }

    public function controlUser($token) {
        return $this->dao->controlUser($this->db, $token);
    }

    public function actividad() {
        // Inicia o no la sesión si no existe
        return $this->dao->actividad($this->db);
    }

    public function refreshToken($oldToken) {
        return $this->dao->refreshToken($this->db, $oldToken);
    }

    public function refreshCookie() {
        return $this->dao->refreshCookie($this->db);
    }
}
