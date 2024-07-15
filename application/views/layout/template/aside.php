  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="https://www.uniclaretiana.edu.co" target="_blank"  class="brand-link">
      <img src="<?php echo base_url(); ?>assets/dist/img/logo.jpeg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="width:200px;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url(); ?>assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?php echo base_url(); ?>mi/perfil" class="d-block"><?php echo $_SESSION['nombre']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>dashboard/administracion" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>            
          </li>       
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>mi/perfil" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Mi perfil
              </p>
            </a>
          </li>
          <?php if($_SESSION['rol'] == "Admin" ){; ?>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>ir/a/coordenadas" class="nav-link">
              <i class="nav-icon fas fa-location-arrow"></i>
              <p>
                Coordenadas
              </p>
            </a>
          </li>
          <?php }; ?>
          <?php if($_SESSION['rol'] == "Admin" ){; ?>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>ir/a/programas" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Programas/Cursos
              </p>
            </a>
          </li>
          <?php }; ?>
          <?php if($_SESSION['rol'] == "Admin" ){; ?>
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>ir/a/jefe" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Jefes de programas
              </p>
            </a>
          </li>
          <?php }; ?>
          
          <?php if($_SESSION['rol'] == "Jefe"){; ?>
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>ir/a/docentes" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Docentes
              </p>
            </a>
          </li>
          <?php }; ?>
          <?php if($_SESSION['rol'] == "Docente" || $_SESSION['rol'] == "Jefe" ){; ?>
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>ir/a/estudiantes" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Alumnos
              </p>
            </a>         
          </li>
          <?php }; ?>
          <?php if($_SESSION['rol'] == "Docente" ){; ?>
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>habilitar/asistencias" class="nav-link">
              <i class="nav-icon fa fa-unlock-alt"></i>
              <p>
                Habilitar asistencias
              </p>
            </a>         
          </li>
          <?php }; ?>
          <?php if($_SESSION['rol'] == "Estudiante" ){; ?>
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>asistencia/curso" class="nav-link">
              <i class="nav-icon fa fa-check-square"></i>
              <p>
                Asistencias
              </p>
            </a>         
          </li>
          <?php }; ?>
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>login/logout" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Cerrar sesion
              </p>
            </a>         
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
