<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Dashboard extends CI_Controller {

    public function __construct() {

        session_start();
        if ( empty( $_SESSION[ 'activo' ] ) ) {
            echo '<script>window.location.href="http://localhost/Asistencia_estudiantil/login"</script>';

        }
        parent:: __construct();
        $this->load->model( 'DashboardModel' );
        $this->load->model( 'MateriasModel' );

    }
    //dashboard

    public function administracion()
    {
        $id = $_SESSION[ 'id' ];
        $data[ 'notasPersonal' ] = $this->DashboardModel->getNotas( $id );

        if ( $_SESSION[ 'rol' ] == 'Docente' || $_SESSION[ 'rol' ] == 'Estudiante' ) {
            $data[ 'curso' ] = $this->MateriasModel->listarC( $id );
        }

        $data[ 'docentes' ] = $this->DashboardModel->contarDocentes();
        $data[ 'alumnos' ] = $this->DashboardModel->contarAlumnos();
        $data[ 'cursos' ] = $this->DashboardModel->contarCursos();
        $data[ 'programas' ] = $this->DashboardModel->contarProgramas();

        $data[ 'suma' ] = $data[ 'docentes' ] + $data[ 'alumnos' ] + $data[ 'cursos' ]+ $data[ 'programas' ] ;
        $this->load->view( 'layout/template/header', $data );
        $this->load->view( 'layout/template/aside' );
        $this->load->view( 'layout/template/body', $data );
        $this->load->view( 'layout/template/footer' );
    }

    public function obtenerNotas( $idCurso ) {
        if ( $idCurso != 'Seleccionar..' ) {
            $notas = $this->DashboardModel->obtenerNotas( $idCurso );
        } else {
            $notas = '';
        }
        echo json_encode( $notas, JSON_UNESCAPED_UNICODE );
        die();
    }
    //nota

    public function guardar_nota() {

        $id = $_SESSION[ 'id' ];
        $titulo = $this->input->post( 'titulo' );
        $contenido = $this->input->post( 'contenido' );
        $color = $this->input->post( 'color' );
        $tipo_nota = $this->input->post( 'tipo_nota' );
        $idCurso = $this->input->post( 'idCurso' );

        //si es el jefe de programa
        if ( $_SESSION[ 'rol' ] == 'Jefe' ) {
            if ( $tipo_nota == 'publica' ) {
                $idCurso = 'Docente';
                $contenido =  $contenido .': por el '. $_SESSION[ 'rol' ] .' '. $_SESSION[ 'nombre' ];
            } else if ( $tipo_nota == 'admin' ) {
                $idCurso = 'Admin';
                $contenido =  $contenido .': por el '. $_SESSION[ 'rol' ] .' '. $_SESSION[ 'nombre' ];
            } else {
                $idCurso = null;

            }

        }
        //si es el administrador
        if ( $_SESSION[ 'rol' ] == 'Admin' ) {
            if ( $tipo_nota == 'publica' ) {
                $tipo_nota = 'jefe';
                $idCurso = 'Jefe_';
                $contenido =  $contenido .': por el '. $_SESSION[ 'rol' ] .' '. $_SESSION[ 'nombre' ];
            } else {
                $idCurso = null;

            }
        }
        //si es el docente
        if ( $_SESSION[ 'rol' ] == 'Docente' ) {
            if ( is_numeric( $idCurso ) && $tipo_nota == 'publica') {
                $contenido =  $contenido .': por el '. $_SESSION[ 'rol' ] .' '. $_SESSION[ 'nombre' ];
            }if ( $idCurso == 'Jefe' && $tipo_nota == 'publica' ) {
                $contenido =  $contenido .': por el '. $_SESSION[ 'rol' ] .' '. $_SESSION[ 'nombre' ];
            }
        }
        //si es el estudiante
        if ( $_SESSION[ 'rol' ] == 'Estudiante' ) {
            if ( is_numeric( $idCurso ) && $tipo_nota == 'publica') {
                $contenido =  $contenido .': por el '. $_SESSION[ 'rol' ] .' '. $_SESSION[ 'nombre' ];
            }
        }

        if ( $tipo_nota == 'personal' && $idCurso == 'Seleccionar..' ) {
            $msg = array( 'ok' => false, 'post' => 'Debes escoger el curso.' );

        } else if ( $tipo_nota == 'publica' && $idCurso == 'Seleccionar..' || $tipo_nota == 'personal' && $idCurso == 'Jefe' ) {
            $msg = array( 'ok' => false, 'post' => 'Debes escoger los campos correctos.' );

        } else {
            if ( empty( $titulo ) || empty( $contenido ) || empty( $color ) || empty( $tipo_nota ) ) {
                $msg = array( 'ok' => false, 'post' => 'Todos los campos son obligatorios.' );

            } else {               
                 $contenido =  $contenido;                
                $resp = $this->DashboardModel->setNotas( $titulo, $contenido, $color, $tipo_nota, $idCurso, $id );
                if ( $resp ) {
                    $msg = array( 'ok' => true, 'post' => 'Nota registrada.' );
                } else {
                    $msg = array( 'ok' => false, 'post' => 'Error al registrar la nota.' );
                }
            }
        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }

    //eliminar nota

    public function eliminar_nota( $id ) {

        $resp = $this->DashboardModel->deleteNotas( $id );
        if ( $resp > 0 ) {
            $msg = array( 'ok' => true, 'post' => 'Nota eliminada.' );
        } else {
            $msg = array( 'ok' => false, 'post' => 'No puedes eliminar esta nota.' );
        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }
    //coordenada localidad
    public function coordenadas(){
        $data[ 'docentes' ] = $this->DashboardModel->contarDocentes();
        $data[ 'alumnos' ] = $this->DashboardModel->contarAlumnos();
        $data[ 'cursos' ] = $this->DashboardModel->contarCursos();
        $data[ 'programas' ] = $this->DashboardModel->contarProgramas();
        $coordenadas = $this->DashboardModel->getCoordenadas();

        $data[ 'suma' ] = $data[ 'docentes' ] + $data[ 'alumnos' ] + $data[ 'cursos' ]+ $data[ 'programas' ] ;
        $this->load->view( 'layout/template/header', $data );
        $this->load->view( 'layout/template/aside' );
        $this->load->view( 'layout/asistencia/coordenadas',compact('coordenadas') );
        $this->load->view( 'layout/template/footer' ); 
    }
    //insertar coordenadas
    public function insertCoordenadas(){
        $latitud = $this->input->post('latitud');
        $longitud = $this->input->post('longitud');

        $resp = $this->DashboardModel->insertCoordenadas( $latitud,$longitud );

        if ( $resp) {
            $msg = array( 'ok' => true, 'post' => 'Coordenadas actualizada.' );
        } else {
            $msg = array( 'ok' => false, 'post' => 'No se puedo actualizar la coordenada.' );
        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
       
    }
}
