<?php
include($_SERVER['DOCUMENT_ROOT'] . '/Fashe/model/JWT.php');
function decode_token($token){
    $jwt = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/Fashe/model/jwt.ini');
    $secret = $jwt['secret'];

    $JWT = new JWT;
    $token_dec = $JWT->decode($token, $secret);
    $rt_token = json_decode($token_dec, TRUE);
    return $rt_token;
}

function create_token($correo){
    $jwt = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/Fashe/model/jwt.ini');
    $header = $jwt['header'];
    $secret = $jwt['secret'];
    $payload = json_encode([
        "iat" => time(),
        "exp" => time() + 600,
        "correo" => $correo
    ]);
    
    $JWT = new JWT;
    $token = $JWT->encode($header, $payload, $secret);
    return $token;
}
