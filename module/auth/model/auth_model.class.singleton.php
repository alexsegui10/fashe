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
public function resetPassword(...$args) {
    if (count($args) === 1 && is_array($args[0])) {
        $args = $args[0];
    }
    return $this->bll->resetPassword($args[0], $args[1]);
}

    public function recover_activo(...$args) {
        if (count($args) === 1 && is_array($args[0])) {
            $args = $args[0];
        }
        $token = $args[0];
        return $this->bll->recover_activo($token);
    }

  

    public function verify(...$args) {
        if (count($args) === 1 && is_array($args[0])) {
            $args = $args[0];
        }
        $token = $args[0];
        return $this->bll->confirmUserBLL($token);
    }


        public function recover(...$args) {
            if (count($args) === 1 && is_array($args[0])) {
                $args = $args[0];
            }
            $email = $args[0];
            return $this->bll->recover($email);
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
