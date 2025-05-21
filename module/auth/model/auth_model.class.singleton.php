<?php
class auth_model {
    private $bll;
    static $_instance;
    private function __construct() {
        $this->bll = auth_bll::getInstance();
        @session_start();
    }
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

  
// module/auth/model/auth_model.php (o donde tengas tu model)

public function verify(...$args) {
    if (count($args) === 1 && is_array($args[0])) {
        $args = $args[0];
    }
    $token = $args[0];
    return $this->bll->confirmUserBLL($token);
}



        public function register(...$args) {
        if (count($args) === 1 && is_array($args[0])) {
            $args = $args[0];
        }

        $username = $args[0];
        $email  = $args[1];
        $password  = $args[2];

        return $this->bll->register($username, $email, $password);
    }
        public function login(...$args) {
        if (count($args) === 1 && is_array($args[0])) {
            $args = $args[0];
        }

        $email = $args[0];
        $password  = $args[1];
        return $this->bll->login($email, $password);
    }
    public function dataUser($token) {
        return $this->bll->dataUser($token);
    }
    public function actividad() {
        return $this->bll->actividad();
    }
    public function controlUser($token) {
        return $this->bll->controlUser($token);
    }
    public function refreshToken($oldToken) {
        return $this->bll->refreshToken($oldToken);
    }
    public function refreshCookie() {
        return $this->bll->refreshCookie();
    }
}
