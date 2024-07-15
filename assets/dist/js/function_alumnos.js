//insertar alumnos
document.addEventListener("DOMContentLoaded", function() {
    if (document.querySelector("#frmalumno")) {
        let frmalumno = document.querySelector("#frmalumno");
        frmalumno.onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            let base_url = 'http://localhost/Asistencia_estudiantil/';
            const nombre = document.querySelector('#nombre').value;
            const apellidos = document.querySelector('#apellidos').value;
            const cedula = document.querySelector('#cedula').value;
            const telefono = document.querySelector('#telefono').value;
            const direccion = document.querySelector('#direccion').value;
            const id_materia = document.querySelector('#id_materia').value;
            const semestre = document.querySelector('#semestre').value;
            const idCurso = document.querySelector('#idCurso').value;
            const correo = document.querySelector('#correo').value;
            const matriculado = document.querySelector('#matriculado').value;
            document.querySelector('#idAlumno').value = "";

            // Función para mostrar el indicador de carga
            function showLoading() {
                $('.loading-overlay').fadeIn();
            }

            // Función para ocultar el indicador de carga
            function hideLoading() {
                $('.loading-overlay').fadeOut();
            }
            if (nombre == "" || apellidos == "" || matriculado == "" | id_materia == "Seleccionar.." ||
                semestre == "Seleccionar.." || cedula == "" || telefono == "" || direccion == "" || correo == "" || idCurso == "Seleccionar..") {

                Swal.fire({
                    position: 'top-end',
                    icon: 'info',
                    title: 'Todos los campos son obligatorios',
                    showConfirmButton: false,
                    timer: 2200
                })
            } else {
                showLoading();

                $.ajax({
                    type: 'post',
                    url: base_url + 'Alumnos/registrar',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.ok == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: response.post,
                                showConfirmButton: false,
                                timer: 2200
                            })
                            hideLoading();
                            $('#modalAlumno').modal('hide');
                            setTimeout(function() {
                                dataTableA.ajax.reload();
                            }, 2000);


                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: response.post,
                                showConfirmButton: false,
                                timer: 2200
                            })
                            hideLoading();
                            $('#modalAlumno').modal('hide');

                        }
                    }

                });
            }
        }
    }

})
let dataTableA;
document.addEventListener("DOMContentLoaded", function() {

        let base_url = 'http://localhost/Asistencia_estudiantil/';
        dataTableA = $('#tableAlumnos').DataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
            dom: 'lBfrtip',
            "ajax": {
                "url": " " + base_url + "Alumnos/listar",
                "dataSrc": ""
            },
            "columns": [
                { "data": "id" },
                { "data": "nombre" },
                { "data": "apellidos" },
                { "data": "cedula" },
                { "data": "telefono" },
                { "data": "direccion" },
                { "data": "correo" },
                { "data": "estado", className: 'centered' },
                { "data": "acciones", className: 'centered' },
            ],
            buttons: [{
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5, 6]
                }
            }, {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Expotar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5, 6]
                }
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Exportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5, 6]
                }
            }, {
                "extend": "csvHtml5",
                "text": "<i class='faa fa-file-csv'></i> CSV",
                "titleAttr": "Eportar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0, 1, 2, 3, 4, 5, 6]
                }
            }, ],
            "responsive": "true",
            "bDestroy": true,
            "iDisplayLength": 10,
            "order": [
                [0, "desc"]
            ],
            "autoWidth": true,
        })
    })
    //editar alumno
function editarAlumno(id) {
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnAlumno').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    document.querySelector('#titleModal').innerHTML = "Actualizar estudiante";
    document.querySelector('#frmalumno').reset();
    let base_url = 'http://localhost/Asistencia_estudiantil/';

    $.ajax({
        url: base_url + 'Alumnos/editar/' + id,
        type: "GET",
        dataType: "json",
        data: {
            id: id
        },
        success: function(resp) {
            $('#idAlumno').val(resp[0].id);
            $('#nombre').val(resp[0].nombre);
            $('#apellidos').val(resp[0].apellidos);
            $('#cedula').val(resp[0].cedula);
            $('#telefono').val(resp[0].telefono);
            $('#direccion').val(resp[0].direccion);
            $('#id_materia').val(resp[0].idMateria);
            $('#idCurso').val(resp[0].idCurso);
            $('#semestre').val(resp[0].semestre);
            $('#password').val(resp[0].clave);
            $('#correo').val(resp[0].correo);
            $('#matriculado').val(resp[0].aprobado);
            $('#modalAlumno').modal('show');
        }
    })
}
//eliminar materias
function eliminarAlumno(id) {
    let base_url = 'http://localhost/Asistencia_estudiantil/';
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Realmente quiere eliminar el estudiante?',
        text: "El estudiante se eliminará de forma permanente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Eliminar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Alumnos/deleteAlumno/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    const resp = JSON.parse(this.responseText);

                    if (resp.ok == true) {
                        swalWithBootstrapButtons.fire(
                            'Eliminado!',
                            resp.post,
                            'success',
                        );
                        setTimeout(function() {
                            dataTableA.ajax.reload();
                        }, 2000);
                    } else {
                        swalWithBootstrapButtons.fire(
                            'Cancelado!',
                            resp.msg,
                            'error'
                        );
                    }
                }
            }

        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Cancelado!',
                'El alumno no fue eliminado',
                'error'
            )
        }
    })
}
//mas informacion del alumno
function verDetalle(id) {

    let base_url = 'http://localhost/Asistencia_estudiantil/';

    $.ajax({
        type: 'POST',
        url: base_url + 'Alumnos/getAlumno/' + id,
        dataType: "json",
        data: {
            id: id
        },
        success: function(dato) {

            var estadoUsuario = dato.estado == 1 ?
                '<span class="badge badge-success">Activo</span>' :
                '<span class="badge badge-danger">Inactivo</span>';

            document.querySelector("#celIdentificacion").innerHTML = dato.cedula;
            document.querySelector("#celNombre").innerHTML = dato.nombre;
            document.querySelector("#celApellido").innerHTML = dato.apellidos;
            document.querySelector("#celCedula").innerHTML = dato.cedula;
            document.querySelector("#celTelefono").innerHTML = dato.telefono;
            document.querySelector("#celDireccion").innerHTML = dato.direccion;
            document.querySelector("#celEmail").innerHTML = dato.correo;
            document.querySelector("#celSemestre").innerHTML = dato.semestre;
            document.querySelector("#celPrograma").innerHTML = dato.programa;
            document.querySelector("#celCurso").innerHTML = dato.curso;
            document.querySelector("#celDocente").innerHTML = dato.nomb + dato.apell;
            document.querySelector("#celMatriculado").innerHTML = dato.aprobado;
            document.querySelector("#celEstado").innerHTML = estadoUsuario;
            document.querySelector("#celFechaRegistro").innerHTML = dato.fecha;
            $('#modalViewUser').modal("show");
        }
    })
}
//mas informacion del alumno
function detallesA() {

    let base_url = 'http://localhost/Asistencia_estudiantil/';
    const cedula = document.querySelector('#cedula').value;

    $.ajax({
        type: 'POST',
        url: base_url + 'Perfil/masDetalles/' + cedula,
        dataType: "json",
        data: {
            cedula: cedula
        },
        success: function(dato) {
            var contenidoTabla = '<table>';
            contenidoTabla += '<tr><th>Semestres</th><th>Programas</th><th>Cursos</th><th>Docentes</th><th>Matriculado</th><th>Estado</th><th>Fecha</th></tr>';
            for (var i = 0; i < dato.length; i++) {
                var estado;
                if (dato[i].estado == 1) {
                    estado = "Activo";
                } else {
                    estado = "Inactivo";
                }
                contenidoTabla += '<tr>';
                contenidoTabla += '<td>' + dato[i].semestre + '</td>';
                contenidoTabla += '<td>' + dato[i].programa + '</td>';
                contenidoTabla += '<td>' + dato[i].curso + '</td>';
                contenidoTabla += '<td>' + dato[i].nombre + ' ' + dato[i].apellidos + '</td>';
                contenidoTabla += '<td class="centered ">' + dato[i].aprobado + '</td>';
                contenidoTabla += '<td class="badge badge-success centered">' + estado + '</td>';
                contenidoTabla += '<td>' + dato[i].fecha + '</td>';
                contenidoTabla += '</tr>';
            }
            contenidoTabla += '</table>';
            document.querySelector("#tablaProgramasCursosAsignadosA").innerHTML = contenidoTabla;

            $('#modalDetalles').modal("show");
        }
    })
}
//actualizar perfil
function actualizarPerfil() {
    let base_url = 'http://localhost/Asistencia_estudiantil/';

    const id = document.querySelector('#id').value;
    const telefono = document.querySelector('#telefono').value;
    const direccion = document.querySelector('#direccion').value;
    const correo = document.querySelector('#correo').value;
    const clave = document.querySelector('#clave').value;
    const idClave = document.querySelector('#idClave').value;
    const perfil = document.querySelector('#perfil').value;

    $.ajax({
        type: 'POST',
        url: base_url + 'Perfil/updatePerfil/' + id,
        dataType: "json",
        data: {
            id: id,
            telefono: telefono,
            direccion: direccion,
            correo: correo,
            clave: clave,
            idClave: idClave,
            perfil: perfil
        },
        success: function(dato) {
            if (dato.ok == true) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: dato.post,
                    showConfirmButton: false,
                    timer: 2200
                })
                setTimeout(function() {
                    location.reload();
                }, 2000);
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: dato.post,
                    showConfirmButton: false,
                    timer: 2200
                })
            }

        }
    })

}
//buscar por cedula
function buscarCedula() {

    let base_url = 'http://localhost/Asistencia_estudiantil/';

    const select = $("#cedulaA");
    const ced = select.val();
    // const cod = nomb.replace(/ /g, '+');

    $.ajax({
        url: base_url + 'Alumnos/buscarEstudiante/' + ced,
        type: "GET",
        dataType: "json",
        data: {
            ced: ced
        },
        success: function(resp) {

            if (resp.ok == false) {

                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: resp.post,
                    showConfirmButton: false,
                    timer: 2200
                })
                $("#nombre").focus();

            } else {
                $('#nombre').val(resp[0].nombre);
                $('#apellidos').val(resp[0].apellidos);
                $('#cedula').val(resp[0].cedula);
                $('#telefono').val(resp[0].telefono);
                $('#direccion').val(resp[0].direccion);
                $('#id_materia').val("Seleccionar..");
                $('#idCurso').val("Seleccionar..");
                $('#semestre').val("Seleccionar..");
                $('#clave').val(resp[0].clave);
                $('#correo').val(resp[0].correo);
                $('#matriculado').val(resp[0].aprobado);


            }
        }
    });
}
//filtro
function filtrarCedula() {
    const input = document.getElementById("buscador");
    const filter = input.value.toUpperCase();
    const select = document.getElementById("cedulaA");
    const options = select.getElementsByTagName("option");

    for (let i = 0; i < options.length; i++) {
        const text = options[i].textContent || options[i].innerText;
        if (text.toUpperCase().indexOf(filter) > -1) {
            options[i].style.display = "";
        } else {
            options[i].style.display = "none";
        }
    }
}

function openModalAlumnos() {
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnAlumno').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Agregar";
    document.querySelector('#titleModal').innerHTML = " Nuevo estudiante o asignación";
    document.querySelector('#frmalumno').reset();
    $('#modalAlumno').modal('show');

}