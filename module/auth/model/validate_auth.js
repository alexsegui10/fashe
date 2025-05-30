document.addEventListener('DOMContentLoaded', () => {
  const modal    = document.getElementById('auth-modal') || false;
  const triggers = document.querySelectorAll('.modal-btn');
  const switches = document.querySelectorAll('.switch');
  const blocks   = document.querySelectorAll('.auth-block');
  const closeBtn = document.querySelector('.close-modal');

  (function checkRecovered() {
    const params = new URLSearchParams(window.location.search);
    if (params.get('recovered') === '1') {
      params.delete('recovered');
      const token = params.get('token');
      document.getElementById('token_recover').value = token;
      showModal('reset');
    } 
  })();


  triggers.forEach(btn => {
    btn.addEventListener('click', () => {
      showModal(btn.getAttribute('data-type'));
    });
  });

  switches.forEach(sw => {
    sw.addEventListener('click', (e) => {
      e.preventDefault();
      switchForm(sw.getAttribute('data-type'));
    });
  });

  closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
  if (modal) {
    modal.addEventListener('click', (e) => {
      if (e.target === modal) modal.classList.add('hidden');
    });
  }

  function showModal(type) {
    modal.classList.remove('hidden');
    const switcher = document.querySelector('.auth-switcher');
    switchForm(type);
  }

  function switchForm(type) {
    switches.forEach(sw =>
      sw.classList.toggle('selected', sw.getAttribute('data-type') === type)
    );
    blocks.forEach(block =>
      block.classList.toggle('hidden', block.getAttribute('data-type') !== type)
    );
  }
  });


/* 
  function mostrar_menu() {
    document.getElementById("avatar").addEventListener("click", function (e) {
      e.stopPropagation(); // Evita que se dispare el evento del documento
      const menu = document.getElementById("user-menu");
      menu.classList.toggle("active");
    });
  
    document.addEventListener("click", function (e) {
      const menu = document.getElementById("user-menu");
      const avatar = document.getElementById("avatar");
      if (menu && !menu.contains(e.target) && e.target !== avatar) {
        menu.classList.remove("active");
      }
    });
  } */
   
    function authlike() {
      const token = params.get('token');
      document.getElementById('token_recover').value = token;
      showModal('reset');
  };



function login(){
  if (validate_login() == true) {
    var data = $('#login_form').serialize();
    ajaxpromise('POST', 'index.php?module=auth&op=login', data, 'json')
    .then(function (result) {
      console.log("resultado", result);
      if(result == 'error_correo' || result == 'error_passwd'){
        document.getElementById('passworderror').innerHTML = 'Email o Contraseña incorrectos';
        document.getElementById('passworderror').style.display = 'block';
        console.log('Email o Contraseña incorrectos');
     }  else if (result == 'error_activo') {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Tu cuenta no está activa, revisa tu correo electrónico.",
            footer: '<a href="#">Que ha pasado?</a>'
          });
      } else {
        localStorage.setItem('token', JSON.stringify(result));
        console.log('Token guardado en localStorage:', result.avatar);
        console.log('Login successful');
        Swal.fire({
          title: '¡Inicio de sesión exitoso!',
          text: 'Has accedido correctamente.',
          icon: 'success',
          showConfirmButton: false,
          timer: 1500
        });
          setTimeout(function () {
          window.location.reload(); 
        }, 1500);
      }
    })
  } 
}


function register(){
  if (validate_register() == true) {
    var data = $('#register_form').serialize();
    ajaxpromise('POST', 'index.php?module=auth&op=register', data, 'json')
    .then(function (result) {
      if(result == 'error_correo'){ 
        document.getElementById('emailerror1').innerHTML = 'El correo ya existe';
        document.getElementById('emailerror1').style.display = 'block';
        console.log('Correo inválido');
      } else if (result == 'error') {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Algo ha ido mal!",
          footer: '<a href="#">Que ha pasado?</a>'
        });

  

      } else if (result == 'ok') {
        Swal.fire({
          title: '¡Registro completado!',
          text: 'Tu cuenta ha sido creada correctamente.',
          icon: 'success',
          showConfirmButton: false,
          timer: 1500
        });
          setTimeout(function () {
          window.location.reload(); 
        }, 1500);
      }
      console.log("result", result);
    })
  } 
}



function clicks_auth(){
  $(document).on('click', '#ir_login', function (e) {
    console.log('click login');
    e.preventDefault();
    login();
    
  });
  $(document).on('click', '#ir_recover', function(e){
    e.preventDefault();
    recover();
  });

$(document).on('click', '#ir_register', function (e) {
  e.preventDefault();
  register();
});
  $(document).on('click', '#ir_reset', function(e){
    e.preventDefault();
    resetPassword();
  });

$("#register_form").keypress(function(e) {
  var code = (e.keyCode ? e.keyCode : e.which);
  if (code == 13) {
      e.preventDefault();
      register();
  }
});
$("#login_form").keypress(function(e) {
  console.log('enter login');
  var code = (e.keyCode ? e.keyCode : e.which);
  if (code == 13) {
      e.preventDefault();
      login();
  }
});
}
  function validate_login(){
    const v_correo         = document.getElementById('correo_login').value;
    const v_password      = document.getElementById('password_login').value;
    const r_password      = validate_password(v_password);
    const r_correo    = validate_email(v_correo);

    if (!r_correo) {
      document.getElementById('emailerror').innerHTML = 'Correo inválido';
      document.getElementById('emailerror').style.display = 'block';
      console.log('Correo inválido');
    } else {
      document.getElementById('emailerror').style.display = 'none';
    }
    if (!r_password) {
      document.getElementById('passworderror').innerHTML = 'Contraseña inválida';
      document.getElementById('passworderror').style.display = 'block';
      console.log('Contraseña inválida');
    } else {
      document.getElementById('passworderror').style.display = 'none';
    }
    if (r_password && r_correo) {
      return true;
    } else {
      return false;
    }
  }

  function validate_register(){
    const v_nombre         = document.getElementById('username_register').value;
    const v_password     = document.getElementById('password_register').value;
    const v_correo    = document.getElementById('correo_register').value;

    const r_nombre         = validate_username(v_nombre);
    const r_password      = validate_password(v_password);
    const r_correo    = validate_email(v_correo);

    if (!r_correo) {
      document.getElementById('emailerror1').innerHTML = 'Correo inválido';
      document.getElementById('emailerror1').style.display = 'block';
      console.log('Correo inválido');
    } else {
      document.getElementById('emailerror1').style.display = 'none';
    }


    if (!r_password) {
      document.getElementById('passworderror1').innerHTML = 'Contraseña inválida';
      document.getElementById('passworderror1').style.display = 'block';
      console.log('Contraseña inválida');
    } else {
      document.getElementById('passworderror1').style.display = 'none';
    }


    if (!r_nombre) {
      document.getElementById('usernameerror1').innerHTML = 'Usuario inválido';
      document.getElementById('usernameerror1').style.display = 'block';
      console.log('usuario inválido');
    } else {
      document.getElementById('usernameerror1').style.display = 'none';
    }

  
    if (r_nombre && r_password && r_correo) {
      return true;
    } else {
      return false;
    }
  } 



  function validate_username(texto) {
    if (texto.length > 0) {
      var reg = /^[a-zA-Z0-9_]{4,16}$/;
      return reg.test(texto);
    }
    return false;
  }
  function validate_password(texto) {
    if (texto.length > 0) {
      var reg = /^[a-zA-Z0-9_]{4,16}$/;
      return reg.test(texto);
    }
    return false;
  }

  function validate_email(texto) {
    if (texto.length > 0) {
      var reg = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      return reg.test(texto);
    }
    return false;
  }



function validate_recover(){
  const email = document.getElementById('correo_recover').value;
  const ok    = validate_email(email);
  if (!ok) {
    document.getElementById('recovererror').innerHTML = 'Correo inválido';
    document.getElementById('recovererror').style.display = 'block';
  } else {
    document.getElementById('recovererror').style.display = 'none';
  }
  return ok;
}

function recover(){
  console.log('click recover');
  if (!validate_recover()) return;
  const data = $('#recover_form').serialize();
  ajaxpromise('POST', 'index.php?module=auth&op=recover', data, 'json')
    .then(result => {
      if (result === 'error_noexist') {
        Swal.fire({
          icon: 'error',
          title: 'Ups…',
          text: 'Ese correo no está registrado.' 
        });
      } else if (result === 'ok') {
        Swal.fire({
          icon: 'success',
          title: '¡Listo!',
          text: 'Revisa tu correo para restablecer tu contraseña.',
          showConfirmButton: false,
          timer: 2000
        });
        setTimeout(() => modal.classList.add('hidden'), 2100);
      } else if (result === 'error_social') {
        Swal.fire('No disponible','No puedes recuperar la contraseña de cuentas sociales.','warning');
      }else {
        console.error('Recover inesperado:', result);
      }
    })
    .catch(err => console.error(err));
}


function validate_reset(){
  const p1 = document.getElementById('password_new').value;
  const p2 = document.getElementById('password_confirm').value;
  const ok1 = validate_password(p1);      
  const match = p1 === p2;

  if (!ok1) {
    document.getElementById('passwordnewerror').innerText = 'Contraseña inválida';
    document.getElementById('passwordnewerror').style.display = 'block';
  } else {
    document.getElementById('passwordnewerror').style.display = 'none';
  }

  if (!match) {
    document.getElementById('passwordconfirmerror').innerText = 'No coincide';
    document.getElementById('passwordconfirmerror').style.display = 'block';
  } else {
    document.getElementById('passwordconfirmerror').style.display = 'none';
  }

  return ok1 && match;
}

function resetPassword(){
  if (!validate_reset()) return;

  const data = $('#reset_form').serialize(); 
  ajaxpromise('POST', 'index.php?module=auth&op=resetPassword', data, 'json')
    .then(result => {
      if (result === 'error_token') {
        Swal.fire({ icon: 'error', title: 'Token inválido o caducado.' });
      } else if (result === 'ok') {
        Swal.fire({
          icon: 'success',
          title: '¡Contraseña cambiada!',
          text: 'Ya puedes iniciar sesión con tu nueva contraseña.',
          showConfirmButton: false,
          timer: 2000
        });
        setTimeout(() => {
          modal.classList.add('hidden');
          history.replaceState(null, '', window.location.pathname);
        }, 2100);
      }
    })
    .catch(err => console.error(err));
}

  $(window).on('load', function() {
    clicks_auth();
   /*  mostrar_menu(); */
  }); 