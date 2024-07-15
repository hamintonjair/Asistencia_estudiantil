<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div>
                    <h1>Lista de cursos </h1>
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary" onclick="openModalAsistenciasA();"
                        data-toggle="modal">Mis asistencias</button>
                   
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
                        <h3 class="card-title">Estos son los cursos a los cuales te encuentras matriculado. (<font color="red">
                            Si no aparece alguno de los cursos matrículados, comunícate con el docente. 
                        </font>) </h3>
                    </div>
                    <?php $Cursos; ?>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class='table-responsive'>
                            <table class="table table-light table-hover table-bordered">
                                <tr class="thead-dark">
                                    <th>Nombre del Curso</th>
                                    <th class="centered">Acción</th>
                                </tr>
                                <?php foreach ($Cursos as $curs): ?>
                                <tr>
                                    <td><?php echo $curs->curso; ?></td>
                                    <td style=" text-align: center;"><a class="btn btn-primary"
                                    href="<?php echo base_url().'asistencias/asistenciasHabilitada/'.$curs->id ?>">Ir a asistencias</a></td>
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

<script>

    function vista(id) {
   
    let base_url = 'http://localhost/Asistencia_estudiantil/';

    $.ajax({
        url: base_url + 'asistencias/marcar/' + id,
        type: "GET",
        dataType: "json",
        data: {
            id: id
        },
    });
}
</script>