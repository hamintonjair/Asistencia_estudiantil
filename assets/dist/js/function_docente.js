//insertar docentes
document.addEventListener("DOMContentLoaded", function() {

    if (document.querySelector("#frmdocentes")) {
        let frmDocentes = document.querySelector("#frmdocentes");
        frmDocentes.onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            // Función para mostrar el indicador de carga

            function showLoading() {
                $('.loading-overlay').fadeIn();
            }

            // Función para ocultar el indicador de carga
            function hideLoading() {
                $('.loading-overlay').fadeOut();
            }
            let base_url = 'http://localhost/Asistencia_estudiantil/';
            const nombre = document.querySelector('#nombre').value;
            const apellidos = document.querySelector('#apellidos').value;
            const cedula = document.querySelector('#cedula').value;
            const telefono = document.querySelector('#telefono').value;
            const direccion = document.querySelector('#direccion').value;
            const correo = document.querySelector('#correo').value;

            document.querySelector('#idDocente').value = "";


            if (nombre == "" || apellidos == "" || clave == "" || cedula == "" || telefono == "" || direccion == "" || correo == "") {

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
                    url: base_url + 'Docentes/registrar',
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
                            $('#modalDocente').modal('hide');
                            setTimeout(function() {
                                dataTableD.ajax.reload();
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
                        }
                    }

                });
            }
        }
    }
    if (document.querySelector("#frmjefe")) {
        let frmDocentes = document.querySelector("#frmjefe");
        frmDocentes.onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            // Función para mostrar el indicador de carga
            function showLoading() {
                $('.loading-overlay').fadeIn();
            }

            // Función para ocultar el indicador de carga
            function hideLoading() {
                $('.loading-overlay').fadeOut();
            }
            let base_url = 'http://localhost/Asistencia_estudiantil/';
            const nombre = document.querySelector('#nombre').value;
            const apellidos = document.querySelector('#apellidos').value;
            const cedula = document.querySelector('#cedula').value;
            const telefono = document.querySelector('#telefono').value;
            const direccion = document.querySelector('#direccion').value;
            const correo = document.querySelector('#correo').value;
            const id_materia = document.querySelector('#id_materia').value;

            document.querySelector('#idDocente').value = "";


            if (nombre == "" || id_materia == "" || apellidos == "" || clave == "" || cedula == "" || telefono == "" || direccion == "" || correo == "") {

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
                    url: base_url + 'Docentes/registrar',
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
                            $('#modalJefe').modal('hide');
                            setTimeout(function() {
                                dataTableJ.ajax.reload();
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
                        }
                    }

                });
            }
        }
    }

})
let dataTableD;
document.addEventListener("DOMContentLoaded", function() {

        let base_url = 'http://localhost/Asistencia_estudiantil/';
        dataTableD = $('#tableDocentes').DataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
            dom: 'lBfrtip',
            "ajax": {
                "url": " " + base_url + "Docentes/listar",
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
                },

            ],
            "responsive": "true",
            "bDestroy": true,
            "iDisplayLength": 10,
            "order": [
                [0, "desc"]
            ],
            "autoWidth": true,
        })
    })
    //editar docente
function editarDocente(id) {
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnDocente').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    document.querySelector('#titleModal').innerHTML = "Actualizar docente";
    document.querySelector('#frmdocentes').reset();
    let base_url = 'http://localhost/Asistencia_estudiantil/';

    $.ajax({
        url: base_url + 'Docentes/editar/' + id,
        type: "GET",
        dataType: "json",
        data: {
            id: id
        },
        success: function(resp) {
            $('#idDocente').val(resp[0].id);
            $('#nombre').val(resp[0].nombre);
            $('#apellidos').val(resp[0].apellidos);
            $('#cedula').val(resp[0].cedula);
            $('#telefono').val(resp[0].telefono);
            $('#direccion').val(resp[0].direccion);
            $('#correo').val(resp[0].correo);
            $('#clave').val(resp[0].clave);
            $('#perfil').val(resp[0].rol);
            $('#modalDocente').modal('show');
        }
    })
}
//eliminar materias
function eliminarDocente(id) {
    let base_url = 'http://localhost/Asistencia_estudiantil/';
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Realmente quiere eliminar el docente?',
        text: "El docente se eliminará de forma permanente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Eliminar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Docentes/deleteDocente/" + id;
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
                            dataTableD.ajax.reload();
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
                'El docente no fue eliminado',
                'error'
            )
        }
    })
}
//ver detalles
//mas informacion del alumno

function verDetalleD(id) {
    let base_url = 'http://localhost/Asistencia_estudiantil/';

    $.ajax({
        type: 'POST',
        url: base_url + 'Docentes/getDocente/' + id,
        dataType: "json",
        data: {
            id: id
        },
        success: function(data) {
            let modalContent = '';

            modalContent += '<h4>Programas y Cursos Asignados</h4>';
            modalContent += '<table class="table table-bordered">';
            modalContent += '<tr><th>Programa</th><th>Curso</th><th>Semestre</th><th>Estado</th><th>Fecha</th></tr>';
            if (data[0].curso == null) {
                modalContent += '<tr>';
                modalContent += '<td>' + "No hay registro" + '</td>';
                modalContent += '<td>' + "No hay registro" + '</td>';
                modalContent += '<td>' + "No hay registro" + '</td>';
                modalContent += '<td class="badge badge-danger">' + "No asignado" + '</td>';
                modalContent += '<td>' + "No hay registro" + '</td>';
                modalContent += '</tr>';
            } else {

                for (let i = 0; i < data.length; i++) {
                    modalContent += '<tr>';
                    modalContent += '<td>' + data[i].programa + '</td>';
                    modalContent += '<td>' + data[i].curso + '</td>';
                    modalContent += '<td>' + data[i].semestre + '</td>';
                    modalContent += '<td class="badge badge-success">' + data[i].asignaciones + '</td>';
                    modalContent += '<td>' + data[i].fecha + '</td>';
                    modalContent += '</tr>';
                }

            }

            modalContent += '</table>';

            // Agregar el contenido del modal
            $('#modalViewDocente .modal-body').html(modalContent);
            // Mostrar el modal
            $('#modalViewDocente').modal('show');
        }
    });
}


//mas detalles
function detallesD() {
    let base_url = 'http://localhost/Asistencia_estudiantil/';
    const id = document.querySelector('#id').value;

    $.ajax({
        type: 'POST',
        url: base_url + 'Perfil/masDetalles/' + id,
        dataType: "json",
        data: {
            id: id
        },
        success: function(dato) {

            // Mostrar programas, cursos, desde y hasta en una tabla dentro del modal
            var contenidoTabla = '<table>';
            contenidoTabla += '<tr><th>Programas</th><th>Cursos</th><th>Semestres</th><th>Estado</th><th>Fecha</th></tr>';
            for (var i = 0; i < dato.length; i++) {
                contenidoTabla += '<tr>';
                contenidoTabla += '<td>' + dato[i].programa + '</td>';
                contenidoTabla += '<td>' + dato[i].curso + '</td>';
                contenidoTabla += '<td>' + dato[i].semestre + '</td>';
                contenidoTabla += '<td class="badge badge-success">' + dato[i].estado + '</td>';
                contenidoTabla += '<td>' + dato[i].fecha + '</td>';
                contenidoTabla += '</tr>';
            }
            contenidoTabla += '</table>';
            document.querySelector("#tablaProgramasCursosAsignados").innerHTML = contenidoTabla;

            $('#modalDetallesD').modal("show");
        }
    });
}

function openModalDocentes() {
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnDocente').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Agregar";
    document.querySelector('#titleModal').innerHTML = " Nuevo docente";
    document.querySelector('#frmdocentes').reset();
    $('#modalDocente').modal('show');

}
//jefe de programas datatable
let dataTableJ;
document.addEventListener("DOMContentLoaded", function() {

        let base_url = 'http://localhost/Asistencia_estudiantil/';
        dataTableJ = $('#tableJefe').DataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
            dom: 'lBfrtip',
            "ajax": {
                "url": " " + base_url + "Docentes/listarJ",
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
                { "data": "programa" },
                { "data": "estado", className: 'centered' },
                { "data": "acciones", className: 'centered' },
            ],
            buttons: [{
                    "extend": "copyHtml5",
                    "text": "<i class='far fa-copy'></i> Copiar",
                    "titleAttr": "Copiar",
                    "className": "btn btn-secondary",
                    "exportOptions": {
                        "columns": [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                }, {
                    "extend": "excelHtml5",
                    "text": "<i class='fas fa-file-excel'></i> Excel",
                    "titleAttr": "Expotar a Excel",
                    "className": "btn btn-success",
                    "exportOptions": {
                        "columns": [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                }, {
                    "extend": "pdfHtml5",
                    "text": "<i class='fas fa-file-pdf'></i> PDF",
                    "titleAttr": "Exportar a PDF",
                    "className": "btn btn-danger",
                    "exportOptions": {
                        "columns": [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                }, {
                    "extend": "csvHtml5",
                    "text": "<i class='faa fa-file-csv'></i> CSV",
                    "titleAttr": "Eportar",
                    "className": "btn btn-secondary",
                    "exportOptions": {
                        "columns": [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },

            ],
            "responsive": "true",
            "bDestroy": true,
            "iDisplayLength": 10,
            "order": [
                [0, "desc"]
            ],
            "autoWidth": true,
        })
    })
    //editar docente
function editarJefe(id) {
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnJefe').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    document.querySelector('#titleModal').innerHTML = "Actualizar jefe de programa";
    document.querySelector('#frmjefe').reset();
    let base_url = 'http://localhost/Asistencia_estudiantil/';

    $.ajax({
        url: base_url + 'Docentes/editar/' + id,
        type: "GET",
        dataType: "json",
        data: {
            id: id
        },
        success: function(resp) {
            $('#idDocente').val(resp[0].id);
            $('#nombre').val(resp[0].nombre);
            $('#apellidos').val(resp[0].apellidos);
            $('#cedula').val(resp[0].cedula);
            $('#telefono').val(resp[0].telefono);
            $('#direccion').val(resp[0].direccion);
            $('#correo').val(resp[0].correo);
            $('#clave').val(resp[0].clave);
            $('#perfil').val(resp[0].rol);
            $('#id_materia').val(resp[0].idMateria);
            $('#modalJefe').modal('show');
        }
    })
}
//eliminar materias
function eliminarJefe(id) {
    let base_url = 'http://localhost/Asistencia_estudiantil/';
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Realmente quiere eliminar el registro?',
        text: "El registro se eliminará de forma permanente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Eliminar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Docentes/deleteDocente/" + id;
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
                            dataTableD.ajax.reload(),
                                dataTableJ.ajax.reload()
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
                'El registro no fue eliminado',
                'error'
            )
        }
    })
}

//filtro
function filtrarCedulaD() {
    const input = document.getElementById("buscador");
    const filter = input.value.toUpperCase();
    const select = document.getElementById("cedulaD");
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
//buscar por cedula
function buscarCedulaD() {
    let base_url = 'http://localhost/Asistencia_estudiantil/';

    const select = $("#cedulaD");
    const ced = select.val();

    $.ajax({
        url: base_url + 'Docentes/buscarEstudiante/' + ced,
        type: "GET",
        dataType: "json",
        data: {
            ced: ced
        },
        success: function(resp) {

            let html = '';

            resp.forEach(row => {
                    html += `<tr>
                        <td>${row['id']}</td>
                        <td>${row['nombre']}</td>
                        <td>${row['apellidos']}</td>
                        <td>${row['cedula']}</td>                       
                        <td>${row['telefono']}</td>
                        <td>${row['direccion']}</td>
                        <td>${row['correo']}</td>
                        <td>${row['estado']}</td>         
                        <td>${row['acciones']}</td>         

                        </tr>`
                }),

                document.getElementById("tableAlumnosD").innerHTML = html;
            // Configuración de DataTables
        }
    });
}


function openModalJefe() {
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnJefe').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Agregar";
    document.querySelector('#titleModal').innerHTML = " Nuevo jefe de prgrama";
    document.querySelector('#frmjefe').reset();
    $('#modalJefe').modal('show');

}