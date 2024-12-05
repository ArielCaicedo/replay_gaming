let txtUsuario = document.getElementById('usuario');
txtUsuario.addEventListener('blur', function () {
    existeUsuario(txtUsuario.value);
}, false);

let txtEmail = document.getElementById('email');
txtEmail.addEventListener('blur', function () { // Cambiado de txtUsuario a txtEmail
    existeEmail(txtEmail.value);
}, false);

function existeUsuario(usuario) {
    let url = "clases/cliente_ajax.php";
    let formData = new FormData();
    formData.append("action", "existeUsuario");
    formData.append("usuario", usuario);

    console.log("Enviando solicitud para verificar usuario:", usuario);

    fetch(url, {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log("Respuesta recibida:", data);
            if (data.ok) {
                document.getElementById('usuario').value = '';
                document.getElementById('validaUsuario').innerHTML = 'Usuario no disponible';
            } else {
                document.getElementById('validaUsuario').innerHTML = '';
            }
        })
        .catch(error => {
            console.error("Error al verificar usuario:", error);
        });
}

function existeEmail(email) {
    let url = "clases/cliente_ajax.php";
    let formData = new FormData();
    formData.append("action", "existeEmail");
    formData.append("email", email);

    console.log("Enviando solicitud para verificar email:", email);

    fetch(url, {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log("Respuesta recibida:", data);
            if (data.ok) {
                document.getElementById('email').value = '';
                document.getElementById('validaEmail').innerHTML = 'Email no disponible';
            } else {
                document.getElementById('validaEmail').innerHTML = '';
            }
        })
        .catch(error => {
            console.error("Error al verificar email:", error);
        });
}