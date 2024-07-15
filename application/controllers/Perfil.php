<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends CI_Controller {

    public function __construct(){
       
        session_start();
        if(empty($_SESSION['activo'])){
            echo '<script>window.location.href="http://localhost/Asistencia_estudiantil/login"</script>';				
        }
        parent:: __construct();
        $this->load->model('DashboardModel');
    }
    //peril
	public function Vista()
	{
        $id = $_SESSION['id'];  
        $data['perfil'] = $this->DashboardModel->getPerfil($id);
        $data['docentes'] = $this->DashboardModel->contarDocentes();
        $data['alumnos'] = $this->DashboardModel->contarAlumnos();
        $data['cursos'] = $this->DashboardModel->contarCursos();
        $data['programas'] = $this->DashboardModel->contarProgramas();

        $data['suma'] = $data['docentes'] + $data['alumnos'] + $data['cursos']+ $data['programas'] ;

		$this->load->view('layout/template/header',$data);
        $this->load->view('layout/template/aside');
        $this->load->view('layout/perfil/perfil',$data);
        $this->load->view('layout/template/footer');
	}
    //mas detalles del perfil
    public function masDetalles($id){

        $data = $this->DashboardModel->getPerfilAlumno( $id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();

    }
    //update perfil
    public function updatePerfil(){
           $id = $this->input->post("id");
           $correo = $this->input->post("correo");
           $telefono = $this->input->post("telefono");
           $direccion = $this->input->post("direccion");
           $clave = $this->input->post("clave");
           $idClave = $this->input->post("idClave");
           $perfil = $this->input->post("perfil");
           $pass = hash("SHA256", $clave);

           if($clave == ""){
            $clave = $idClave;
            $data = $this->DashboardModel->updatePerfil( $perfil, $correo, $telefono, $direccion, $clave ,$id);

            if($data){
                $sms = array('ok' => true, 'post' => 'Actualizado exitoso.');
            }else{
                $sms = array('ok' => false, 'post' => 'Error al actualizar.');
            }
           }else{
            $data = $this->DashboardModel->updatePerfil($perfil,  $correo, $telefono, $direccion, $pass ,$id);
            if($data){
                $sms = array('ok' => true, 'post' => 'Actualizado exitoso.');
            }else{
                $sms = array('ok' => false, 'post' => 'Error al actualizar.');
            }
           }
           echo json_encode($sms, JSON_UNESCAPED_UNICODE);
           die();

    }

}
