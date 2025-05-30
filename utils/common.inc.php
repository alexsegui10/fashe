<?php
    // Define the VIEW_PATH_INC constant


    // echo 'hola';
    // exit;
    class common {
        public static function load_error() {
            require_once (VIEW_PATH_INC . 'top-page_home.html');
            require_once (VIEW_PATH_INC . 'header.html');
            include("module/auth/view/auth.html");
            require_once (VIEW_PATH_INC . 'error404.html');
            require_once (VIEW_PATH_INC . 'footer.html');
        }
        
        public static function load_view($topPage, $view) {
            // echo 'hola';
            // exit;
            $topPage = VIEW_PATH_INC . $topPage;
            if ((file_exists($topPage)) && (file_exists($view))) {
                require_once ($topPage);
                require_once (VIEW_PATH_INC . 'header.html');
                include("module/auth/view/auth.html");
                require_once ($view);
                require_once (VIEW_PATH_INC . 'footer.html');
                require_once (VIEW_PATH_INC . 'end-page.html');
            }else {
                self::load_error();
            }
        }
public static function verifyFirebaseToken(string $idToken): array {
    $url = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($idToken);

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 5,
        CURLOPT_SSL_VERIFYPEER => true, 
        // CURLOPT_SSL_VERIFYHOST => false, 
    ]);
    $resp = curl_exec($ch);
    $err  = curl_error($ch);
    curl_close($ch);

    if ($err || $resp === false) {
        error_log("[Firebase] cURL error al contactar tokeninfo: {$err}");
        return [];
    }

    $data = json_decode($resp, true);
    error_log('[Firebase DEBUG] tokeninfo response: ' . print_r($data, true));

 
    if (
        empty($data['email']) ||
        empty($data['aud'])   ||
        $data['aud'] !== $expectedAud
    ) {
        error_log('[Firebase] Token inválido o audience equivocada: ' . print_r($data, true));
        return [];
    }

    return $data;
}

        public static function load_model($model, $function = null, $args = null) {
            // echo 'hola load_model';
            // exit;
            $dir = explode('_', $model);
            $path = constant('MODEL_' . strtoupper($dir[0])) .  $model . '.class.singleton.php';
            if (file_exists($path)) {
                require_once ($path);
                if (method_exists($model, $function)) {
                    $obj = $model::getInstance();
                    //return $obj;
                    if ($args != null) {
                        return call_user_func(array($obj, $function), $args);
                    }
                    //return $function;
                    return call_user_func(array($obj, $function));
                }
            }
            throw new Exception();
        }

        public static function generate_token_secure($longitud){
            if ($longitud < 4) {
                $longitud = 4;
            }
            return bin2hex(openssl_random_pseudo_bytes(($longitud - ($longitud % 2)) / 2));
        }

        function friendlyURL_php($url) {
            $link = "";
            if (URL_FRIENDLY) {
                $url = explode("&", str_replace("?", "", $url));
                foreach ($url as $key => $value) {
                    $aux = explode("=", $value);
                    $link .=  $aux[1]."/";
                }
            } else {
                $link = "index.php?" . $url;
            }
            return SITE_PATH . $link;
        }
    }
?>