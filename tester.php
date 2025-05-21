<?php
// tester.php — Pruebas sin necesidad de router

// 1) Composer autoload (para Guzzle, PSR interfaces, etc.)
require_once __DIR__ . '/vendor/autoload.php';

// 2) Incluimos manualmente lo que necesita la BLL y el mailer
$base = __DIR__;
include $base . '/utils/common.inc.php';                        
include $base . '/utils/mail.inc.php';                          
include $base . '/model/config.class.singleton.php';            
include $base . '/model/db.class.singleton.php';                
include $base . '/module/auth/model/DAO/auth_dao.class.singleton.php';  
include $base . '/module/auth/model/BLL/auth_bll.class.singleton.php';  

// 3) TEST MAIL
echo "=== TEST MAIL ===\n";
try {
    $mailResp = mail::send_email([
        'type'    => 'validate',
        'toEmail' => 'alexsegui10@gmail.com',   // tu dirección real
        'token'   => 'TEST123TOKEN'
    ]);
    echo "Mail response:\n";
    print_r($mailResp);
} catch (\Exception $e) {
    echo "Mail error: " . $e->getMessage() . "\n";
}

echo "\n\n";

// 4) TEST REGISTER
echo "=== TEST REGISTER ===\n";
$bll = auth_bll::getInstance();

// Generamos datos de prueba únicos
$user  = 'testuser_' . rand(1000,9999);
$email = 'test_' . rand(1000,9999) . '@example.com';
$pass  = 'Pass1234';

echo "Registering user: $user, email: $email\n";
$result = $bll->register($user, $email, $pass);
echo "Result: $result\n";

// PISTA: Si devuelve 'ok', el insert y el envío de email se han disparado.
// Pero el correo en sandbox solo llegará si 'toEmail' coincide con tu cuenta Resend.
// Para ver todo el detalle (payload, HTTP code, respuesta JSON),  
// revisa tu log de PHP (p.ej. C:\wamp64\logs\php_error.log)  
// donde tendrás tus “[Resend Debug]” y “[Register Debug]”.
