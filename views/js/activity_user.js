function protecturl() {
    console.log("Protect URL");
    var token = localStorage.getItem('token');
    ajaxpromise("Post","module/auth/controller/controller_auth.php?op=controluser", { 'token':token } ,"json" )
        .then(function(data) {
            if (data == "Correct_User") {
                console.log("CORRECTO-->El usario coincide con la session");
            } else if (data == "Wrong_User") {
                console.log("INCORRCTO--> Estan intentando acceder a una cuenta");
                logout_auto();
            }
        })
        .catch(function() { console.log("ANONYMOUS_user") });
}

function control_activity() {
    console.log("Control activity");
    var token = localStorage.getItem('token');
    if (token) {
        ajaxpromise("Post","module/auth/controller/controller_auth.php?op=actividad", null ,"json" )
            .then(function(response) {
                if (response == "inactivo") {
                    console.log("usuario INACTIVO");
                    logout_auto();
                } else {
                    console.log("usuario ACTIVO")
                }
            });
    } else {
        console.log("No hay usario logeado");
    }
}

function refresh_token() {
    console.log("Refresh token");
    var token = localStorage.getItem('token');
    console.log("viejo token", token); 
    if (token) {
        ajaxpromise("Post","module/auth/controller/controller_auth.php?op=refresh_token", { 'token':token } ,"json" )
            .then(function(data_token) {
                console.log("nuevo token", data_token);
                console.log("Refresh token correctly");
                localStorage.setItem("token", data_token);
                load_menu();
            });
    }
}

function refresh_cookie() {
    console.log("Refresh cookie");
    ajaxpromise("Post","module/auth/controller/controller_auth.php?op=refresh_cookie", null ,"json" )
        .then(function(response) {
            console.log("Refresh cookie correctly");
        });
}

function logout_auto() {
    localStorage.removeItem('token');
    toastr.warning("Se ha cerrado la cuenta por seguridad!!");
    setTimeout('window.location.href = "index.php?module=ctrl_login&op=login-register_view";', 2000);
}

$(document).ready(function() {
    setInterval(function() { control_activity() }, 30000); //30 segundos
    protecturl();
    setInterval(function() { refresh_token() }, 30000);
    setInterval(function() { refresh_cookie() }, 30000);
});