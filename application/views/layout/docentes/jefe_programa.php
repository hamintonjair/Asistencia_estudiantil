<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div>
                    <h1>Jefes de programas</h1>
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary" onclick="openModalJefe();"
                        data-toggle="modal">Nuevo</button>
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
                        <h3 class="card-title">Administración de los jefe de programas del plantel educativo. </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class='table-responsive'>
                            <table id="tableJefe" class="table table-light table-hover table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Apellidos</th>
                                        <th>Cédula</th>
                                        <th>Teéfono</th>
                                        <th>Dirección</th>
                                        <th>Correo</th>
                                        <th>Programa</th>
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
    <div class='modal fade' id='modalJefe' tabindex='-1' role='dialog' aria-labelledby='modelTitleId'
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
                    <form method='post' id='frmjefe' autocomplete="off">
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
                                        <?php foreach ($cedulaJ as $row) { ?>
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
                                        placeholder="Nombre del jefe de programa">
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <label for="inputName">Apellidos(<font color="red">*</font>)</label>
                                    <input type="text" class="form-control valid validText" name="apellidos"
                                        id="apellidos" placeholder="Apelidos del jefe de programa">
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for="inputName">Cédula(<font color="red">*</font>)</label>
                                    <input type="number" class="form-control valid validNumber" name="cedula"
                                        id="cedula" placeholder="Cédula del jefe de programa">
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label for="inputName">Teléfono(<font color="red">*</font>)</label>
                                    <input type="number" class="form-control valid validNumber" name="telefono"
                                        id="telefono" placeholder="Teléfono del jefe de programa">
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <label for="inputName">Dirección(<font color="red">*</font>)</label>
                                    <input type="text" class="form-control" name="direccion" id="direccion"
                                        placeholder="Dirección del jefe de programa">
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <label for="inputName">Contraseña</label>
                                    <input type="password" class="form-control" name="clave" id="clave"
                                        placeholder="Password del jefe de programa">
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <label for="inputName">Correo(<font color="red">*</font>)</label>
                                    <input type="text" class="form-control valid validEmail" name="correo" id="correo"
                                        placeholder="Correo electrónico del jefe de programa">
                                </div>
                            </div>

                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <label for='materia'>Jefe para el Programa(<font color="red">*</font>)</label>
                                    <input type="text" id="buscador4" class="form-control"
                                        placeholder="Buscar programa..." oninput="filtrarProgram()">
                                    <select class="form-control" id="id_materia" name="id_materia">
                                        <option selected="selected">Seleccionar..</option>
                                        <?php foreach ($progra as $row){ ?>
                                        <option value="<?php echo $row->id; ?>"><?php echo $row->materia; ?>
                                        </option>
                                        <?php }; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='modal-footer'>
                            <button id='btnJefe' type='submit' class='btn btn-primary'><span id='btnText'>
                                </span></button>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>