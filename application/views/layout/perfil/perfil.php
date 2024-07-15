<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Mi Perfil</h4>
         
        </div>
        <img class="card-img-top" alt="">
        <div class="card-body">
            <form id="frmEmpresa" method="post">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cedula">Cédula</label>
                            <input type="hidden" id="id" name="id" class="form-control "
                                value="<?php echo $perfil[0]->id ?>">
                            <input type="hidden" id="idClave" name="idClave" class="form-control "
                                value="<?php echo $perfil[0]->clave ?>">

                            <input type="text" name="cedula" id="cedula" class="form-control valid validNumber"
                                placeholder="Cédula" aria-describedby="helpId" value="<?php echo $perfil[0]->cedula ?>"
                                disabled>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="hidden" id="id" name="id" class="form-control "
                                value="<?php echo $perfil[0]->id ?>">
                            <input type="text" name="nombre" id="nombre" class="form-control valid validText"
                                placeholder="Nombre" aria-describedby="helpId" value="<?php echo $perfil[0]->nombre ?>"
                                disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" name="apellidos" id="apellidos" class="form-control valid validText"
                                placeholder="Apellidos" aria-describedby="helpId"
                                value="<?php echo $perfil[0]->apellidos ?>" disabled>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control valid validNumber"
                                placeholder="Teléfono" aria-describedby="helpId"
                                value="<?php echo $perfil[0]->telefono ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input type="text" name="direccion" id="direccion" class="form-control "
                                placeholder="Dirección de empresa" aria-describedby="helpId"
                                value="<?php echo $perfil[0]->direccion ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="correo">Correo</label>
                            <input type="text" name="correo" id="correo" class="form-control valid validEmail"
                                placeholder="Email" aria-describedby="helpId" value="<?php echo $perfil[0]->correo ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="clave">Clave</label>
                            <input type="password" name="clave" id="clave" class="form-control"
                                placeholder="Escribe la nueva clave" aria-describedby="helpId">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="perfil">Perfil</label>
                            <input type="text" name="perfil" id="perfil" class="form-control" placeholder="Perfil"
                                aria-describedby="helpId" value="<?php echo $perfil[0]->rol ?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <?php if($perfil[0]->rol == "Docente"){ ?>
                    <button type='button' class='btn btn-warning' onclick="detallesD(event)">Más..</button>
                    <?php }elseif($perfil[0]->rol =="Estudiante"){; ?>
                    <button type='button' class='btn btn-warning' onclick="detallesA(event)">Más..</button>
                    <?php }; ?>
                    <button type='button' class='btn btn-primary' onclick="actualizarPerfil(event)">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
    <!-- detalles del estudiante -->
    <div class="modal fade" id="modalDetalles" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header header-primary">
                    <h5 class="modal-title" id="titleModal">Más informacion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" id="tablaProgramasCursosAsignadosA">
                        <tbody>

                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- detalles del docente -->
    <div class="modal fade" id="modalDetallesD" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header header-primary">
                    <h5 class="modal-title" id="titleModal">Más informacion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" id="tablaProgramasCursosAsignados">
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
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
