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
        // 1) ¿Ya existe?
        if ($this->dao->findByEmail($this->db, $email)) {
            return 'error_correo';
        }
        // 2) insertar
        $hash   = password_hash($password, PASSWORD_DEFAULT, ['cost'=>12]);
        $avatar = "https://api.dicebear.com/7.x/adventurer/svg?seed=".urlencode($username);
        $ok     = $this->dao->insertUser($this->db, $username, $email, $hash, $avatar);
        return $ok ? 'ok' : 'error_user';
    }

    public function login($email, $password) {
        $user = $this->dao->findUser($this->db, $email);
        if (!$user) {
            return 'error_correo';
        }
        if (!password_verify($password, $user['contraseña'])) {
            return 'error_passwd';
        }
        $token = create_token($user['correo']);
        $_SESSION['correo'] = $user['correo'];
        $_SESSION['tiempo'] = time();
        return $token;
    }

    public function dataUser($token) {
        $info = decode_token($token);
        return $this->dao->findUser($this->db, $info['correo']);
    }

    public function actividad() {
        if (!isset($_SESSION['tiempo'])) {
            return 'inactivo';
        }
        $_SESSION['tiempo'] = time();
        return 'activo';
    }

    public function controlUser($token) {
        $info = decode_token($token);
        if ($info['exp'] < time() || ($_SESSION['correo'] ?? '') !== $info['correo']) {
            return 'Wrong_User';
        }
        return 'Correct_User';
    }

    public function refreshToken($oldToken) {
        $info = decode_token($oldToken);
        return create_token($info['correo']);
    }

    public function refreshCookie() {
        session_regenerate_id();
        return 'Done';
    }
}
