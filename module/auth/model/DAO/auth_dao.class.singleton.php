<?php
class auth_dao {
    static $_instance;
    private function __construct() {}
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function findByEmail($db, $email) {
        $sql  = "SELECT correo FROM usuarios WHERE correo = '$email'";
        $stmt = $db->ejecutar($sql);
        $rows = $db->listar($stmt);
        return $rows[0] ?? null;
    }

    public function insertUser($db, $username, $email, $passwordHash, $avatar) {
        $sql = "
            INSERT INTO usuarios
              (nombre, correo, contraseña, tipo, avatar)
            VALUES
              ('$username', '$email', '$passwordHash', 'client', '$avatar')
        ";
        $stmt = $db->ejecutar($sql);
        return $stmt;
    }

    public function findUser($db, $email) {
        $sql  = "
            SELECT nombre, correo, contraseña, tipo, avatar
              FROM usuarios
             WHERE correo = '$email'
        ";
        $stmt = $db->ejecutar($sql);
        $rows = $db->listar($stmt);
        return $rows[0] ?? null;
    }
}
