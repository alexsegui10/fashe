// activity.js

function logoutAuto() {
  localStorage.removeItem('token');
  toastr.warning("Se ha cerrado la sesión por seguridad.");
  setTimeout(() => {
    window.location.href = 'index.php?module=home&op=view';
  }, 2000);
}

function protectUrl() {
  const token = JSON.parse(localStorage.getItem('token')) || false;
  if (!token) {
    console.log("ANONYMOUS user");
    return;
  }
  ajaxpromise(
    'POST',
    'index.php?module=auth&op=controluser',
    { token },
    'json'
  )
  .then(data => {
    if (data === 'Correct_User') {
      console.log("Usuario verificado en sesión");
    } else {
      console.log("Intento de acceso inválido");
      
    }
  })
  .catch(() => {
    console.log("Error comprobando usuario");
    logoutAuto();
  });
}

function controlActivity() {
  const token = JSON.parse(localStorage.getItem('token')) || false;
  if (!token) {
    console.log("No hay usuario logeado");
    return;
  }
  ajaxpromise(
    'POST',
    'index.php?module=auth&op=actividad',
    null,
    'json'
  )
  .then(response => {
    if (response === 'inactivo') {
      console.log("Usuario inactivo, cerrando sesión");
      logoutAuto();
    } else {
      console.log("Usuario activo");
    }
  })
  .catch(() => {
    console.log("Error comprobando actividad");
  });
}

function refreshToken() {
  const token = JSON.parse(localStorage.getItem('token')) || false;
  if (!token) return;
  ajaxpromise(
    'POST',
    'index.php?module=auth&op=refresh_token',
    { token },
    'json'
  )
  .then(newToken => {
    console.log("Token renovado");
        localStorage.setItem('token', JSON.stringify(newToken));
  })
  .catch(() => {
    console.log("Error renovando token");
  });
}

function refreshCookie() {
  ajaxpromise(
    'POST',
    'index.php?module=auth&op=refresh_cookie',
    null,
    'json'
  )
  .then(() => {
    console.log("Cookie de sesión renovada");
  })
  .catch(() => {
    console.log("Error renovando cookie");
  });
}

$(document).ready(function() {
  protectUrl();
  // Cada 30s
  setInterval(refreshToken,    10000);
  setInterval(refreshCookie,   10000);
  setInterval(controlActivity, 10000);
});
