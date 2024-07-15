<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){

        session_start();
        if(isset($_SESSION['activo'])){
            echo '<script>window.location.href="http://localhost/Asistencia_estudiantil/dashboard/administracion"</script>';				
        }
        parent::__construct();
        $this->load->model('LoginModel');
        $this->load->model('DocentesModel');
    }
    //vista login
	public function index()
	{
		$this->load->view('layout/login/login');
	}
    public function restaurar()
	{
		$this->load->view('layout/login/olvide_contraseña');
	}
    public function validar(){
        
        $rol = $this->input->post("perfil");
        $email = $this->input->post("email");
        $clave = $this->input->post("password");
        $pass = hash("SHA256", $clave);

        $data = $this->LoginModel->ValidarLogin($email,$rol);
        
        if(empty($data)){
            $msg = array('ok' => false, 'post' => 'Correo o perfil incorrecto.');
        }else{
            if($pass == $data[0]->clave){
              $token = bin2hex(random_bytes(16)); // Genera un token único de 32 caracteres en hexadecimal.
              //validamos si es estudiante el logueado para obtener su cédula
              if( $data[0]->rol == 'Estudiante'){
                $cedula = $this->LoginModel->getCedula($data[0]->idAlumno);
                $_SESSION['cedula'] = $cedula[0]->cedula;
                $_SESSION['id'] = $data[0]->idAlumno;

              }else{
                   $_SESSION['id'] = $data[0]->idDocente;
              }
              //almacenamos en variables de session para utilizar              
                $_SESSION['nombre'] = $data[0]->nombre;
                $_SESSION['rol'] = $data[0]->rol;
                $_SESSION['correo'] = $data[0]->correo;
                $_SESSION['activo'] = true;
               
                $msg = array('ok' => true, 'post' => 'Iniciando sesión.');
            }else{
                $msg = array('ok' => false, 'post' => 'La contraseña es incorrecta.');
            }        
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    
    }
    //cerrar sesion
    public function logout(){
  
        session_destroy();
        redirect("http://localhost/Asistencia_estudiantil/login");
    }
    //reseteando el password
    public function resetPass()
    {

      if($this->input->is_ajax_request()){

        if(empty($this->input->post('resetEmail'))){
          $resultados= array('status' =>false, 'msg' => 'Error de datos.');
        }else{
            $token = $this->DocentesModel->token();
            
            $strEmail = strtolower($this->LoginModel->strClean($this->input->post('resetEmail')));
            $datos = $this->LoginModel->getUserEmail($strEmail);

            if(empty($datos)){
              $resultados = array('status' =>false, 'msg' => 'Usuario no existente.');
            }else{
              
              if (!empty($datos[0]->idDocente)) {                
                   $id = $datos[0]->idDocente;            
                   $nombreUsuario = $datos[0]->nombre;
                   $url_recovery = base_url().'login/confirmUser/'.$strEmail.'/'.$token;    
                   $resultadoUpdate = $this->LoginModel->setTokenUser($id,$token);
              }else{
                    $id = $datos[0]->idAlumno;   
                    $nombreUsuario = $datos[0]->nombre;
                    $url_recovery = base_url().'login/confirmUser/'.$strEmail.'/'.$token;
                    $resultadoUpdate = $this->LoginModel->setTokenUserA($id,$token);
              }             
            
              $dataUsuario = array(
                'nombreUsuario' => $nombreUsuario,
                'email'         => $strEmail,
                'asunto'        =>'Recuperar cuenta',
                'url_recovery'  => $url_recovery,
                'empresa'       =>'Uniclaretiana',
                'web_empresa'   =>'http://localhost/Asistencia_estudiantil/login',
              );         

              if($resultadoUpdate){

                   $senEmail = $this->DocentesModel->sendEmail($dataUsuario,'email_cambioPassword');                

                        if($senEmail == true)
                        {                                       
                          $resultados = array('status' => true, 'post' => 'Se ha enviado un email a tu cuenta de correo para cambiar tu contraseña.');
                        }else{

                          $resultados = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta más tarde.');
                        }                
             
              }else{

                $resultados = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta más tarde.');
              }  
            }
        }     
          echo json_encode($resultados,JSON_UNESCAPED_UNICODE);	    
      }else{
        redirect('error');
      }
       die();
    }
     //confirmacion del token para cambio de contraseña
    public function confirmUser($params = "",$params1= "")
    {   
 
       if(empty($params) || empty($params1)){
        
           echo '<script>window.location.href="http://localhost/Asistencia_estudiantil/login"</script>';			
       }
       else
       {
         //explode convierte en un array la cadena y lo separamos por coma
         $arrParams = explode(',',$params);
         $arrParams1 = explode(',',$params1);
         $strEmail = $this->LoginModel->strClean($arrParams[0]);
         $strToken = $this->LoginModel->strClean($arrParams1[0]);
 
         $datos =  $this->LoginModel->getUsuario($strEmail,$strToken);       
        
         if(!empty($datos->idAlumno)){
          $id = $datos->idAlumno;
          }
          if(!empty($datos->idDocente)){
            $id = $datos->idDocente;  
          };
         if(empty($datos)){         
           echo '<script>window.location.href="http://localhost/Asistencia_estudiantil/login"</script>';			
         }
         else
         {           
           $data = array(
             "idDocente" => $id,
             "email" => $strEmail,
             "token" => $strToken,
           );             
           $this->load->view('layout/login/cambiar_Password',$data);
         }      
       } 
    }
    //validando los datos obtenidos y actulizamos la contraseña
    public function setPassword()
    {
      if($this->input->is_ajax_request()){

          if(empty($this->input->post('idDocente') || empty($this->input->post('strEmail')) || empty($this->input->post('strToken'))
          || empty($this->input->post('strPassword')) || empty($this->input->post('strPasswordConfirm')))){

              $resultados = array('status' => false, 'msg' => 'Error de datos.');
          }else{

                  $idpersona = intval($this->input->post('idDocente'));
                  $email     = strtolower( $this->LoginModel->strClean($this->input->post('strEmail')));
                  $password  =  $this->LoginModel->strClean($this->input->post('strPassword'));
                  $passwordConfirm  =  $this->LoginModel->strClean($this->input->post('strPasswordConfirm'));
                  $token     =  $this->LoginModel->strClean($this->input->post('strToken'));              
                 
                  if($password != $passwordConfirm){
                     $resultados = array('status' => false, 'msg' => 'Las contraseñas no son iguales.');
                  }else{
                       $datos =  $this->LoginModel->getUsuario($email,$token); 
                      if(empty($datos))
                      {
                          $resultados = array('status' => false, 'msg' => 'Error de datos.');
                      }else{
                          if(!empty($datos->idAlumno)){
                              $id = array('idAlumno'=> $datos->idAlumno);
                          }
                          if(!empty($datos->idDocente)){
                             $id = array('idDocente' => $datos->idDocente);  
                          };
                          $strPassword = hash("SHA256", $password);
                          $resultPassword = $this->LoginModel->insertPassword($id, $strPassword);
                       
                          if($resultPassword){
                            $resultados = array('status' => true, 'post' => 'Contraseña actualizada con éxito.');

                          }else{
                              $resultados = array('status' => false, 'msg' => 'No es posible realizar el proceso, intentelo más tarde.');

                          }
                      }           
               }         
          }
          echo json_encode($resultados ,JSON_UNESCAPED_UNICODE);	 
      }else{
        redirect("error");
      }  
      die();
    }
}