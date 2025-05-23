<?php

class mail
{
    public static function send_email(array $email)
    {
        switch ($email['type']) {
            case 'contact':
                $to      = '13salmu@gmail.com';
                $from    = 'secondchanceonti@gmail.com';
                $subject = 'Contacto desde web';
                $html    = "<h2>Nuevo mensaje de contacto</h2><p>{$email['message']}</p>";
                break;

            case 'validate':
                $to      = $email['toEmail'];
                $from    = 'no-reply@tudominio.com';
                $subject = 'Verificación de correo';
                $verifyUrl = "http://localhost/Fashe/index.php"
                        . "?module=auth"
                        . "&op=verify"
                        . "&token={$email['token']}";
                $html    = "<h2>Verifica tu cuenta</h2>"
                        . "<a href='{$verifyUrl}'>Haz clic para verificar</a>";
                break;

                case 'recover':
                $to      = $email['toEmail'];
                $from    = 'no-reply@tudominio.com';
                $subject = 'Verificación de correo';
                $verifyUrl = "http://localhost/Fashe/index.php"
                        . "?module=auth"
                        . "&op=recover_activo"
                        . "&token={$email['token']}";
                $html    = "<h2>Verifica tu cuenta</h2>"
                        . "<a href='{$verifyUrl}'>Haz clic para verificar</a>";
                break;

            default:
                throw new \InvalidArgumentException("Tipo de correo desconocido: {$email['type']}");
        }

        return self::send_resend([
            'from'    => $from,
            'to'      => $to,
            'subject' => $subject,
            'html'    => $html,
        ]);
    }

private static function send_resend(array $values)
{
    $apiConfig = parse_ini_file(
        $_SERVER['DOCUMENT_ROOT'] . '/Fashe/model/api.ini',
        true
    );

    if (! $apiConfig || ! isset($apiConfig['api']['apikey'])) {
        throw new \Exception('No se pudo leer api.ini o falta la clave');
    }

    $apiKey = $apiConfig['api']['apikey'];   
    $url    = 'https://api.resend.com/emails';

    $from = 'onboarding@resend.dev';

    $payload = [
        'from'    => $from,
        'to'      => $values['to'],       
        'subject' => $values['subject'],
        'html'    => $values['html'],
    ];


    $ch = curl_init($url);
    curl_setopt_array($ch, [
    CURLOPT_HTTPHEADER     => [
        "Authorization: Bearer {$apiKey}",
        "Content-Type: application/json",
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode($payload),
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
]);


    $raw      = curl_exec($ch);
    $curlErr  = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($curlErr) {
        throw new \RuntimeException("cURL error: {$curlErr}");
    }

    $data = json_decode($raw, true);

    error_log("Resend HTTP code: {$httpCode}");
    error_log("Resend response: " . print_r($data, true));

    if ($httpCode !== 202) {
        throw new \RuntimeException("Unexpected HTTP code {$httpCode} from Resend API");
    }

    return $data;
}

}
