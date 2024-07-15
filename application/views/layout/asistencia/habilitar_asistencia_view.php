<!-- Vista para habilitar la asistencia -->

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div>
                    <h1>Asistencias</h1>
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary" onclick="openModalAsistencias();"
                        data-toggle="modal">Ir asistencias</button>

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Habilitar la vista asistencias para los estudiantes. (<font color="red">
                            "Recuerda que solo se habilita una vez por curso."</font>)</h3>
                </div>
                <?php 
                   if(isset($_COOKIE['asistencia_info'])) {
                    $cookie_data = json_decode($_COOKIE['asistencia_info'], true);
                    }                
                 ?>
                <!-- /.card-header -->
                <div class="card-body">
                    <form id="frmHabilitar">
                        <div id="loading" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i> Cargando...
                        </div>

                        <div class='table-responsive'>
                            <table id="tableHabilitar" class="table table-light table-hover table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Programa</th>
                                        <th>Curso</th>
                                        <th>Semestre</th>
                                        <th>Estado Asistencia</th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td>
                                        <input type="text" id="buscador4" class="form-control"
                                            placeholder="Buscar programa..." oninput="filtrarProgram()">
                                        <select class="form-control" id="id_materia" name="id_materia">
                                            <option selected="selected">Seleccionar..</option>
                                            <?php foreach ($program as $row){ ?>
                                            <option value="<?php echo $row->idMateria; ?>"><?php echo $row->materia; ?>
                                            </option>
                                            <?php }; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" id="buscador3" class="form-control"
                                            placeholder="Buscar curso..." oninput="filtrarCurso()">
                                        <select class="form-control" id="idCurso" name="idCurso">
                                            <option selected="selected">Seleccionar..</option>
                                            <?php foreach ($curs as $row){ ?>
                                            <option value="<?php echo $row->idCurso; ?>"><?php echo $row->curso; ?>
                                            </option>
                                            <?php }; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" id="semestre" name="semestre">
                                            <option selected="selected">Seleccionar..</option>
                                            <?php foreach ($semestre as $row){ ?>
                                            <option value="<?php echo $row->semestre; ?>"><?php echo $row->semestre; ?>
                                            </option>
                                            <?php }; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <?php                                     
                                         if (isset($cookie_data['asistencia_habilitada']) && $cookie_data['asistencia_habilitada'] === true):
                                          ?>
                                        <button type="button" onclick="deshabilitarAsistencia();"
                                            class="btn btn-danger">Deshabilitar Asistencia</button>
                                        <?php else: ?>
                                        <button type="submit" id="btnhabilitar" class="btn btn-success">Habilitar
                                            Asistencia</button>
                                        <?php endif; ?>
                                        
                                    </td>

                                </tr>
                            </table>
                        </div>
                    </form>
                </div>

                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
</div>
<div id="loading" class="loading-overlay">
    <div class="loading-spinner"></div>
</div>

<style>
.center {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 22vh;
    /* Opcional: para centrar verticalmente en toda la pantalla */
}
</style>