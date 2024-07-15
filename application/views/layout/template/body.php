  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1 class="m-0 text-dark">Dashboard</h1>
                  </div><!-- /.col -->

              </div><!-- /.row -->
          </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      <!-- Main content -->
      <section class="content">
          <div class="container-fluid">
              <!-- Info boxes -->
              <div class="row">
                  <div class="col-12 col-sm-6 col-md-3">
                      <div class="info-box">
                          <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                          <div class="info-box-content">
                              <span class="info-box-text">Docente</span>
                              <span class="info-box-number">
                                  <?php echo $docentes ?>
                              </span>

                          </div>
                          <?php if($_SESSION['rol'] == "Jefe" ){; ?>
                          <a href="<?php echo base_url(); ?>ir/a/docentes">
                              <h6>ir a docentes</h6>
                          </a>
                          <?php }; ?>
                          <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                  </div>
                  <!-- /.col -->
                  <div class="col-12 col-sm-6 col-md-3">
                      <div class="info-box mb-3">
                          <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>

                          <div class="info-box-content">
                              <span class="info-box-text">Alumnos</span>
                              <span class="info-box-number"><?php echo $alumnos ?></span>
                          </div>
                          <?php if($_SESSION['rol'] == "Docente" ){; ?>
                          <a href="<?php echo base_url(); ?>ir/a/estudiantes">
                              <h6>ir a alumnos</h6>
                          </a>
                          <?php }; ?>
                          <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                  </div>
                  <!-- /.col -->

                  <!-- fix for small devices only -->
                  <div class="clearfix hidden-md-up"></div>

                  <div class="col-12 col-sm-6 col-md-3">
                      <div class="info-box mb-3">
                          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-book"></i></span>

                          <div class="info-box-content">
                              <span class="info-box-text">Programas</span>
                              <span class="info-box-number"><?php echo $programas ?></span>
                          </div>
                          <?php if($_SESSION['rol'] == "Admin" ){; ?>
                          <a href="<?php echo base_url(); ?>ir/a/programas">
                              <h6>ir a programas</h6>
                          </a>
                          <?php }; ?>
                          <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                  </div>
                  <!-- /.col -->
                  <div class="col-12 col-sm-6 col-md-3">
                      <div class="info-box mb-3">
                          <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-book"></i></span>

                          <div class="info-box-content">
                              <span class="info-box-text">Cursos</span>
                              <span class="info-box-number"><?php echo $cursos ?></span>
                          </div>
                          <?php if($_SESSION['rol'] == "Admin" ){; ?>
                          <a href="<?php echo base_url(); ?>programas/cursos_">
                              <h6>ir a cursos</h6>
                          </a>
                          <?php }; ?>
                          <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                  </div>
                  <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                  <div class="col-md-12">
                      <div class="card">
                          <!-- /.card-header -->
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-md-8">
                                      <p class="text-center">
                                          <strong>Calendario</strong>
                                      </p>

                                      <div class="calendar">
                                          <div class="header">
                                              <button id="prevMonth">Anterior</button>
                                              <h2 id="currentMonthYear" style="font-size:18px; text-align:center"></h2>
                                              <button id="nextMonth">Siguiente</button>
                                          </div>
                                          <table id="calendarBody"></table>

                                      </div>

                                      <!-- /.chart-responsive -->
                                  </div>
                                  <!-- /.col -->
                                  <div class="col-md-4">
                                      <p class="text-center">
                                          <strong>Gráfica porcentual</strong>
                                      </p>

                                      <div class="progress-group">
                                          Docente
                                          <span class="float-right"><b><?php echo $docentes ?></span>
                                          <div class="progress progress-sm">
                                              <div class="progress-bar bg-primary"
                                                  style="width: <?php echo $docentes ?>%"></div>
                                          </div>
                                      </div>
                                      <!-- /.progress-group -->

                                      <div class="progress-group">
                                          Alumnos
                                          <span class="float-right"><b><?php echo $alumnos ?></b></span>
                                          <div class="progress progress-sm">
                                              <div class="progress-bar bg-danger" style="width:<?php echo $alumnos ?>%">
                                              </div>
                                          </div>
                                      </div>

                                      <!-- /.progress-group -->
                                      <div class="progress-group">
                                          <span class="progress-text">Programas</span>
                                          <span class="float-right"><b><?php echo $programas ?></b></span>
                                          <div class="progress progress-sm">
                                              <div class="progress-bar bg-success"
                                                  style="width: <?php echo $programas ?>%"></div>
                                          </div>
                                      </div>

                                      <!-- /.progress-group -->
                                      <div class="progress-group">
                                          Cursos
                                          <span class="float-right"><b><?php echo $cursos ?></b></span>
                                          <div class="progress progress-sm">
                                              <div class="progress-bar bg-warning"
                                                  style="width: <?php echo $cursos ?>%"></div>
                                          </div>
                                      </div>
                                      <!-- /.progress-group -->
                                      <!-- <canvas id="graficaPorcentual" width="400" height="200"></canvas> -->
                                  </div>
                                  <!-- /.col -->
                              </div>
                              <!-- /.row -->
                          </div>
                          <!-- ./card-body -->
                      </div>
                      <!-- /.card -->
                  </div>
                  <!-- /.col -->
              </div>
              <div class="row">
                  <div class="col-md-6">
                      <!-- Formulario para ingresar una nueva nota -->
                      <form id="nuevaNotaForm">
                          <?php if( $_SESSION['rol'] == 'Admin'): ?>
                          <div class="form-group">
                              <label for="">Su nota es: Pesonal / publica para jefe de programa(<font color="red">*
                                  </font>)</label>
                              <select class="form-control" name="tipo_nota" id="tipo_nota">
                                  <option value="personal">Personal</option>
                                  <option value="publica">Jefe de programas</option>
                              </select>
                          </div>
                          <?php endif; ?>
                          <?php if( $_SESSION['rol'] == 'Jefe'): ?>
                          <div class="form-group">
                              <label for="">Su nora es: Pesonal / Publica para docentes / Administración(<font
                                      color="red">*</font>
                                  )</label>
                              <select class="form-control" name="tipo_nota" id="tipo_nota">
                                  <option value="personal">Personal</option>
                                  <option value="publica">Publica</option>
                                  <option value="admin">Administración</option>
                              </select>
                          </div>
                          <?php endif; ?>

                          <?php if($_SESSION['rol'] == 'Docente'): ?>
                          <div class='form-group'>
                              <label for='medida'>¿Su nota es para?</label>
                              <input type="text" id="buscador3" class="form-control" placeholder="Buscar curso..."
                                  oninput="filtrarCurso()">
                              <select class="form-control" id="idCurso" name="idCurso">
                                  <option selected="selected">Seleccionar..</option>
                                  <?php foreach ($curso as $row){ ?>
                                  <option value="<?php echo $row->idCurso; ?>"><?php echo $row->curso; ?>
                                  </option>
                                  <option value="Jefe">Jefe de programa</option>

                                  <?php }; ?>
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="">Pesonal / Publica (<font color="red">*</font>)</label>
                              <select class="form-control" name="tipo_nota" id="tipo_nota">
                                  <option value="personal">Personal</option>
                                  <option value="publica">Publica</option>
                              </select>
                          </div>
                          <?php endif; ?>
                          <?php if( $_SESSION['rol'] == 'Estudiante'): ?>
                          <div class='form-group'>
                              <label for='medida'>¿Su nota es para?</label>
                              <input type="text" id="buscador3" class="form-control" placeholder="Buscar curso..."
                                  oninput="filtrarCurso()">
                              <select class="form-control" id="idCurso" name="idCurso">
                                  <option selected="selected">Seleccionar..</option>
                                  <?php foreach ($curso as $row){ ?>
                                  <option value="<?php echo $row->idCurso; ?>"><?php echo $row->curso; ?>
                                  </option>
                                  <?php }; ?>
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="">Pesonal / Publica (<font color="red">*</font>)</label>
                              <select class="form-control" name="tipo_nota" id="tipo_nota">
                                  <option value="personal">Personal</option>
                                  <option value="publica">Publica</option>
                              </select>
                          </div>
                          <?php endif; ?>

                          <div class="form-group">
                              <label for="titulo">Título (<font color="red">*</font>)</label>
                              <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Título">
                          </div>
                          <div class="form-group">
                              <label for="contenido">Contenido (<font color="red">*</font>)</label>
                              <textarea class="form-control" name="contenido" id="contenido"
                                  placeholder="Contenido"></textarea>
                          </div>
                          <div class="form-group">
                              <label for="color">Color (<font color="red">*</font>)</label>
                              <select class="form-control" name="color" id="color">
                                  <option value="yellow">Amarillo</option>
                                  <option value="blue">Azul</option>
                                  <option value="cyan">Cian</option>
                                  <option value="gray">Gris</option>
                                  <option value="orange">Naranja</option>
                                  <option value="magenta">Magenta</option>
                                  <option value="maroon">Marrón</option>
                                  <option value="purple">Morado</option>
                                  <option value="olive">Oliva</option>
                                  <option value="gold">Oro</option>
                                  <option value="silver">Plata</option>
                                  <option value="red">Rojo</option>
                                  <option value="pink">Rosa</option>
                                  <option value="salmon">Salmón</option>
                                  <option value="green">Verde</option>
                                  <option value="violet">Violeta</option>

                                  <!-- Agrega más opciones de colores según lo desees -->
                              </select>
                          </div>
                          <button type="submit" class="btn btn-primary">Guardar Nota</button>
                      </form>
                  </div>
                  <div class="col-md-6">
                      <!-- Lista de notas existentes -->
                      <p style="text-align:center;">Nota personales.</p>
                      <?php if(empty($notasPersonal)): ?>
                      <p style="text-align:center;">No hay notas disponibles en este momento.</p>
                      <?php else: ?>
                      <ul class="notas-lista">
                          <?php foreach ($notasPersonal as $nota): ?>
                          <li class="nota-item" data-id="<?php echo $nota->id; ?>"
                              style="background-color: <?php echo $nota->color; ?>">
                              <?php if($_SESSION['rol'] == 'Admin'){ ?>
                              <?php echo $nota->titulo; ?>
                              <?php }if($_SESSION['rol'] == 'Jefe'){ ?>
                              <?php echo $nota->titulo; ?>
                              <?php }if($_SESSION['rol'] == 'Docente'){ ?>
                              <?php echo $nota->titulo; ?>
                              <?php }if($_SESSION['rol'] == 'Estudiante'): ?>
                              <?php echo $nota->titulo; ?> : <?php echo $nota->curso; ?>
                              <?php endif; ?>
                              <button class="btnEliminarNota btn btn-danger btn-sm float-right">Eliminar</button>
                              <div class="contenido-nota">
                                  <?php echo $nota->contenido; ?>
                              </div>
                          </li>
                          <?php endforeach; ?>
                      </ul>
                      <?php endif; ?>
                      <!-- nota de los docentes y estudiantes del curso vista para el ellos mismos -->

                      <?php if($_SESSION['rol'] == 'Docente' || $_SESSION['rol'] == 'Estudiante'): ?>
                      <div class='form-group'>
                          <p style="text-align:center;">Nota publicas por curso.</p>
                          <label for='medida'>Curso que deseas ver nota publica</label>
                          <input type="text" id="buscador34" class="form-control" placeholder="Buscar curso..."
                              oninput="filtrarCursos()">
                          <select class="form-control" id="idCursos" name="idCursos">
                              <option selected="selected">Seleccionar..</option>
                              <?php foreach ($curso as $row){ ?>
                              <option value="<?php echo $row->idCurso; ?>"><?php echo $row->curso; ?>
                              </option>
                              <?php }; ?>
                          </select>
                      </div>
                      <?php endif; ?>
                      <?php if($_SESSION['rol'] == 'Docente' || $_SESSION['rol'] == 'Estudiante'): ?>

                      <div id="notasContainer">

                      </div>
                      <?php endif; ?>
                      <!-- nota de los docentes del programa vista para el jefe -->

                      <?php if( $_SESSION['rol'] == 'Jefe'): ?>
                      <div class='form-group'>
                          <p style="text-align:center;">Nota publicas por de los docentes del programa.</p>
                          <label for='medida'>Notas publica</label>
                          <select class="form-control" id="idDocente" name="idDocente">
                              <option selected="selected">Seleccionar..</option>
                              <option value="Docente">Docente</option>
                              <option value="Admin">Administración</option>

                              <!-- Agrega más opciones de colores según lo desees -->
                          </select>
                          </select>
                      </div>
                      <?php endif; ?>
                      <?php if($_SESSION['rol'] == 'Jefe'): ?>

                      <div id="notasContainerr">

                      </div>
                      <?php endif; ?>
                      <!-- nota de los jefes del programa vista para el docente -->

                      <?php if( $_SESSION['rol'] == 'Docente'): ?>
                      <div class='form-group'>
                          <p style="text-align:center;">Nota publicas por el jefe de programa.</p>
                          <label for='medida'>Notas publica</label>
                          <select class="form-control" id="idJefe" name="idJefe">
                              <option selected="selected">Seleccionar..</option>
                              <option value="Jefe">Jefe de programa</option>
                              <!-- Agrega más opciones de colores según lo desees -->
                          </select>
                          </select>
                      </div>
                      <?php endif; ?>
                      <?php if($_SESSION['rol'] == 'Docente'): ?>

                      <div id="notasContainerJ">

                      </div>
                      <?php endif; ?>
                      <!-- nota de los jefes del programa vista para el admin -->
                      <?php if( $_SESSION['rol'] == 'Admin'): ?>
                      <div class='form-group'>
                          <p style="text-align:center;">Nota publicas por el jefe de programa.</p>
                          <label for='medida'>Notas publica</label>
                          <select class="form-control" id="idAdmin" name="idAdmin">
                              <option selected="selected">Seleccionar..</option>
                              <option value="Jefe">Jefe de programa</option>
                              <!-- Agrega más opciones de colores según lo desees -->
                          </select>
                          </select>
                      </div>
                      <?php endif; ?>
                      <?php if($_SESSION['rol'] == 'Admin'): ?>

                      <div id="notasContainerA">

                      </div>
                      <?php endif; ?>
                  </div>
              </div>
          </div>
          <!--/. container-fluid -->
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
// Obtén los datos de porcentajes por categoría (pueden ser proporcionados por el controlador o modelo)
document.addEventListener("DOMContentLoaded", function() {
    const data = {
        labels: ["Docentes", "Alumnos", "Programas", "Cursos"],
        datasets: [{
            data: [<?php echo $docentes ?>, <?php echo $alumnos ?>, <?php echo $programas ?>,
                <?php echo $cursos ?>
            ],
            backgroundColor: ["rgba(75, 192, 192, 0.2)", "rgba(255, 99, 132, 0.2)",
                "rgba(75, 192, 192, 0.2)", "rgba(255, 205, 86, 0.2)"
            ],
            borderColor: ["rgba(75, 192, 192, 1)", "rgba(255, 99, 132, 1)", "rgba(75, 192, 192, 1)",
                "rgba(255, 205, 86, 1)"
            ],
            borderWidth: 1
        }]
    };

    const ctx = document.getElementById("graficaPorcentual").getContext("2d");

    const graficaPorcentual = new Chart(ctx, {
        type: "bar",
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
  </script>