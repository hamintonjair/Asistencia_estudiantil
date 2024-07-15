<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div>
                    <h1>Docentes</h1>
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary" onclick="openModalDocentes();"
                        data-toggle="modal">Nuevo</button>
                    <button typen="button" class="btn btn-warning" onclick="openAsignar();" data-toggle="modal">Asignar
                        docentes</button>
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
                        <h3 class="card-title">Administración de los docentes del plantel educativo. </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class='table-responsive'>
                            <table id="tableDocentes" class="table table-light table-hover table-bordered">
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

    <!-- Modal registrar -->

    <!-- Modal -->
    <div class='modal fade' id='modalDocente' tabindex='-1' role='dialog' aria-labelledby='modelTitleId'
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
                    <form method='post' id='frmdocentes' autocomplete="off">
                        <span for="text">Los campos con (*) son obligatorios.</span>
                        <input type='hidden' id='idDocente' name='idDocente'>
                        <div class='row'>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cedula">Buscar por Cédula</label>
                                    <input type="text" id="buscador" class="form-control" placeholder="Buscar cedula..."
                                        oninput="filtrarCedula()">
                                    <select id="cedulaA" name="cedulaA" class="form-control">
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
                                        placeholder="Nombre del docente">
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <label for="inputName">Apellidos(<font color="red">*</font>)</label>
                                    <input type="text" class="form-control valid validText" name="apellidos"
                                        id="apellidos" placeholder="Apelidos del docente">
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for="inputName">Cédula(<font color="red">*</font>)</label>
                                    <input type="number" class="form-control valid validNumber" name="cedula"
                                        id="cedula" placeholder="Cédula del docente">
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for="inputName">Teléfono(<font color="red">*</font>)</label>
                                    <input type="number" class="form-control valid validNumber" name="telefono"
                                        id="telefono" placeholder="Teléfono del docente">
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <label for="inputName">Dirección(<font color="red">*</font>)</label>
                                    <input type="text" class="form-control" name="direccion" id="direccion"
                                        placeholder="Dirección del docente">
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <label for="inputName">Contraseña</label>
                                    <input type="password" class="form-control" name="clave" id="clave"
                                        placeholder="Password del docente">
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class='form-group'>
                                    <label for="inputName">Correo(<font color="red">*</font>)</label>
                                    <input type="text" class="form-control valid validEmail" name="correo" id="correo"
                                        placeholder="Correo electrónico del docente">
                                </div>
                            </div>
                        </div>
                        <div class='modal-footer'>
                            <button id='btnDocente' type='submit' class='btn btn-primary'><span id='btnText'>
                                </span></button>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Modal ver mas detalles -->
    <div class="modal fade" id="modalViewDocente" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header header-primary">
                    <h5 class="modal-title" id="titleModal">Datos del Docente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
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