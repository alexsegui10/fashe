document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('auth-modal') || false;
    const triggers = document.querySelectorAll('.modal-btn');
    const switches = document.querySelectorAll('.switch');
    const blocks = document.querySelectorAll('.auth-block');
    const closeBtn = document.querySelector('.close-modal');
  
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
  
    closeBtn.addEventListener('click', () => {
      modal.classList.add('hidden');
    });
    if (modal) {
      modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.classList.add('hidden');
      });
    }

  
    function showModal(type) {
      modal.classList.remove('hidden');
      switchForm(type);
    }
  
    function switchForm(type) {
      switches.forEach(sw => sw.classList.toggle('selected', sw.getAttribute('data-type') === type));
      blocks.forEach(block => block.classList.toggle('hidden', block.getAttribute('data-type') !== type));
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
   



function login(){
  if (validate_login() == true) {
    var data = $('#login_form').serialize();
    ajaxpromise('POST', 'module/auth/controller/controller_auth.php?op=login', data, 'json')
    .then(function (result) {
      console.log("resultado", result);
      if(result == 'error_correo' || result == 'error_passwd'){
        document.getElementById('passworderror').innerHTML = 'Email o Contraseña incorrectos';
        document.getElementById('passworderror').style.display = 'block';
        console.log('Email o Contraseña incorrectos');
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
    ajaxpromise('POST', 'module/auth/controller/controller_auth.php?op=register', data, 'json')
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
$(document).on('click', '#ir_register', function (e) {
  e.preventDefault();
  register();
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

  $(window).on('load', function() {
    clicks_auth();
   /*  mostrar_menu(); */
  }); 