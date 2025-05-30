document.addEventListener('DOMContentLoaded', () => {    
const firebaseConfig = {

  };
  firebase.initializeApp(firebaseConfig);
  const auth = firebase.auth();
  document.getElementById('google-login').type = 'button';
document
  .getElementById('google-login')
  .addEventListener('click', async e => {
    e.preventDefault();
    const provider = new firebase.auth.GoogleAuthProvider();
    try {
      const result = await firebase.auth().signInWithPopup(provider);
      const credential    = result.credential;
      const googleIdToken = credential.idToken;

      const jwt = await ajaxpromise(
        'POST',
        'index.php?module=auth&op=social_login',
        { idToken: googleIdToken, provider: 'google' },
        'json'
      );

      if (jwt === 'error_token') {
        Swal.fire('Error','Token de Google inválido','error');
      } else if (jwt === 'error_activo') {
        Swal.fire('Cuenta bloqueada','Activa tu cuenta desde tu correo','warning');
      } else {
        localStorage.setItem('token', JSON.stringify(jwt));
        Swal.fire('¡Login con Google correcto!','Redirigiendo…','success')
          .then(() => window.location.reload());
      }
    } catch (err) {
      console.error('Social login error', err);
      Swal.fire('Error en social login','Revisa la consola para más detalles','error');
    }
  });
});

