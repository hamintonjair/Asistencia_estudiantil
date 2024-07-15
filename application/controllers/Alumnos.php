<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumnos extends CI_Controller {

    public function __construct(){
       
        session_start();
        if(empty($_SESSION['activo'])){
            echo '<script>window.location.href="http://localhost/Asistencia_estudiantil/login"</script>';				
        }
        parent:: __construct();
        $this->load->model('MateriasModel');
        $this->load->model('AlumnosModel');
        $this->load->model('DocentesModel');
        $this->load->model('DashboardModel');

    }
        //vista estudiantes
	public function Vista()
	{
        // Obtiene el ID del docente y el token desde la información almacenada en la cookie.
        $idDocente = $_SESSION['id'];
        $data['program'] = $this->MateriasModel->listarP($idDocente);

        // var_dump($data);exit;
        $data['curs'] = $this->MateriasModel->listarC($idDocente);
        $data['semestre'] = $this->MateriasModel->listarS($idDocente);
        $data['cedula'] = $this->AlumnosModel->listar();
        $data['cedulaD']= $this->DocentesModel->listarCedula();
        $data['docentes'] = $this->DashboardModel->contarDocentes();
        if($_SESSION['rol'] == 'Docente'){
            $data['alumnos'] = $this->DashboardModel->contarAlumnosD($idDocente);  
        }else{
            $data['alumnos'] = $this->DashboardModel->contarAlumnosP();
        }
        $data['cursos'] = $this->DashboardModel->contarCursos();
        $data['programas'] = $this->DashboardModel->contarProgramas();

        $data['suma'] = $data['docentes'] + $data['alumnos'] + $data['cursos']+ $data['programas'] ;

		$this->load->view('layout/template/header',$data);
        $this->load->view('layout/template/aside');
        $this->load->view('layout/alumnos/alumno',$data);
        $this->load->view('layout/template/footer');
	}
         //registrar Alumnos
    public function registrar(){

            $nombre = $this->input->post("nombre");
            $apellidos = $this->input->post("apellidos");
            $cedula = $this->input->post("cedula");
            $telefono = $this->input->post("telefono");
            $direccion = $this->input->post("direccion");
            $correo = $this->input->post("correo");
            $id_materia = $this->input->post("id_materia");
            $idCurso = $this->input->post("idCurso");
            $semestre = $this->input->post("semestre");
            $perfil = "Estudiante";
            $matriculado = $this->input->post("matriculado");
            $idDocente = $_SESSION['id'];             
            $id = $this->input->post("idAlumno");  

            if(empty($nombre) ||empty($apellidos)||empty($cedula)||empty($telefono) ||empty($direccion) ||
             empty($correo) || $id_materia =="Seleccionar.." || $semestre =="Seleccionar.." || empty($matriculado)|| empty($idDocente)
             || $idCurso =="Seleccionar.."){
                $sms = array('ok' => false, 'post' => 'Todos los campo son obligatorios.');
            }else{
                if(empty($id)){
                    $password = empty($this->input->post("clave")) ? $this->DashboardModel->passGenerator():  $this->input->post("clave");
                    $pass = hash("SHA256", $password);
                     $resp = $this->AlumnosModel->validarCedula($cedula,$idCurso);

                     if(empty($resp)){
                        $resp = $this->AlumnosModel->validarCorreo($correo, $idCurso);

                        if(empty($resp)){
                            $data = $this->AlumnosModel->registerAlumno($nombre,$apellidos,$cedula,$telefono, $direccion,
                            $correo,$id_materia,$semestre,$perfil,$matriculado,$idDocente,$pass,$idCurso);
                            if($data){
                                $sms = array('ok' => true, 'post' => 'Registro exitoso.');
                                $nombreUsuario = $nombre.' '.$apellidos;
                                $dataUsuario = array(
                                'nombreUsuario' => $nombreUsuario,
                                'email'         =>$correo,
                                'password'      =>$password,
                                'asunto'        =>'Bienvenido al sistema de asistencias de la uniclaretiana',                             
                               
                                );
                                $this->DocentesModel->sendEmail($dataUsuario,'email_bienvenida');
                            }
                            else{
                                $sms = array('ok' => false, 'post' => 'Ya existe un alumno registrado con este corro y curso.');
                            }
                        }
                     }else{
                        $sms = array('ok' => false, 'post' => 'Ya existe un alumno registrado con esta cédula y curso.');
                     }
               
                }else{
                    if(empty($this->input->post("clave"))){
                       $pass = $this->input->post("password");
                       $Pass = "Continuas con la última clave creada, si no la recuerda solicita la restauración.";
                    }else{
                        $pass = hash("SHA256", $this->input->post("clave"));
                        $Pass = $this->input->post("clave");
                    }                   
                    $data = $this->AlumnosModel->updateAlumno($nombre,$apellidos,$cedula,$telefono, $direccion,$correo,
                    $id_materia,$semestre,$perfil,$matriculado,$idDocente,$pass,$idCurso,$id);
                    if($data){
                        $sms = array('ok' => true, 'post' => 'Actualizado exitoso.');
                        $nombreUsuario = $nombre.' '.$apellidos;
                        $dataUsuario = array(
                        'nombreUsuario' => $nombreUsuario,
                        'email'         =>$correo,
                        'password'      =>$Pass,
                        'asunto'        =>'Has solicitado actualización de tus datos',                             
                       
                        );
                        $this->DocentesModel->sendEmailUpdate($dataUsuario,'email_actualizacion');
                    }else{
                        $sms = array('ok' => false, 'post' => 'Ya tienes registrado este curso.');
                    }
                }
            }
            echo json_encode($sms, JSON_UNESCAPED_UNICODE);
            sleep(3); 

            die();
    }
        //listar Alumnos
    public function listar(){
    
        $idDocente = $_SESSION['id'];         

        $data = $this->AlumnosModel->listarAlumnos( $idDocente);
        for ($i=0; $i < count($data); $i++) {                 
            $data[$i]->estado = '<span class="badge badge-success">Activo</span>';
                if( $_SESSION['rol'] == "Docente"){
                        $data[$i]->acciones = '<div>  
                        <button type="button" class="btn btn-info" onclick="verDetalle('.$data[$i]->id.');" title="Ver"><i class="far fa-eye">                 
                        </i></button>               
                        <button type="button" class="btn btn-primary" onclick="editarAlumno('.$data[$i]->id.');" title="Editar"><i class="fas fa-edit">                   
                        </i></button>  
                        <button type="button" class="btn btn-danger" onclick="eliminarAlumno('.$data[$i]->id.');" title="Eliminar"><i class="far fa-trash-alt">
                        </i></button>    
                       </div>';
                }               
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
          //listar para editar
    public function editar($id){
        $data = $this->AlumnosModel->getEditar($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
         //eliminar Alumnos
    public function deleteAlumno($id){
        $data = $this->AlumnosModel->deleteAlumno($id);
        if($data > 0){
                $sms = array('ok' => true, 'post' => 'El Alumno fue eliminado.');
        }else{
                $sms = array('ok' => false, 'post' => 'Error al eliminar el Alumno.');
        }
        echo json_encode($sms, JSON_UNESCAPED_UNICODE);
        die();
    }
    //ver detalles}
    public function getAlumno($id){
        $data = $this->AlumnosModel->verDetalle($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //buscar alumno por cedula
    public function buscarEstudiante($ced){

        $data = $this->AlumnosModel->getCedula($ced);
        if ( $data ) {            
          $msg = $data;            
        } else {
            $msg = ( array( 'ok'=>false, 'post' => 'No hay estudiante registrado con está cédula.' ) );
        }
        echo json_encode( $msg, JSON_UNESCAPED_UNICODE );
        die();
    }
   
}