
function cargar_menu() {
    var token = JSON.parse(localStorage.getItem('token')) || false;
    console.log("token", token);
    if (token != false) {
        ajaxpromise(
          'POST',
          'index.php?module=auth&op=data_user',
          { token: token },
          'json'
        )    .then(function(resultado) {
        console.log("resultado123", resultado);
        console.log("resultado123"); 
        if (resultado) {
          document.getElementById("avatar").src = resultado.avatar;
          document.getElementById("auth_all").innerHTML = "";
          console.log("esereeee123",resultado.avatar);
          document.getElementById("auth_all_menu").innerHTML = `
          <h3>${resultado.nombre}<br /><span>${resultado.correo}</span></h3>
          <ul>
            <li>
              <img src="./views/icon/user.png" /><a href="#" id="cuenta_btn">Cuenta</a>
            </li>
            <li>
              <img src="./views/icon/edit.png" /><a href="#" id="favoritos_btn">Favoritos</a>
            </li>
             <li>
            <img src="./views/icon/settings.png" /><a href="#">Ajustes</a>
          </li>
          <li><img src="./views/icon/question.png" /><a href="#">Ayuda</a></li>
            <li>
              <img src="./views/icon/log-out.png" /><a href="#" id="logout">Cerrar sesión</a>
            </li>
          </ul>
        `;
      }
    }).catch(function(error){
        console.error("Error en AJAX", error);
    });
    } else {
      document.getElementById("all_menu").innerHTML = "";

    }
  }


    function menuToggle() {
    const toggleMenu = document.getElementById("auth_all_menu");
    toggleMenu.classList.toggle("active");
  }
  
  function logout() {
    $(document).on('click', '#logout', function () {
        localStorage.removeItem('token');
        Swal.fire({
          title: '¡Sesión cerrada!',
          text: 'Has cerrado sesión correctamente.',
          icon: 'success',
          showConfirmButton: false,
          timer: 1500
        });
        setTimeout(function () {
          window.location.reload(); 
        }, 1500);
    });
  }



  
// ------------------- LOAD CONTENT ------------------------ //
function load_content() {
  const params = new URLSearchParams(window.location.search);
  if (params.get('verified') === '1') {
    Swal.fire({
      title: '¡Email verificado!',
      text: 'Tu cuenta ya está activa.',
      icon: 'success',
      confirmButtonText: 'Aceptar'
    }).then(() => {
     /// showModal("hidden");
      params.delete('verified');
      const newSearch = params.toString();
      const newUrl = window.location.pathname + (newSearch ? '?' + newSearch : '');
      history.replaceState(null, '', newUrl);
    });
  }

}


  $(window).on('load', function() {
    load_content();
    cargar_menu();
    logout();
  });