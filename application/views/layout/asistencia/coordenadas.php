<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Guardar Coordenadas</h4>

        </div>
        <img class="card-img-top" alt="">
        <div class="card-body">
        <span>Para tener presente, las coordenadas se refiere a la latitud y longitud del plantel educativo, para ser más claro es la ubicación y de está dependen los estudiantes a la hora de MARCAR LA ASISTENCIA, la cual es habilitada por el DOCENTE, (<font color="red">Si no sabes como obtener estas coordenadas, puedes dar clic al siguiente enlace y obtenerla</font>) <a href="https://my-current-location.com/es" target="_blank"><button class="btn btn-warning">Ir</button></a></span>
            <form id="frmCoordenada" method="post">
              
                <fieldset>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellidos">Latitud</label>
                                <input type="text" name="latitud" id="latitud" class="form-control"
                                    placeholder="Latitud" aria-describedby="helpId" value="<?php echo $coordenadas[0]->latitud?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="telefono">Longitud</label>
                                <input type="text" name="longitud" id="longitud" class="form-control"
                                    placeholder="Longitud" aria-describedby="helpId" value="<?php echo $coordenadas[0]->longitud?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php if($_SESSION['rol'] == "Admin"){ ?>
                        <button type="submit" id="btnGuardarCoordenadas">Actualizar</button>

                        <?php }; ?>
                    </div>
                </fieldset>
            </form>

        </div>
    </div>



</div>
<style>
/* Estilos para dispositivos móviles */
@media (max-width: 767px) {
    .table tbody tr {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .table tbody td,
    .table tbody th {
        width: 49%;
        /* Ajusta el ancho de las celdas para ocupar la mitad del espacio disponible */
        margin-bottom: 5px;
        /* Espaciado entre celdas */
    }
}
</style>

<script>
// Espera a que el documento esté completamente cargado antes de agregar el evento clic.
document.addEventListener("DOMContentLoaded", function() {

    if (document.querySelector("#frmCoordenada")) {
            let frmCoordenada = document.querySelector("#frmCoordenada");
            frmCoordenada.onsubmit = function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                let base_url = 'http://localhost/Asistencia_estudiantil/';
                const latitud = document.querySelector('#latitud').value;
                const longitud = document.querySelector('#longitud').value;

                if (latitud == "" || longitud == "") {

                    Swal.fire({
                        position: 'top-end',
                        icon: 'info',
                        title: 'Los campo es obligatorio',
                        showConfirmButton: false,
                        timer: 2200
                    })
                } else {
                    $.ajax({
                        type: 'post',
                        url: base_url + 'Dashboard/insertCoordenadas',
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

});
</script>