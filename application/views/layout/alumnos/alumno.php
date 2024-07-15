<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div>
                    <h1>Estudiantes</h1>
                </div>
                <?php if($_SESSION['rol'] == 'Docente'){ ?>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary" onclick="openModalAlumnos();"
                        data-toggle="modal">Nuevo</button>
                </div>
                <?php }; ?>


            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <?php if($_SESSION['rol'] == 'Jefe'){ ?>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="cedula">Buscar docente por cédula</label>
                            <input type="text" id="buscador" class="form-control" placeholder="Buscar cedula..."
                                oninput="filtrarCedulaD()">
                            <select id="cedulaD" name="cedulaD" class="form-control" onchange="buscarCedulaD()">
                                <option value="">Seleccionar..</option>
                                <?php foreach ($cedulaD as $row) { ?>
                                <option value="<?php echo $row->id; ?>">
                                    <?php echo $row->cedula; ?><?php echo ' - ' ?><?php echo $row->nombre; ?>
                                    <?php echo $row->apellidos; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php }; ?>
                    <div class="card-header">
                        <h3 class="card-title">Administración de los estudiantes que se encuentran matrículados en el
                            plantel educativo. </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class='table-responsive'>
                            <table id="tableAlumnos" class="table table-light table-hover table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Apellidos</th>
                                        <th>Cédula</th>
                                        <th>Teéfono</th>
                                        <th>Dirección</th>
                                        <th>Correo</th>
                                        <th class="centered">Estado</th>
                                        <th class="centered">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tableAlumnosD">

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
    <div class='modal fade' id='modalAlumno' tabindex='-1' role='dialog' aria-labelledby='modelTitleId'
        aria-hidden='true'>
        <div class='modal-dialog modal-lg' role='document'>
            <div class='modal-content'>
                <div class='modal-header headerRegister'>
                    <h5 class='modal-title' id='titleModal'> </h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <form method='post' id='frmalumno' autocomplete="off">
                        <span for="text">Los campos con (*) son obligatorios.</span>
                        <input type='hidden' id='idAlumno' name='idAlumno'>
                        <div class='row'>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cedula">Buscar por Cédula</label>
                                    <input type="text" id="buscador" class="form-control" placeholder="Buscar cedula..."
                                        oninput="filtrarCedula()">
                                    <select id="cedulaA" name="cedulaA" class="form-control" onchange="buscarCedula()">
                                        <option value="">Seleccionar..</option>
                                        <?php foreach ($cedula as $row) { ?>
                                        <option value="<?php echo $row->cedula; ?>">
                                            <?php echo $row->cedula; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <label for="inputName">Nombres(<font color="red">*</font>)</label>
                                    <input type="text" class="form-control valid validText" name="nombre" id="nombre"
                                        placeholder="Nombre del estudiante">
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <label for="inputName">Apellidos(<font color="red">*</font>)</label>
                                    <input type="text" class="form-control valid validText" name="apellidos"
                                        id="apellidos" placeholder="Apelidos del estudiante">
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for="inputName">Cédula(<font color="red">*</font>)</label>
                                    <input type="number" class="form-control valid validNumber" name="cedula"
                                        id="cedula" placeholder="Cédula del estudiante">
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for="inputName">Teléfono(<font color="red">*</font>)</label>
                                    <input type="number" class="form-control valid validNumber" name="telefono"
                                        id="telefono" placeholder="Teléfono del estudiante">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class='col-md-2'>
                                <div class='form-group'>
                                    <label for="inputName">Semestres(<font color="red">*</font>)</label>
                                    <select class="form-control" id="semestre" name="semestre">
                                        <option selected="selected">Seleccionar..</option>
                                        <?php foreach ($semestre as $row){ ?>
                                        <option value="<?php echo $row->semestre; ?>"><?php echo $row->semestre; ?>
                                        </option>
                                        <?php }; ?>
                                    </select>
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <label for='materia'>Programas(<font color="red">*</font>)</label>
                                    <input type="text" id="buscador4" class="form-control"
                                        placeholder="Buscar programa..." oninput="filtrarProgram()">
                                    <select class="form-control" id="id_materia" name="id_materia">
                                        <option selected="selected">Seleccionar..</option>
                                        <?php foreach ($program as $row){ ?>
                                        <option value="<?php echo $row->idMateria; ?>"><?php echo $row->materia; ?>
                                        </option>
                                        <?php }; ?>
                                    </select>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for='curso'>Cursos(<font color="red">*</font>)</label>
                                    <input type="text" id="buscador3" class="form-control" placeholder="Buscar curso..."
                                        oninput="filtrarCurso()">
                                    <select class="form-control" id="idCurso" name="idCurso">
                                        <option selected="selected">Seleccionar..</option>
                                        <?php foreach ($curs as $row){ ?>
                                        <option value="<?php echo $row->idCurso; ?>"><?php echo $row->curso; ?>
                                        </option>
                                        <?php }; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for="inputName">Dirección(<font color="red">*</font>)</label>
                                    <input type="text" class="form-control" name="direccion" id="direccion"
                                        placeholder="Dirección del estudiante">
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for="inputName">Contraseña</label>
                                    <input type="hidden" name="password" id="password">
                                    <input type="password" class="form-control" name="clave" id="clave"
                                        placeholder="Password del estudiante">
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for="inputName">Correo(<font color="red">*</font>)</label>
                                    <input type="text" class="form-control valid validEmail" name="correo" id="correo"
                                        placeholder="Correo electrónico del estudiante">
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for="inputName">Matriculado(<font color="red">*</font>)</label>
                                    <select class='form-control' name='matriculado' id='matriculado'>
                                        <option selected="selected">Seleccionar..</option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='modal-footer'>
                            <button id='btnAlumno' type='submit' class='btn btn-primary'><span id='btnText'>
                                </span></button>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header header-primary">
                    <h5 class="modal-title" id="titleModal">Datos del Estudiante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="text-left">Identificación:</td>
                                <td class="text-left" id="celIdentificacion">654654654</td>
                            </tr>
                            <tr>
                                <td class="text-left">Nombres:</td>
                                <td class="text-left" id="celNombre">Jacob</td>
                            </tr>
                            <tr>
                                <td class="text-left">Apellidos:</td>
                                <td class="text-left" id="celApellido">Jacob</td>
                            </tr>
                            <tr>
                                <td class="text-left">Cédula:</td>
                                <td class="text-left" id="celCedula">Larry</td>
                            </tr>
                            <tr>
                                <td class="text-left">Teléfono:</td>
                                <td class="text-left" id="celTelefono">Larry</td>
                            </tr>
                            <tr>
                                <td class="text-left">Dirección:</td>
                                <td class="text-left" id="celDireccion">Larry</td>
                            </tr>
                            <tr>
                                <td class="text-left">Email (Estudiante):</td>
                                <td class="text-left" id="celEmail">Larry</td>
                            </tr>
                            <tr>
                                <td class="text-left">Semestre:</td>
                                <td class="text-left" id="celSemestre">Larry</td>
                            </tr>
                            <tr>
                                <td class="text-left">Programa:</td>
                                <td class="text-left" id="celPrograma">Larry</td>
                            </tr>
                            <tr>
                                <td class="text-left">curso:</td>
                                <td class="text-left" id="celCurso">Larry</td>
                            </tr>
                            <tr>
                                <td class="text-left">Docente:</td>
                                <td class="text-left" id="celDocente">Larry</td>
                            </tr>
                            <tr>
                                <td class="text-left">Matriculado:</td>
                                <td class="text-left" id="celMatriculado">Larry</td>
                            </tr>
                            <tr>
                                <td class="text-left">Estado:</td>
                                <td class="text-left" id="celEstado">Larry</td>
                            </tr>
                            <tr>
                                <td class="text-left">Fecha registro:</td>
                                <td class="text-left" id="celFechaRegistro">Larry</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div id="loading" class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>
</div>