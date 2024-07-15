<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div>
                    <h1>Programas</h1>
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary" onclick="openModal();"
                        data-toggle="modal">Nuevo</button>
                        <button typen="button" class="btn btn-info" onclick="openCursos();"
                        data-toggle="modal">Cursos/Asignaturas</button>
                  
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
                        <h3 class="card-title">Administración de los programas que están habilitados en el plantel educativo. </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class='table-responsive'>
                            <table id="tableMaterias" class="table table-light table-hover table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Programas</th>
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
    <div class='modal fade' id='id_materias' tabindex='-1' role='dialog' aria-labelledby='modelTitleId'
        aria-hidden='true'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header headerRegister'>
                    <h5 class='modal-title' id='titleModal'> </h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <form method='post' id='frmmaterias' autocomplete="off">
                        <span for="text">El campo con (*) es obligatorio.</span>
                        <input type='hidden' id='idMateria' name='idMateria'>
                        <div class="form-group">
                            <label for="inputName">Programa(<font color="red">*</font>)</label>
                            <input type="text" class="form-control valid validText" name="materia" id="materia"
                                placeholder="Nombre del programa">
                        </div>                       
                        <div class='modal-footer'>
                            <button id='btnMaterias' type='submit' class='btn btn-primary'><span id='btnText'>
                                </span></button>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>