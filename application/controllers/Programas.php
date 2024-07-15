<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Programas extends CI_Controller {

    public function __construct(){
       
        session_start();
        if(empty($_SESSION['activo'])){
            echo '<script>window.location.href="http://localhost/Asistencia_estudiantil/login"</script>';				
        }
        parent:: __construct();
        $this->load->model('MateriasModel');
        $this->load->model('DocentesModel');
        $this->load->model('DashboardModel');

    }    
    //vista materias
	public function Vista()
	{
        $data['docentes'] = $this->DashboardModel->contarDocentes();
        $data['alumnos'] = $this->DashboardModel->contarAlumnos();
        $data['cursos'] = $this->DashboardModel->contarCursos();
        $data['programas'] = $this->DashboardModel->contarProgramas();

        $data['suma'] = $data['docentes'] + $data['alumnos'] + $data['cursos']+ $data['programas'] ;
		$this->load->view('layout/template/header',$data);
        $this->load->view('layout/template/aside');
        $this->load->view('layout/materias/materias');
        $this->load->view('layout/template/footer');
	}
    //registrar materias
    public function registrar(){

        $materia = $this->input->post("materia");
        $id = $this->input->post("idMateria");

        if(empty($materia)){
            $sms = array('ok' => false, 'post' => 'El campo es obligatorio.');
        }else{
            if(empty($id)){
                $data = $this->MateriasModel->registerMaterias($materia);

                if($data){
                    $sms = array('ok' => true, 'post' => 'Registro exitoso.');
                }else{
                    $sms = array('ok' => false, 'post' => 'Ya existe un programa registrado con este nombre.');
                }
            }else{
                $data = $this->MateriasModel->updateMateria($materia,$id);
                if($data){
                    $sms = array('ok' => true, 'post' => 'Actualizado exitoso.');
                }else{
                    $sms = array('ok' => false, 'post' => 'Error al actualizar el programa.');
                }
            }
        }
        echo json_encode($sms, JSON_UNESCAPED_UNICODE);
        die();
    }
    //listar
    public function listar(){

        $data = $this->MateriasModel->listar();

        for ($i=0; $i < count($data); $i++) {                 
           $data[$i]->estado = '<span class="badge badge-success">Activo</span>';
               if( $_SESSION['rol'] == "Admin"){
                    $data[$i]->acciones = '<div>            
                    <button type="button" class="btn btn-primary" onclick="editarMateria('.$data[$i]->id.');" title="Editar"><i class="fas fa-edit">
                    
                    </i></button>   
                    <button type="button" class="btn btn-danger" onclick="eliminarMateria('.$data[$i]->id.');" title="Eliminar"><i class="far fa-trash-alt">
                    
                    </i></button>    
                   </div>';
                }                
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //listar para editar
    public function editar($id){
        $data = $this->MateriasModel->getEditar($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //eliminar materias
    public function deleteMateria($id){
        $data = $this->MateriasModel->deletePrograma($id);

        if($data > 0){
            $sms = array('ok' => true, 'post' => 'El Programa fue eliminado.');

        }else{
            $sms = array('ok' => false, 'post' => 'Error al eliminar el programa.');

        }
        echo json_encode($sms, JSON_UNESCAPED_UNICODE);
        die();
    }
    //vistar asignar
    public function vistaAsignar()
	{
        $data['program'] = $this->MateriasModel->listar();
        $data['docent'] = $this->DocentesModel->listar();
        $data['curso'] = $this->MateriasModel->listarCursos();
        $data['docentes'] = $this->DashboardModel->contarDocentes();
        $data['alumnos'] = $this->DashboardModel->contarAlumnos();
        $data['cursos'] = $this->DashboardModel->contarCursos();
        $data['programas'] = $this->DashboardModel->contarProgramas();
        $data['suma'] = $data['docentes'] + $data['alumnos'] + $data['cursos']+ $data['programas'] ;

		$this->load->view('layout/template/header',$data);
        $this->load->view('layout/template/aside');
        $this->load->view('layout/materias/asignar',$data);
        $this->load->view('layout/template/footer');
	}
    //asignar programa
    public function AsignarPrograma(){

        $id_materia = $this->input->post("id_materia");
        $id_docentes = $this->input->post("id_docentes");
        $semestre = $this->input->post("semestre");
        $id = $this->input->post("idAsignar");
        $idCurso = $this->input->post("idCurso");
        $idJefe = $_SESSION['id'];

        if(empty($id_materia) || empty($id_docentes) || empty($semestre) || empty( $idCurso )){
            $sms = array('ok' => false, 'post' => 'Todos los campos son obligatorios.');
        }else{
            if(empty($id)){
                $data = $this->MateriasModel->asignarPrograma(  $idJefe ,$id_materia, $id_docentes, $semestre, $idCurso );
                if($data){
                    $sms = array('ok' => true, 'post' => 'Registro exitoso.');
                }else{
                    $sms = array('ok' => false, 'post' => 'El docente ya tiene asignado este curso.');
                }
            }else{

                $data = $this->MateriasModel->updatePrograma(  $idJefe ,$id_materia, $id_docentes, $semestre,$idCurso ,$id);

                if($data){
                    $sms = array('ok' => true, 'post' => 'Al docente se le actualizado la asignación.');

                }else{
                    $sms = array('ok' => false, 'post' => 'No se puede actualizar, porque este curso ya está asignado a otro docente.');
                }
            }
        }
        echo json_encode($sms, JSON_UNESCAPED_UNICODE);
        die();
    }
    //listar programas asignados
    public function listarAsignacion(){
        $data = $this->MateriasModel->listarAsignados();
        for ($i=0; $i < count($data); $i++) {     
            $data[$i]->nombre = $data[$i]->nombre.' '.$data[$i]->apellidos;            
           $data[$i]->estado = '<span class="badge badge-success">Asignado</span>';
               if( $_SESSION['rol'] == "Jefe"){
                    $data[$i]->acciones = '<div>            
                    <button type="button" class="btn btn-primary" onclick="editarAsignado('.$data[$i]->id.');" title="Editar"><i class="fas fa-edit">
                    edit
                    </i></button>   
                    <button type="button" class="btn btn-danger" onclick="eliminarAsignado('.$data[$i]->id.');" title="Eliminar"><i class="far fa-trash-alt">
                    delete
                    </i></button>    
                   </div>';
                }               
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //eliminar asignacion
    public function deleteAsignacion($id){
        $data = $this->MateriasModel->deleteAsignacion($id);

        if($data > 0){
            $sms = array('ok' => true, 'post' => 'El Programa fue eliminado.');

        }else{
            $sms = array('ok' => false, 'post' => 'Error al eliminar el programa.');

        }
        echo json_encode($sms, JSON_UNESCAPED_UNICODE);
        die();
    }
    //editar asignacion 
    public function editarAsignacion($id){
        $data = $this->MateriasModel->getEditarAsignacion($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
      //vistar cursos
    public function cursos_()   
    {  
        $data['docentes'] = $this->DashboardModel->contarDocentes();
        $data['alumnos'] = $this->DashboardModel->contarAlumnos();
        $data['cursos'] = $this->DashboardModel->contarCursos();
        $data['programas'] = $this->DashboardModel->contarProgramas();
        $data['suma'] = $data['docentes'] + $data['alumnos'] + $data['cursos']+ $data['programas'] ;
          $this->load->view('layout/template/header',$data);
          $this->load->view('layout/template/aside');
          $this->load->view('layout/materias/cursos');
          $this->load->view('layout/template/footer');
    }
    //listar cursos
    public function listarCursos(){

        $data = $this->MateriasModel->listarCursos();

        for ($i=0; $i < count($data); $i++) {                 
           $data[$i]->estado = '<span class="badge badge-success">Activo</span>';
               if( $_SESSION['rol'] == "Admin"){
                    $data[$i]->acciones = '<div>            
                    <button type="button" class="btn btn-primary" onclick="editarCurso('.$data[$i]->id.');" title="Editar"><i class="fas fa-edit">
                    
                    </i></button>   
                    <button type="button" class="btn btn-danger" onclick="eliminarCurso('.$data[$i]->id.');" title="Eliminar"><i class="far fa-trash-alt">
                    
                    </i></button>    
                   </div>';
                }                
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
        //registrar cursos
    public function registrarCursos(){

            $curso = $this->input->post("curso");
            $id = $this->input->post("idCurso");
    
        if(empty($curso)){
                $sms = array('ok' => false, 'post' => 'El campo es obligatorio.');
        }else{
            if(empty($id)){
                    $data = $this->MateriasModel->registerCurso($curso);
                if($data){
                        $sms = array('ok' => true, 'post' => 'Registro exitoso.');
                }else{
                        $sms = array('ok' => false, 'post' => 'Ya existe un curso registrado con este nombre.');
                }
            }else{
                    $data = $this->MateriasModel->updateCurso($curso,$id);
                if($data){
                        $sms = array('ok' => true, 'post' => 'Actualizado exitoso.');
                }else{
                        $sms = array('ok' => false, 'post' => 'Error al actualizar el curso.');
                }
            }
        }
            echo json_encode($sms, JSON_UNESCAPED_UNICODE);
            die();
    }
    //editar curso
    public function editarCurso($id){
        $data = $this->MateriasModel->getEditarCurso($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
     //eliminar cursos
    public function deleteCurso($id){
        $data = $this->MateriasModel->deleteCurso($id);

        if($data > 0){
            $sms = array('ok' => true, 'post' => 'El Curso fue eliminado.');
        }else{
            $sms = array('ok' => false, 'post' => 'Error al eliminar el curso.');
        }
        echo json_encode($sms, JSON_UNESCAPED_UNICODE);
        die();
    }

}