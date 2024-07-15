document.addEventListener('DOMContentLoaded', function() {
    //resetear password
    if (document.querySelector("#frmLogin")) {
        let formulario = document.querySelector("#frmLogin");
        formulario.onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            let base_url = 'http://localhost/Asistencia_estudiantil/';
            const email = document.querySelector('#email').value;
            const password = document.querySelector('#password').value;
            const perfil = document.querySelector('#perfil').value;

            if (email == "" || password == "" || perfil == "") {
                alerta('Error', 'Todos los campos son obligatorios.', 'error');

            } else {
                $.ajax({
                    type: 'post',
                    url: base_url + 'Login/validar',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.ok == true) {
                            alerta('Success', response.post, 'success');
                            setTimeout(function() {
                                window.location = base_url + 'dashboard/administracion'
                            }, 2000);

                        } else {
                            alerta('Error', response.post, 'error');

                        }
                    }

                });
            }
        }
    }
    if (document.querySelector("#formRecetPass")) {
        let base_url = 'http://localhost/Asistencia_estudiantil/';
        let formRecetPass = document.querySelector("#formRecetPass");
        formRecetPass.onsubmit = function(e) {
            e.preventDefault();

            let resetEmail = document.querySelector('#resetEmail').value;

            if (resetEmail == "") {
                alerta("Por favor", "Escribe tu correo electrónico.", "error");
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'Login/resetPass',
                    dataType: "json",
                    data: {
                        "resetEmail": resetEmail,
                    },
                    success: function(datos) {

                        if (datos.status == true) {

                            Swal.fire({
                                title: "",
                                text: datos.post,
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Aceptar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = base_url + 'login';
                                }
                            })
                        } else {
                            alerta("Error", datos.msg, "error");
                        }
                    },
                    error: function() {

                        alerta("Atención", "Error en el proceso", "error");
                    }
                })
            }
        }
    }
    //cambiar password
    if (document.querySelector("#formCambiarPass")) {
        let base_url = 'http://localhost/Asistencia_estudiantil/';
        let formCambiarPass = document.querySelector("#formCambiarPass");
        formCambiarPass.onsubmit = function(e) {
            e.preventDefault();

            let strPassword = document.querySelector('#resetPassword').value;
            let strPasswordConfirm = document.querySelector('#resetPasswordConfirm').value;
            let idDocente = document.querySelector('#idDocente').value;
            let strEmail = document.querySelector('#txtEmail').value;
            let strToken = document.querySelector('#txtToken').value;

            if (strPassword == "" || strPasswordConfirm == "") {
                alerta("Por favor", "Escribe la nueva contraseña.", "error");
                return false;
            } else {
                if (strPassword.length < 5) {
                    alerta("Atención", "La contraseña debe tener un mínimo de 5 caracteres.", "info");
                    return false;
                }
                if (strPassword != strPasswordConfirm) {
                    alerta("Atención", "Las contraseñas no son iguales.", "error");
                    return false;
                } else {
                    $.ajax({
                        type: 'POST',
                        url: base_url + 'Login/setPassword',
                        dataType: "json",
                        data: {
                            "idDocente": idDocente,
                            "strEmail": strEmail,
                            "strToken": strToken,
                            "strPassword": strPassword,
                            "strPasswordConfirm": strPasswordConfirm,
                        },
                        success: function(dato) {
                            if (dato.status == true) {

                                Swal.fire({
                                    title: "",
                                    text: dato.post,
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Iniciar sessión'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = base_url + 'login';
                                    }
                                })

                            } else {

                                alerta("Error", dato.msg, "error");
                            }
                        }
                    })
                }
            }
        }
    }

});


function alerta(title, text, icon) {
    Swal.fire({
        title,
        text,
        icon,
    })

}