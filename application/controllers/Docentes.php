<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Docentes extends CI_Controller {

    public function __construct(){
       
        session_start();
        if(empty($_SESSION['activo'])){
            echo '<script>window.location.href="http://localhost/Asistencia_estudiantil/login"</script>';				
        }
        parent:: __construct();
        $this->load->model('DocentesModel');
        $this->load->model('DashboardModel');
        $this->load->model('DashboardModel');
        $this->load->model('MateriasModel');
    }
    
//vista docente
	public function Vista()
	{
        $data['docentes'] = $this->DashboardModel->contarDocentes();
        $data['alumnos'] = $this->DashboardModel->contarAlumnos();
        $data['cursos'] = $this->DashboardModel->contarCursos();
        $data['programas'] = $this->DashboardModel->contarProgramas();
        $data['suma'] = $data['docentes'] + $data['alumnos'] + $data['cursos']+ $data['programas'] ;

        $data['cedula']= $this->DocentesModel->listarCedula();
		$this->load->view('layout/template/header',$data);
        $this->load->view('layout/template/aside');
        $this->load->view('layout/docentes/docente',$data);
        $this->load->view('layout/template/footer');
	}
     //registrar Docentes
    public function registrar(){

   
        $nombre = $this->input->post("nombre");
        $apellidos = $this->input->post("apellidos");
        $cedula = $this->input->post("cedula");
        $telefono = $this->input->post("telefono");
        $direccion = $this->input->post("direccion");
        $correo = $this->input->post("correo");
        $id = $this->input->post("idDocente");
        $id_materia = null;
        if(!empty($this->input->post("id_materia"))){
            $id_materia = $this->input->post("id_materia");
            $perfil = "Jefe";
        }else{
              $perfil = "Docente";
        }      
   

        $password = empty($this->input->post("clave")) ? $this->DashboardModel->passGenerator():  $this->input->post("clave");
        $pass = hash("SHA256", $password);

        if(empty($nombre) ||empty($apellidos) || empty($apellidos) ||empty($cedula)||empty($telefono) ||empty($direccion) || empty($correo)){
            $sms = array('ok' => false, 'post' => 'Todos los campo son obligatorios.');
        }else{
            if(empty($id)){

                $data = $this->DocentesModel->registerDocente($nombre,$apellidos,$cedula,$telefono, $direccion,$correo,$perfil,$pass,$id_materia );
                if($data){
                    $sms = array('ok' => true, 'post' => 'Registro exitoso.');
                    $nombreUsuario = $nombre.' '.$apellidos;
                    $dataUsuario = array(
                    'nombreUsuario' => $nombreUsuario,
                    'email'         =>$correo,
                    'password'      =>$password,
                    'asunto'        =>'Bienvenido al sistema de asistencia de la uniclaretiana',                             
                   
                    );
                    $this->DocentesModel->sendEmail($dataUsuario,'email_bienvenida');
                }else{
                    $sms = array('ok' => false, 'post' => 'Ya hay un docente registrado con está cédula o correo.');
                }
            }else{
                $data = $this->DocentesModel->updateDocente($nombre,$apellidos,$cedula,$telefono, $direccion,$correo,$perfil,$pass,$id,$id_materia);

                if($data){
                    $sms = array('ok' => true, 'post' => 'Actualizado exitoso.');
                    $nombreUsuario = $nombre.' '.$apellidos;
                    $dataUsuario = array(
                    'nombreUsuario' => $nombreUsuario,
                    'email'         =>$correo,
                    'password'      =>$password,
                    'asunto'        =>'Has solicitado actualización de tus datos',                              
                   
                    );
                    $this->DocentesModel->sendEmailUpdate($dataUsuario,'email_actualizacion');

                }else{
                    $sms = array('ok' => false, 'post' => 'Error al actualizar el docente.');
                }
            }
        }
        echo json_encode($sms, JSON_UNESCAPED_UNICODE);
        sleep(3); 

        die();
    }
    //listar docentes
    public function listar(){

        $data = $this->DocentesModel->listar();

        for ($i=0; $i < count($data); $i++) {                 
           $data[$i]->estado = '<span class="badge badge-success">Activo</span>';
               if( $_SESSION['rol'] == "Jefe"){
                    $data[$i]->acciones = '<div>            
                    <button type="button" class="btn btn-info" onclick="verDetalleD('.$data[$i]->id.');" title="Ver"><i class="far fa-eye">                 
                    </i></button>  
                    <button type="button" class="btn btn-primary" onclick="editarDocente('.$data[$i]->id.');" title="Editar"><i class="fas fa-edit">              
                    </i></button>   
                    <button type="button" class="btn btn-danger" onclick="eliminarDocente('.$data[$i]->id.');" title="Eliminar"><i class="far fa-trash-alt">
                    </i></button>    
                   </div>';
                }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
        //listar JEFE
    public function listarJ(){

            $data = $this->DocentesModel->listarJ();
    
            for ($i=0; $i < count($data); $i++) {                 
               $data[$i]->estado = '<span class="badge badge-success">Activo</span>';
                   if( $_SESSION['rol'] == "Admin"){
                        $data[$i]->acciones = '<div>             
                        <button type="button" class="btn btn-primary" onclick="editarJefe('.$data[$i]->id.');" title="Editar"><i class="fas fa-edit">              
                        </i></button>   
                        <button type="button" class="btn btn-danger" onclick="eliminarJefe('.$data[$i]->id.');" title="Eliminar"><i class="far fa-trash-alt">
                        </i></button>    
                       </div>';
                    }
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
    }
      //listar para editar
    public function editar($id){
        $data = $this->DocentesModel->getEditar($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

     //eliminar docentes
    public function deleteDocente($id){
        $data = $this->DocentesModel->deleteDocente($id);
        if($data > 0){
            $sms = array('ok' => true, 'post' => 'Eliminado.');
        }else{
            $sms = array('ok' => false, 'post' => 'Error al eliminar el docente.');
        }
        echo json_encode($sms, JSON_UNESCAPED_UNICODE);
        die();
    }
       //ver detalles}
    public function getDocente($id){
   
        $data['docente'] = $this->DocentesModel->verDetalle($id);
        header('Content-Type: application/json');
        echo json_encode($data['docente'], JSON_UNESCAPED_UNICODE);
    }
        //vista jefe de programa
      //vista materias
	public function vistaJefe()
	{
        $data['docentes'] = $this->DashboardModel->contarDocentes();
        $data['alumnos'] = $this->DashboardModel->contarAlumnos();
        $data['cursos'] = $this->DashboardModel->contarCursos();
        $data['programas'] = $this->DashboardModel->contarProgramas();
        $data['progra'] = $this->MateriasModel->programas();
        $data['cedulaJ']= $this->DocentesModel->listarCedulaJ();
        $data['suma'] = $data['docentes'] + $data['alumnos'] + $data['cursos']+ $data['programas'] ;
		$this->load->view('layout/template/header',$data);
        $this->load->view('layout/template/aside');
        $this->load->view('layout/docentes/jefe_programa',$data);
        $this->load->view('layout/template/footer');
	}
    //buscar alumnos relacionado al id del curso del docente
    public function buscarEstudiante($id){
        $data = $this->DocentesModel->buscarEstudiantesPorDocente($id);
        for ($i=0; $i < count($data); $i++) {                 
            $data[$i]->estado = '<span class="badge badge-success">Activo</span>';
                if( $_SESSION['rol'] == "Jefe"){
                     $data[$i]->acciones = '<div>             
                     <button type="button" disabled="" class="btn btn-primary" onclick="editarJefe('.$data[$i]->id.');" title="Editar"><i class="fas fa-edit">              
                     </i></button>   
                     <button type="button" disabled=""  class="btn btn-danger" onclick="eliminarJefe('.$data[$i]->id.');" title="Eliminar"><i class="far fa-trash-alt">
                     </i></button>    
                    </div>';
                 }
         }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

}