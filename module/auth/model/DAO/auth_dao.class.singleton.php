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
    public function updateRecoverActivo($db, $token) {
        $sql = "
            UPDATE usuarios
               SET activo = -1
             WHERE token_email = '$token'
        ";
        return $db->ejecutar($sql);
    }
    public function insertUser($db, $username, $email, $passwordHash, $avatar, $activo, $token_email) {
        $sql = "
            INSERT INTO usuarios
              (nombre, correo, contraseña, tipo, avatar, activo, token_email)
            VALUES
              ('$username', '$email', '$passwordHash', 'client', '$avatar', '$activo', '$token_email')
        ";
        $stmt = $db->ejecutar($sql);
        return $stmt;
    }
    public function updateUser($db, $tokenEmail) {
    if (is_array($tokenEmail)) {
        $tokenEmail = $tokenEmail['token_email'] ?? reset($tokenEmail);
    }

    $tokenEmail = trim((string) $tokenEmail);

    $sql = "
        UPDATE usuarios
           SET activo      = 1,
               token_email = NULL
         WHERE token_email = '$tokenEmail'
    ";

    return $db->ejecutar($sql);
}


public function findByRecoverToken($db, $token) {
    $sql  = "SELECT correo, activo FROM usuarios WHERE token_email = '$token'";
    $stmt = $db->ejecutar($sql);
    $rows = $db->listar($stmt);
    return $rows[0] ?? null;
}

public function updatePassword($db, $token, $hashedPass) {
    $sql = "
      UPDATE usuarios
         SET contraseña     = '$hashedPass',
             activo         = 1,
             token_email    = NULL
       WHERE token_email = '$token'
    ";
    return $db->ejecutar($sql);
}



public function updateRecover($db, $email, $token_recover) {
    $sql = "
      UPDATE usuarios
         SET activo        = 0,
             token_email = '$token_recover'
       WHERE correo = '$email'
    ";
    return $db->ejecutar($sql);
}


    public function findUser($db, $email) {
        $sql  = "
            SELECT nombre, correo, contraseña, tipo, avatar, activo
              FROM usuarios
             WHERE correo = '$email'
        ";
        $stmt = $db->ejecutar($sql);
        $rows = $db->listar($stmt);
        return $rows[0] ?? null;
    }

    public function findActive($db, $email) {
        $sql  = "
           SELECT activo FROM usuarios WHERE correo = '$email';

        ";
        $stmt = $db->ejecutar($sql);
        $rows = $db->listar($stmt);
        return $rows[0] ?? null;
    }
}
