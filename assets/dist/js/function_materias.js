//insertar materias
document.addEventListener("DOMContentLoaded", function() {
    if (document.querySelector("#frmmaterias")) {
        let frmmaterias = document.querySelector("#frmmaterias");
        frmmaterias.onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            let base_url = 'http://localhost/Asistencia_estudiantil/';
            const materia = document.querySelector('#materia').value;
            if (materia == "") {

                Swal.fire({
                    position: 'top-end',
                    icon: 'info',
                    title: 'El campo es obligatorio',
                    showConfirmButton: false,
                    timer: 2200
                })
            } else {
                $.ajax({
                    type: 'post',
                    url: base_url + 'Programas/registrar',
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
                            $('#id_materias').modal('hide');
                            setTimeout(function() {
                                dataTable.ajax.reload();
                            }, 2000);

                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: response.post,
                                showConfirmButton: false,
                                timer: 2200
                            })
                        }
                    }

                });
            }
        };
    }

})
let dataTable;
document.addEventListener("DOMContentLoaded", function() {

        let base_url = 'http://localhost/Asistencia_estudiantil/';
        dataTable = $('#tableMaterias').DataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
            dom: 'lBfrtip',
            "ajax": {
                "url": " " + base_url + "Programas/listar",
                "dataSrc": ""
            },
            "columns": [
                { "data": "id" },
                { "data": "materia" },
                { "data": "estado", className: 'centered' },
                { "data": "acciones", className: 'centered' },

            ],
            buttons: [{
                    "extend": "copyHtml5",
                    "text": "<i class='far fa-copy'></i> Copiar",
                    "titleAttr": "Copiar",
                    "className": "btn btn-secondary",
                    "exportOptions": {
                        "columns": [0, 1]
                    }
                }, {
                    "extend": "excelHtml5",
                    "text": "<i class='fas fa-file-excel'></i> Excel",
                    "titleAttr": "Expotar a Excel",
                    "className": "btn btn-success",
                    "exportOptions": {
                        "columns": [0, 1]
                    }
                }, {
                    "extend": "pdfHtml5",
                    "text": "<i class='fas fa-file-pdf'></i> PDF",
                    "titleAttr": "Exportar a PDF",
                    "className": "btn btn-danger",
                    "exportOptions": {
                        "columns": [0, 1]
                    }
                }, {
                    "extend": "csvHtml5",
                    "text": "<i class='faa fa-file-csv'></i> CSV",
                    "titleAttr": "Eportar",
                    "className": "btn btn-secondary",
                    "exportOptions": {
                        "columns": [0, 1]
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
        });
    })
    //editar materia
function editarMateria(id) {
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnMaterias').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    document.querySelector('#titleModal').innerHTML = "Actualizar programa";
    document.querySelector('#frmmaterias').reset();
    let base_url = 'http://localhost/Asistencia_estudiantil/';

    $.ajax({
        url: base_url + 'Programas/editar/' + id,
        type: "GET",
        dataType: "json",
        data: {
            id: id
        },
        success: function(resp) {
            $('#idMateria').val(resp[0].id);
            $('#materia').val(resp[0].materia);
            $('#nivel').val(resp[0].nivel);

            $('#id_materias').modal('show');
        }
    });
}
//eliminar materias
function eliminarMateria(id) {
    let base_url = 'http://localhost/Asistencia_estudiantil/';
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Realmente quiere eliminar el programa?',
        text: "El programa se eliminará de forma permanente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Eliminar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Programas/deleteMateria/" + id;
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
                            dataTable.ajax.reload();
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
                'El programa no fue eliminado',
                'error'
            )
        }
    })
}

function openModal() {
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnMaterias').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Agregar";
    document.querySelector('#titleModal').innerHTML = "Nuevo programa";
    document.querySelector('#frmmaterias').reset();
    $('#id_materias').modal('show');

}

//vista asignar materia a docentes
function openAsignar() {
    let base_url = 'http://localhost/Asistencia_estudiantil/';
    window.location = base_url + "programas/vistaAsignar";
}

//volver
function openModalVolverP() {
    let base_url = 'http://localhost/Asistencia_estudiantil/';
    window.location = base_url + "ir/a/programas";
}
//ir Asistencias
function openModalAsistencias() {
    let base_url = 'http://localhost/Asistencia_estudiantil/';
    window.location = base_url + "asistencias/asistenciasMarcadas";
}

function openModalVolver() {
    let base_url = 'http://localhost/Asistencia_estudiantil/';
    window.location = base_url + "habilitar/asistencias";
}

function openModalVolverD() {
    let base_url = 'http://localhost/Asistencia_estudiantil/';
    window.location = base_url + "ir/a/docentes";
}

function openModalAsistenciasA() {
    let base_url = 'http://localhost/Asistencia_estudiantil/';
    window.location = base_url + "asistencias/asistenciasMarcadasA";
}

function openModalVolverA() {
    let base_url = 'http://localhost/Asistencia_estudiantil/';
    window.location = base_url + "asistencia/curso";
}
let dataTableAsignar;
document.addEventListener("DOMContentLoaded", function() {

        let base_url = 'http://localhost/Asistencia_estudiantil/';
        dataTableAsignar = $('#tableAsignar').DataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
            dom: 'lBfrtip',
            "ajax": {
                "url": " " + base_url + "Programas/listarAsignacion",
                "dataSrc": ""
            },
            "columns": [
                { "data": "id" },
                { "data": "nombre" },
                { "data": "programa" },
                { "data": "curso" },
                { "data": "semestre" },
                { "data": "estado", className: 'centered' },
                { "data": "acciones", className: 'centered' },

            ],
            buttons: [{
                    "extend": "copyHtml5",
                    "text": "<i class='far fa-copy'></i> Copiar",
                    "titleAttr": "Copiar",
                    "className": "btn btn-secondary",
                    "exportOptions": {
                        "columns": [0, 1, 2, 3, 4, 5]
                    }
                }, {
                    "extend": "excelHtml5",
                    "text": "<i class='fas fa-file-excel'></i> Excel",
                    "titleAttr": "Expotar a Excel",
                    "className": "btn btn-success",
                    "exportOptions": {
                        "columns": [0, 1, 2, 3, 4, 5]
                    }
                }, {
                    "extend": "pdfHtml5",
                    "text": "<i class='fas fa-file-pdf'></i> PDF",
                    "titleAttr": "Exportar a PDF",
                    "className": "btn btn-danger",
                    "exportOptions": {
                        "columns": [0, 1, 2, 3, 4, 5]
                    }
                }, {
                    "extend": "csvHtml5",
                    "text": "<i class='faa fa-file-csv'></i> CSV",
                    "titleAttr": "Eportar",
                    "className": "btn btn-secondary",
                    "exportOptions": {
                        "columns": [0, 1, 2, 3, 4, 5]
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
        });
    })
    //asignar programa


document.addEventListener("DOMContentLoaded", function() {

    if (document.querySelector("#frmAsignar")) {
        let frmAsignar = document.querySelector("#frmAsignar");
        frmAsignar.onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            $("#id_docentes").removeAttr('disabled');
            let base_url = 'http://localhost/Asistencia_estudiantil/';
            const id_materia = document.querySelector('#id_materia').value;
            const id_docentes = document.querySelector('#id_docentes').value;
            const idCurso = document.querySelector('#idCurso').value;
            const semestre = document.querySelector('#semestre').value;

            if (id_materia == "Seleccionar.." || id_docentes == "Seleccionar.." || semestre == "Seleccionar.." ||
                idCurso == "Seleccionar..") {

                Swal.fire({
                    position: 'top-end',
                    icon: 'info',
                    title: 'Todos los campos son obligatorios',
                    showConfirmButton: false,
                    timer: 2200
                })
            } else {
                $.ajax({
                    type: 'post',
                    url: base_url + 'Programas/AsignarPrograma',
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
                            $('#modalAsignar').modal('hide');
                            setTimeout(function() {
                                dataTableAsignar.ajax.reload();
                            }, 2000);
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: response.post,
                                showConfirmButton: false,
                                timer: 2200
                            })
                        }
                    }

                });
            }
        }
    }

})

function openModalAsignar() {
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnAsignar').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Asignar";
    document.querySelector('#titleModal').innerHTML = "Asignar programa a docente";
    document.querySelector('#frmAsignar').reset();
    $('#modalAsignar').modal('show');

}
//editar asignacion
function editarAsignado(id) {
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnAsignar').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    document.querySelector('#titleModal').innerHTML = "Actualizar programa a docente";
    document.querySelector('#frmAsignar').reset();
    let base_url = 'http://localhost/Asistencia_estudiantil/';

    $.ajax({
        url: base_url + 'Programas/editarAsignacion/' + id,
        type: "GET",
        dataType: "json",
        data: {
            id: id
        },
        success: function(resp) {
            $('#idAsignar').val(resp[0].id);
            $('#id_materia').val(resp[0].idMateria);
            $('#id_docentes').val(resp[0].idDocente);
            $('#idCurso').val(resp[0].idCurso);
            $('#semestre').val(resp[0].semestre);
            $('#modalAsignar').modal('show');
        }
    });
}
//eliminar asignacion
function eliminarAsignado(id) {
    let base_url = 'http://localhost/Asistencia_estudiantil/';
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Realmente quiere eliminar la asignación?',
        text: "La asignación se eliminará de forma permanente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Eliminar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Programas/deleteAsignacion/" + id;
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
                            dataTableAsignar.ajax.reload();
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
                'La asignación no fue eliminado',
                'error'
            )
        }
    })
}
//modal curso

function openCurso() {
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnCurso').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Agregar";
    document.querySelector('#titleModal').innerHTML = "Nuevo curso";
    document.querySelector('#frmcurso').reset();
    $('#modalCurso').modal('show');

}
//e
//vista curso
function openCursos() {
    let base_url = 'http://localhost/Asistencia_estudiantil/';
    window.location = base_url + "programas/cursos_";
}
let dataTableC;
document.addEventListener("DOMContentLoaded", function() {

        let base_url = 'http://localhost/Asistencia_estudiantil/';
        dataTableC = $('#tableCurso').DataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
            dom: 'lBfrtip',
            "ajax": {
                "url": " " + base_url + "Programas/listarCursos",
                "dataSrc": ""
            },
            "columns": [
                { "data": "id" },
                { "data": "curso" },
                { "data": "estado", className: 'centered' },
                { "data": "acciones", className: 'centered' },

            ],
            buttons: [{
                    "extend": "copyHtml5",
                    "text": "<i class='far fa-copy'></i> Copiar",
                    "titleAttr": "Copiar",
                    "className": "btn btn-secondary",
                    "exportOptions": {
                        "columns": [0, 1]
                    }
                }, {
                    "extend": "excelHtml5",
                    "text": "<i class='fas fa-file-excel'></i> Excel",
                    "titleAttr": "Expotar a Excel",
                    "className": "btn btn-success",
                    "exportOptions": {
                        "columns": [0, 1]
                    }
                }, {
                    "extend": "pdfHtml5",
                    "text": "<i class='fas fa-file-pdf'></i> PDF",
                    "titleAttr": "Exportar a PDF",
                    "className": "btn btn-danger",
                    "exportOptions": {
                        "columns": [0, 1]
                    }
                }, {
                    "extend": "csvHtml5",
                    "text": "<i class='faa fa-file-csv'></i> CSV",
                    "titleAttr": "Eportar",
                    "className": "btn btn-secondary",
                    "exportOptions": {
                        "columns": [0, 1]
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
        });
    })
    //insertar cursos
document.addEventListener("DOMContentLoaded", function() {

        if (document.querySelector("#frmcurso")) {
            let frmcurso = document.querySelector("#frmcurso");
            frmcurso.onsubmit = function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                let base_url = 'http://localhost/Asistencia_estudiantil/';
                const curso = document.querySelector('#curso').value;
                if (curso == "") {

                    Swal.fire({
                        position: 'top-end',
                        icon: 'info',
                        title: 'El campo es obligatorio',
                        showConfirmButton: false,
                        timer: 2200
                    })
                } else {
                    $.ajax({
                        type: 'post',
                        url: base_url + 'Programas/registrarCursos',
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
                                $('#modalCurso').modal('hide');
                                setTimeout(function() {
                                    dataTableC.ajax.reload();
                                }, 2000);

                            } else {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: response.post,
                                    showConfirmButton: false,
                                    timer: 2200
                                })
                            }
                        }

                    });
                }
            };
        }

    })
    //editar asignacion
function editarCurso(id) {
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnCurso').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    document.querySelector('#titleModal').innerHTML = "Actualizar curso o asignatura";
    document.querySelector('#frmcurso').reset();
    let base_url = 'http://localhost/Asistencia_estudiantil/';

    $.ajax({
        url: base_url + 'Programas/editarCurso/' + id,
        type: "GET",
        dataType: "json",
        data: {
            id: id
        },
        success: function(resp) {
            $('#idCurso').val(resp[0].id);
            $('#curso').val(resp[0].curso);

            $('#modalCurso').modal('show');
        }
    });
}
//eliminar asignacion
function eliminarCurso(id) {
    let base_url = 'http://localhost/Asistencia_estudiantil/';
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: '¿Realmente quiere eliminar el curso?',
        text: "El curso se eliminará de forma permanente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Eliminar!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Programas/deleteCurso/" + id;
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
                            dataTableC.ajax.reload();
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
                'El curso no fue eliminado',
                'error'
            )
        }
    })
}
//filtro de los programas
function filtrarPrograma() {
    const input = document.getElementById("buscador");
    const filter = input.value.toUpperCase();
    const select = document.getElementById("id_materia");
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

function filtrarProgram() {
    const input = document.getElementById("buscador4");
    const filter = input.value.toUpperCase();
    const select = document.getElementById("id_materia");
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
//filtro de los docentes
function filtrarDocente() {
    const input = document.getElementById("buscador2");
    const filter = input.value.toUpperCase();
    const select = document.getElementById("id_docentes");
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
//filtro de los cursos
function filtrarCurso() {
    const input = document.getElementById("buscador3");
    const filter = input.value.toUpperCase();
    const select = document.getElementById("idCurso");
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
//filtro de los cursos
function filtrarCursos() {
    const input = document.getElementById("buscador4");
    const filter = input.value.toUpperCase();
    const select = document.getElementById("idCurso");
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

document.addEventListener("DOMContentLoaded", function() {
    $('.loading-overlay').hide();
});

function deshabilitarAsistencia() {
    let base_url = 'http://localhost/Asistencia_estudiantil/';

    // Función para mostrar el indicador de carga
    function showLoading() {
        $('.loading-overlay').fadeIn();
    }

    // Función para ocultar el indicador de carga
    function hideLoading() {
        $('.loading-overlay').fadeOut();
    }
    showLoading();
    $.ajax({
        type: 'post',
        url: base_url + 'asistencias/habilitar/' + 2,
        data: { id: 2 }, // Enviar el ID del estudiante en el objeto de datos
        dataType: 'json',
        success: function(response) {
            if (response.ok == true) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: response.post,
                    showConfirmButton: false,
                    timer: 2200
                });
                hideLoading();
                setTimeout(function() {
                    location.reload();
                }, 2000);
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: response.post,
                    showConfirmButton: false,
                    timer: 2200
                });

            }
        },
        error: function() {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Error al procesar los datos',
                showConfirmButton: false,
                timer: 2200
            });
            hideLoading();
        }
    });
}
document.addEventListener("DOMContentLoaded", function() {
        if (document.querySelector("#frmHabilitar")) {
            let frmHabilitar = document.querySelector("#frmHabilitar");
            frmHabilitar.onsubmit = function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                function showLoading() {
                    $('.loading-overlay').fadeIn();
                }

                // Función para ocultar el indicador de carga
                function hideLoading() {
                    $('.loading-overlay').fadeOut();
                }
                let base_url = 'http://localhost/Asistencia_estudiantil/';

                const id_materia = document.querySelector('#id_materia').value;
                const idCurso = document.querySelector('#idCurso').value;
                const semestre = document.querySelector('#semestre').value;

                if (id_materia == "Seleccionar.." || idCurso == "Seleccionar.." || semestre == "Seleccionar..") {

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
                        url: base_url + 'asistencias/habilitar',
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
                                });
                                hideLoading();
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {

                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: response.post,
                                    showConfirmButton: false,
                                    timer: 2200
                                })
                            }
                        }

                    });
                }
                // };
            }
        }

    }) // Espera 30 segundos y luego elimina la cookie.

//asistencias alumbos por cursos
document.addEventListener("DOMContentLoaded", function() {

        let base_url = 'http://localhost/Asistencia_estudiantil/';
        dataTableAsignar = $('#tableAsistencias').DataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
            dom: 'lBfrtip',
            "ajax": {
                "url": " " + base_url + "Asistencias/listar",
                "dataSrc": ""
            },
            "columns": [
                { "data": "id" },
                { "data": "nombre" },
                { "data": "apellidos" },
                { "data": "cedula" },
                { "data": "materia" },
                { "data": "curso" },
                { "data": "semestre" },
                { "data": "fecha" },
                { "data": "estado", className: 'centered' },

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
        });
    })
    //asistencias marcadas
document.addEventListener("DOMContentLoaded", function() {

        let base_url = 'http://localhost/Asistencia_estudiantil/';
        dataTableAsignar = $('#tableAsistenciasM').DataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" },
            dom: 'lBfrtip',
            "ajax": {
                "url": " " + base_url + "Asistencias/listarA",
                "dataSrc": ""
            },
            "columns": [
                { "data": "id" },
                { "data": "nombre" },
                { "data": "apellidos" },
                { "data": "cedula" },
                { "data": "materia" },
                { "data": "curso" },
                { "data": "semestre" },
                { "data": "fecha" },
                { "data": "estado", className: 'centered' },

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
        });
    })
    //insertar nota

document.addEventListener("DOMContentLoaded", function() {
        $('.notas-lista li').on('click', function() {
            var contenido = $(this).find('.contenido-nota');
            contenido.toggleClass('visible');
            contenido.css('height', contenido.hasClass('visible') ? contenido[0].scrollHeight + 'px' : '0');
        });
        if (document.querySelector("#nuevaNotaForm")) {
            let nuevaNotaForm = document.querySelector("#nuevaNotaForm");
            nuevaNotaForm.onsubmit = function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                let base_url = 'http://localhost/Asistencia_estudiantil/';
                const titulo = document.querySelector('#titulo').value;
                const contenido = document.querySelector('#titulo').value;
                const color = document.querySelector('#color').value;
                const tipo_nota = document.querySelector('#tipo_nota').value;

                if (titulo == "" || contenido == "" || tipo_nota == "" || color == "") {

                    Swal.fire({
                        position: 'top-end',
                        icon: 'info',
                        title: 'Todos los campos son obligatorios',
                        showConfirmButton: false,
                        timer: 2200
                    })
                } else {
                    $.ajax({
                        type: 'post',
                        url: base_url + 'Dashboard/guardar_nota',
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
                                $('#id_materias').modal('hide');
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);

                            } else {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: response.post,
                                    showConfirmButton: false,
                                    timer: 2200
                                })
                            }
                        }

                    });
                }
            };
        }

    })
    //notas publicas
document.addEventListener("DOMContentLoaded", function() {

    $('#idCursos').change(function() {
        const idCurso = $(this).val();
        $('#notasContainer').empty();

        let base_url = 'http://localhost/Asistencia_estudiantil/';
        $.ajax({
            type: 'GET',
            url: base_url + 'Dashboard/obtenerNotas/' + idCurso,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.length > 0) {
                    for (let index = 0; index < response.length; index++) {
                        const element = response[index];
                        const color = element.color;
                        var notaHTML = '<div class="nota" style="background-color:' + color + ';">';
                        notaHTML += '<h3 class="titulo-nota small">' + element.titulo + '</h3>';
                        notaHTML += '<p class="acciones-nota"><button class="btn-eliminar btn-sm float-right" data-id=' + element.id + '">Eliminar</button></p>';
                        notaHTML += '<p class="contenido">' + element.contenido + '</p>';
                        notaHTML += '</div>';
                        $('#notasContainer').append(notaHTML);

                    }
                    $('.titulo-nota').click(function() {
                        $(this).siblings('.contenido').toggle();
                    })

                    $('.btn-eliminar').click(function() {
                        const idCurso = $(this).data('id');
                        let base_url = 'http://localhost/Asistencia_estudiantil/';
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-success',
                                cancelButton: 'btn btn-danger'
                            },
                            buttonsStyling: false
                        })
                        swalWithBootstrapButtons.fire({
                            title: '¿Realmente quiere eliminar la nota?',
                            text: "La nota se eliminará de forma permanente",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Si, Eliminar!',
                            cancelButtonText: 'No, cancel!',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const url = base_url + "dashboard/eliminar_nota/" + idCurso;
                                const http = new XMLHttpRequest();
                                http.open("GET", url, true);
                                http.send();
                                http.onreadystatechange = function() {

                                    if (this.readyState == 4 && this.status == 200) {
                                        const resp = JSON.parse(this.responseText);

                                        if (resp.ok == true) {
                                            $(this).parent('.nota').remove();
                                            swalWithBootstrapButtons.fire(
                                                'Eliminado!',
                                                resp.post,
                                                'success',

                                            );
                                            setTimeout(function() {
                                                location.reload();
                                            }, 2000);
                                        } else {
                                            swalWithBootstrapButtons.fire(
                                                'Cancelado!',
                                                resp.post,
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
                                    'La nota no fue eliminado',
                                    'error'
                                )
                            }
                        })
                    })
                } else {
                    $('#notasContainer').append('<p style="text-align:center;">No hay notas disponibles para este curso.</p>');

                }
            }

        });
    })


})

document.addEventListener("DOMContentLoaded", function() {

    $('#idDocente').change(function() {
        const idCurso = $(this).val();
        $('#notasContainerr').empty();

        let base_url = 'http://localhost/Asistencia_estudiantil/';
        $.ajax({
            type: 'GET',
            url: base_url + 'Dashboard/obtenerNotas/' + idCurso,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.length > 0) {
                    for (let index = 0; index < response.length; index++) {
                        const element = response[index];
                        const color = element.color;
                        var notaHTML = '<div class="nota" style="background-color:' + color + ';">';
                        notaHTML += '<h3 class="titulo-nota small">' + element.titulo + '</h3>';
                        notaHTML += '<p class="acciones-nota"><button class="btn-eliminar btn-sm float-right" data-id=' + element.id + '">Eliminar</button></p>';
                        notaHTML += '<p class="contenido">' + element.contenido + '</p>';
                        notaHTML += '</div>';
                        $('#notasContainerr').append(notaHTML);

                    }
                    $('.titulo-nota').click(function() {
                        $(this).siblings('.contenido').toggle();
                    })

                    $('.btn-eliminar').click(function() {
                        const idCurso = $(this).data('id');
                        let base_url = 'http://localhost/Asistencia_estudiantil/';
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-success',
                                cancelButton: 'btn btn-danger'
                            },
                            buttonsStyling: false
                        })
                        swalWithBootstrapButtons.fire({
                            title: '¿Realmente quiere eliminar la nota?',
                            text: "La nota se eliminará de forma permanente",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Si, Eliminar!',
                            cancelButtonText: 'No, cancel!',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const url = base_url + "dashboard/eliminar_nota/" + idCurso;
                                const http = new XMLHttpRequest();
                                http.open("GET", url, true);
                                http.send();
                                http.onreadystatechange = function() {

                                    if (this.readyState == 4 && this.status == 200) {
                                        const resp = JSON.parse(this.responseText);

                                        if (resp.ok == true) {
                                            $(this).parent('.nota').remove();
                                            swalWithBootstrapButtons.fire(
                                                'Eliminado!',
                                                resp.post,
                                                'success',
                                            );
                                            setTimeout(function() {
                                                location.reload();
                                            }, 2000);
                                        } else {
                                            swalWithBootstrapButtons.fire(
                                                'Cancelado!',
                                                resp.post,
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
                                    'La nota no fue eliminado',
                                    'error'
                                )
                            }
                        })
                    })
                } else {
                    $('#notasContainerr').append('<p style="text-align:center;">No hay notas disponibles para este curso.</p>');

                }
            }

        });
    })


})

document.addEventListener("DOMContentLoaded", function() {

    $('#idJefe').change(function() {
        const idCurso = $(this).val();
        $('#notasContainerJ').empty();

        let base_url = 'http://localhost/Asistencia_estudiantil/';
        $.ajax({
            type: 'GET',
            url: base_url + 'Dashboard/obtenerNotas/' + idCurso,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.length > 0) {
                    for (let index = 0; index < response.length; index++) {
                        const element = response[index];
                        const color = element.color;
                        var notaHTML = '<div class="nota" style="background-color:' + color + ';">';
                        notaHTML += '<h3 class="titulo-nota small">' + element.titulo + '</h3>';
                        notaHTML += '<p class="acciones-nota"><button class="btn-eliminar btn-sm float-right" data-id=' + element.id + '">Eliminar</button></p>';
                        notaHTML += '<p class="contenido">' + element.contenido + '</p>';
                        notaHTML += '</div>';
                        $('#notasContainerJ').append(notaHTML);

                    }
                    $('.titulo-nota').click(function() {
                        $(this).siblings('.contenido').toggle();
                    })

                    $('.btn-eliminar').click(function() {
                        const idCurso = $(this).data('id');
                        let base_url = 'http://localhost/Asistencia_estudiantil/';
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-success',
                                cancelButton: 'btn btn-danger'
                            },
                            buttonsStyling: false
                        })
                        swalWithBootstrapButtons.fire({
                            title: '¿Realmente quiere eliminar la nota?',
                            text: "La nota se eliminará de forma permanente",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Si, Eliminar!',
                            cancelButtonText: 'No, cancel!',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const url = base_url + "dashboard/eliminar_nota/" + idCurso;
                                const http = new XMLHttpRequest();
                                http.open("GET", url, true);
                                http.send();
                                http.onreadystatechange = function() {

                                    if (this.readyState == 4 && this.status == 200) {
                                        const resp = JSON.parse(this.responseText);

                                        if (resp.ok == true) {
                                            $(this).parent('.nota').remove();
                                            swalWithBootstrapButtons.fire(
                                                'Eliminado!',
                                                resp.post,
                                                'success',
                                            );
                                            setTimeout(function() {
                                                location.reload();
                                            }, 2000);
                                        } else {
                                            swalWithBootstrapButtons.fire(
                                                'Cancelado!',
                                                resp.post,
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
                                    'La nota no fue eliminado',
                                    'error'
                                )
                            }
                        })
                    })
                } else {
                    $('#notasContainerJ').append('<p style="text-align:center;">No hay notas disponibles para este curso.</p>');

                }
            }

        });
    })


})

document.addEventListener("DOMContentLoaded", function() {

        $('#idAdmin').change(function() {
            const idCurso = $(this).val();
            $('#notasContainerA').empty();

            let base_url = 'http://localhost/Asistencia_estudiantil/';
            $.ajax({
                type: 'GET',
                url: base_url + 'Dashboard/obtenerNotas/' + idCurso,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.length > 0) {
                        for (let index = 0; index < response.length; index++) {
                            const element = response[index];
                            const color = element.color;
                            var notaHTML = '<div class="nota" style="background-color:' + color + ';">';
                            notaHTML += '<h3 class="titulo-nota small">' + element.titulo + '</h3>';
                            notaHTML += '<p class="acciones-nota"><button class="btn-eliminar btn-sm float-right" data-id=' + element.id + '">Eliminar</button></p>';
                            notaHTML += '<p class="contenido">' + element.contenido + '</p>';
                            notaHTML += '</div>';
                            $('#notasContainerA').append(notaHTML);

                        }
                        $('.titulo-nota').click(function() {
                            $(this).siblings('.contenido').toggle();
                        })

                        $('.btn-eliminar').click(function() {
                            const idCurso = $(this).data('id');
                            let base_url = 'http://localhost/Asistencia_estudiantil/';
                            const swalWithBootstrapButtons = Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-success',
                                    cancelButton: 'btn btn-danger'
                                },
                                buttonsStyling: false
                            })
                            swalWithBootstrapButtons.fire({
                                title: '¿Realmente quiere eliminar la nota?',
                                text: "La nota se eliminará de forma permanente",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Si, Eliminar!',
                                cancelButtonText: 'No, cancel!',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    const url = base_url + "dashboard/eliminar_nota/" + idCurso;
                                    const http = new XMLHttpRequest();
                                    http.open("GET", url, true);
                                    http.send();
                                    http.onreadystatechange = function() {

                                        if (this.readyState == 4 && this.status == 200) {
                                            const resp = JSON.parse(this.responseText);

                                            if (resp.ok == true) {
                                                $(this).parent('.nota').remove();
                                                swalWithBootstrapButtons.fire(
                                                    'Eliminado!',
                                                    resp.post,
                                                    'success',
                                                );
                                                setTimeout(function() {
                                                    location.reload();
                                                }, 2000);
                                            } else {
                                                swalWithBootstrapButtons.fire(
                                                    'Cancelado!',
                                                    resp.post,
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
                                        'La nota no fue eliminado',
                                        'error'
                                    )
                                }
                            })
                        })
                    } else {
                        $('#notasContainerA').append('<p style="text-align:center;">No hay notas disponibles para este curso.</p>');

                    }
                }

            });
        })


    })
    //eliminar nota

$(document).ready(function() {
    $(".btnEliminarNota").click(function() {
        var notaItem = $(this).closest(".nota-item");
        var notaId = notaItem.data("id");
        let base_url = 'http://localhost/Asistencia_estudiantil/';
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: '¿Realmente quiere eliminar la nota?',
            text: "La nota se eliminará de forma permanente",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, Eliminar!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const url = base_url + "dashboard/eliminar_nota/" + notaId;
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
                                location.reload();
                            }, 2000);
                        } else {
                            swalWithBootstrapButtons.fire(
                                'Cancelado!',
                                resp.post,
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
                    'La nota no fue eliminado',
                    'error'
                )
            }
        })

    });
});
//calendario
document.addEventListener("DOMContentLoaded", function() {
    const prevMonthBtn = document.getElementById("prevMonth");
    const nextMonthBtn = document.getElementById("nextMonth");
    const currentMonthYear = document.getElementById("currentMonthYear");
    const calendarBody = document.getElementById("calendarBody");
    const weekdays = ["D", "L", "M", "M", "J", "V", "S"];

    const currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();

    function generateCalendar(year, month) {
        calendarBody.innerHTML = "";

        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();
        // const holidays = ["1/1", "5/1", "7/20", "8/7", "12/8", "12/25"];
        const festivos = ["1/1", "1/9", "3/20", "4/6", "4/7", "5/1", "5/22",
            "6/12", "6/19", "7/3", "7/20", "8/7", "8/21", "10/16",
            "11/6", "11/13", "12/8", "12/25"
        ]; // Agrega más festivos si es necesario

        let date = 1;
        // Agregar fila de nombres de días
        const dayNamesRow = document.createElement("tr");
        weekdays.forEach(weekday => {
            const th = document.createElement("th");
            th.textContent = weekday;
            dayNamesRow.appendChild(th);
        });
        calendarBody.appendChild(dayNamesRow);
        for (let row = 0; row < 6; row++) {
            const tr = document.createElement("tr");
            for (let col = 0; col < 7; col++) {
                const td = document.createElement("td");
                if (row === 0 && col < firstDay) {
                    td.textContent = "";
                } else if (date > lastDate) {
                    break;
                } else {
                    td.textContent = date;
                    if (date === currentDate.getDate() && year === currentDate.getFullYear() && month === currentDate.getMonth()) {
                        td.classList.add("current-date");
                    }
                    const formattedDate = (month + 1) + "/" + date;
                    if (festivos.includes(formattedDate)) {
                        td.classList.add("festivo"); // Agrega la clase festivo a los festivos
                    }
                    // const formattedDate = (month + 1) + "/" + date;
                    // if (holidays.includes(formattedDate)) {
                    //     td.classList.add("holiday");
                    // }
                    date++;
                }
                tr.appendChild(td);
            }
            calendarBody.appendChild(tr);
        }

        currentMonthYear.textContent = new Date(year, month).toLocaleDateString('es-ES', { year: 'numeric', month: 'long' });
    }

    generateCalendar(currentYear, currentMonth);

    prevMonthBtn.addEventListener("click", function() {
        if (currentMonth === 0) {
            currentMonth = 11;
            currentYear--;
        } else {
            currentMonth--;
        }
        generateCalendar(currentYear, currentMonth);
    });

    nextMonthBtn.addEventListener("click", function() {
        if (currentMonth === 11) {
            currentMonth = 0;
            currentYear++;
        } else {
            currentMonth++;
        }
        generateCalendar(currentYear, currentMonth);
    });
});