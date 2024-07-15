<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div>
                    <h1>Asignación de programas</h1>
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary" onclick="openModalVolverD();"
                        data-toggle="modal">Volver</button>
                    <button type="button" class="btn btn-warning" onclick="openModalAsignar();"
                        data-toggle="modal">Asignar</button>
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
                        <h3 class="card-title">Asignación de los programas a los docentes correspondientes. </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class='table-responsive'>
                            <table id="tableAsignar" class="table table-light table-hover table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Docentes</th>
                                        <th>Programas</th>
                                        <th>Cursos</th>
                                        <th>Semestre</th>
                                        <th class="centered">Estado</th>
                                        <th class="centered">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
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
    <!-- /.content -->

    <!-- Modal -->
    <!-- Modal -->
    <div class='modal fade' id='modalAsignar' tabindex='-1' role='dialog' aria-labelledby='modelTitleId'
        aria-hidden='true'>
        <div class='modal-dialog ' role='document'>
            <div class='modal-content'>
                <div class='modal-header headerRegister'>
                    <h5 class='modal-title' id='titleModal'> </h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <form method='post' id='frmAsignar' autocomplete="off">
                        <span for="text">Los campos con (*) son obligatorios.</span>

                        <input type='hidden' id='idAsignar' name='idAsignar' value=''>
                        <div class="row">
                        <div class='col-md-12'>
                                <div class='form-group'>
                                    <label for='semestre'>Semestre(<font color="red">*</font>)</label>
                                    <select class='form-control' name='semestre' id='semestre'>
                                        <option selected="selected">Seleccionar..</option>
                                        <option value="1">Primer</option>
                                        <option value="2">Segundo</option>
                                        <option value="3">Tercer</option>
                                        <option value="4">Cuarto</option>
                                        <option value="5">Quinto</option>
                                        <option value="6">Sexto</option>
                                        <option value="7">Septimo</option>
                                        <option value="8">Octavo</option>
                                        <option value="9">Noveno</option>
                                        <option value="10">Décimo</option>
                                    </select>
                                </div>
                            </div>                            
                            <div class='col-md-12'>
                                <div class='form-group'>
                                    <label for='programa'>Programas(<font color="red">*</font>)</label>
                                    <input type="text" id="buscador" class="form-control"
                                        placeholder="Buscar programa..." oninput="filtrarPrograma()">
                                    <select class="form-control" id="id_materia" name="id_materia" >
                                        <option selected="selected">Seleccionar..</option>
                                        <?php foreach ($program as $row){ ?>
                                        <option value="<?php echo $row->id; ?>"><?php echo $row->materia; ?>
                                        </option>
                                        <?php }; ?>
                                    </select>

                                </div>
                            </div>
                            <div class='col-md-12'>
                                <div class='form-group'>
                                    <label for='medida'>Docentes(<font color="red">*</font>)</label>
                                    <input type="text" id="buscador2" class="form-control"
                                        placeholder="Buscar docente..." oninput="filtrarDocente()">
                                    <select class="form-control" id="id_docentes" name="id_docentes">
                                        <option selected="selected">Seleccionar..</option>
                                        <?php foreach ($docent as $row){ ?>
                                        <option value="<?php echo $row->id; ?>"><?php echo $row->nombre; ?>
                                            <?php echo $row->apellidos; ?>
                                        </option>
                                        <?php }; ?>
                                    </select>
                                </div>
                            </div>
                            <div class='col-md-12'>
                                <div class='form-group'>
                                    <label for='medida'>Cursos/Asignaturas(<font color="red">*</font>)</label>
                                    <input type="text" id="buscador3" class="form-control"
                                        placeholder="Buscar curso..." oninput="filtrarCurso()">
                                    <select class="form-control" id="idCurso" name="idCurso">
                                        <option selected="selected">Seleccionar..</option>
                                        <?php foreach ($curso as $row){ ?>
                                        <option value="<?php echo $row->id; ?>"><?php echo $row->curso; ?>
                                        </option>
                                        <?php }; ?>
                                    </select>

                                </div>
                            </div>
                
                        </div>
                        <div class='modal-footer'>
                            <button id='btnAsignar' type='submit' class='btn btn-primary'><span id='btnText'>
                                </span></button>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>