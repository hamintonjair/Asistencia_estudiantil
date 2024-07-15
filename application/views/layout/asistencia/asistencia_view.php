<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div>
                    <h1>Estudiantes del curso</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ten presente que solo puedes marcar tú asistencia. (<font color="red">"El
                                sistema no te permitirá marcar asistencia de otro estudiante."</font>) </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class='table-responsive'>
                            <table class="table table-light table-hover table-bordered">
                                <tr class="thead-dark">
                                    <th>Nombre del Estudiante</th>
                                    <th class="centered">Marcar Asistencia</th>
                                </tr>
                                <?php foreach ($estudiantes as $estudent): ?>
                                <tr>
                                    <input type="hidden" id="id" value="<?php echo $estudent->id ?>">
                                    <input type="hidden" id="idDocente" value="<?php echo $estudent->idDocente ?>">
                                    <input type="hidden" id="idMateria" value="<?php echo $estudent->idMateria ?>">
                                    <input type="hidden" id="idCurso" value="<?php echo $estudent->idCurso ?>">
                                    <input type="hidden" id="semestre" value="<?php echo $estudent->semestre ?>">

                                    <td><?php echo $estudent->nombre; ?>
                                        <?php echo $estudent->apellidos; ?></td>
                                    <td style=" text-align: center;"><button class="marcarAsistencia btb btn-success"
                                            data-id="<?php echo $estudent->cedula; ?>">Marcar</button></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>


</div>
<div id="loading" class="loading-overlay">
    <div class="loading-spinner"></div>
</div>

<script>
// JavaScript para obtener la ubicación y enviarla al controlador al marcar la asistencia
document.querySelectorAll('.marcarAsistencia').forEach(button => {
    button.addEventListener('click', () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const cedula = button.getAttribute('data-id');
                const id = document.querySelector("#id").value;
                const idDocente = document.querySelector("#idDocente").value;
                const idMateria = document.querySelector("#idMateria").value;
                const idCurso = document.querySelector("#idCurso").value;
                const semestre = document.querySelector("#semestre").value;
                let base_url = 'http://localhost/Asistencia_estudiantil/marcar/asistencia';

                function showLoading() {
                    $('.loading-overlay').fadeIn();
                }

                // Función para ocultar el indicador de carga
                function hideLoading() {
                    $('.loading-overlay').fadeOut();
                }
                showLoading();

                // Enviar los datos al controlador mediante AJAX
                const xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {

                       const $resp = JSON.parse(this.responseText);
                        if ($resp.ok == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: $resp.post,
                                showConfirmButton: false,
                                timer: 2200
                            })
                            setTimeout(function() {
                                hideLoading();
                            }, 2000);
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: $resp.post,
                                showConfirmButton: false,
                                timer: 2200
                            })
                            setTimeout(function() {
                                hideLoading();
                            }, 2000);
                        }
                    }
                };
                xhttp.open('POST', base_url, true);
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.send('lat=' + lat + '&lng=' + lng +'&idDocente=' + idDocente + '&idMateria=' + idMateria +
                    '&idCurso=' + idCurso + '&semestre=' + semestre + '&cedula=' + cedula  + '&id=' + id);
            });
        } else {
            Swal.fire({
                position: 'top-end',
                icon: 'info',
                title: 'La geolocalización no es compatible con este navegador.',
                showConfirmButton: false,
                timer: 2200
            })
        }
    });
});
</script>