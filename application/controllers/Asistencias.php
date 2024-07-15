<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asistencias extends CI_Controller {

    public function __construct(){
       
        session_start();
        if(empty($_SESSION['activo'])){
            echo '<script>window.location.href="http://localhost/Asistencia_estudiantil/login"</script>';				
        }
        parent:: __construct();
        $this->load->model('DashboardModel');
        $this->load->model('MateriasModel');
        $this->load->model('AsistenciasModel');
        $this->load->model('DocentesModel');
        $this->load->model('AlumnosModel');
        // Cargar el helper cookie
        $this->load->helper('cookie');
    }
    //vista de habilitar asistencia
	public function Vista()
	{
        $idDocente = $_SESSION['id'];
        $asistencia_habilitada = $this->AsistenciasModel->habilitada($idDocente);
       //si no hay asistencia habilitada crea la asistencia false para que el boton se deshabilite de lo contrario lo habilita
        if(empty($asistencia_habilitada)){
            $cookie_datos = array(
                'asistencia_habilitada' => false,                                              
            );
            $tiempo_actual = time();
            //  // Establece el tiempo de duración deseado en segundos (por ejemplo, 30 minutos).
             $duracion_segundos = 60 * 60; // 30 minutos             
            $this->input->set_cookie('asistencia_info', json_encode($cookie_datos),$duracion_segundos);
        }else{

            $cookie_datos = array(
                'asistencia_habilitada' => true,                                              
            );
            $tiempo_actual = time();
            //  // Establece el tiempo de duración deseado en segundos (por ejemplo, 30 minutos).
             $duracion_segundos = 60 * 60; // 30 minutos             
            $this->input->set_cookie('asistencia_info', json_encode($cookie_datos),$duracion_segundos);
             
        }  
        $data['program'] = $this->MateriasModel->listar();
        $data['curs'] = $this->MateriasModel->listarCursos();
        $data['program'] = $this->MateriasModel->listarP($idDocente);
        $data['curs'] = $this->MateriasModel->listarC($idDocente);
        $data['semestre'] = $this->MateriasModel->listarS($idDocente);

        $data['docentes'] = $this->DashboardModel->contarDocentes();
        $data['alumnos'] = $this->DashboardModel->contarAlumnos();
        $data['cursos'] = $this->DashboardModel->contarCursos();
        $data['programas'] = $this->DashboardModel->contarProgramas();
        

        $data['suma'] = $data['docentes'] + $data['alumnos'] + $data['cursos']+ $data['programas'] ;
		$this->load->view('layout/template/header',$data);
        $this->load->view('layout/template/aside');
        $this->load->view('layout/asistencia/habilitar_asistencia_view',$data);
        $this->load->view('layout/template/footer');
	}
 //habilitar vista
    public function habilitar()
	{
          // Verifica si la cookie con la información del docente está presente.
        if (isset($_SESSION['id'])) {
            date_default_timezone_set('America/Bogota');

            // Obtiene el ID del docente y el token desde la información almacenada en la cookie.
            $idDocente = $_SESSION['id'];
            $fecha = date('Y-m-d H:i:s');
           
            $id_materia =$this->input->post('id_materia');
            $idCurso =$this->input->post('idCurso');
            $semestre =$this->input->post('semestre');
            $idHabilitado =$this->input->post('deshabilitar');
    
            //validamos si tiene ya asignado el programa, curso y semestre
            $datos = $this->AsistenciasModel->asignacion($id_materia,$semestre,$idCurso,$idDocente);
    
            if(empty($this->input->post('id'))){
               if(!empty($datos)){
                      if ($datos[0]->semestre == $semestre && $datos[0]->idMateria == $id_materia &&
                     $datos[0]->idCurso == $idCurso) {  
                //validar si tiene asignado    
                    $resp = $this->AsistenciasModel->programa($id_materia,$semestre,$idCurso,$idDocente);
                        if(!empty($resp)){

                            //validar si ya se encuentrahabilitado
                            $data = $this->AsistenciasModel->validarHabilitado($idDocente);
                                if(empty($data)){
                                    $resp = $this->AsistenciasModel->habilitarAsistencia($id_materia,$semestre,$idCurso,$idDocente,$fecha);
                                
                                    if($resp){                                
                                        // Obtiene el tiempo actual en segundos (timestamp).
                                        $tiempo_actual = time();
                                        // Establece el tiempo de duración deseado en segundos (por ejemplo, 30 minutos).
                                        $duracion_segundos = 60 * 60; // 30 minutos
                                        //  // Datos que deseas almacenar en la cookie.
                                        $cookie_datos = array(
                                            'asistencia_habilitada' => true,                                                                       
                                        );
                                        $_SESSION['id_materia'] = $id_materia;
                                        $_SESSION['idCurso'] = $idCurso;
                                        $_SESSION['semestre'] = $semestre; 
                                        // Almacena los datos en la cookie utilizando la función set_cookie de CodeIgniter.
                                        $this->input->set_cookie('asistencia_info', json_encode($cookie_datos),$duracion_segundos);

                                        //  $this->AsistenciasModel->setToken($id_materia,$idCurso,$semestre,$idDocente,$docente_token);
                                            $msg = array('ok' => true, 'post'=> 'Asistencia habilitado');
                                        }else{
                                            $msg = array('ok' => false, 'post'=> 'Se produjo un errorr');
                                        }                
                                }else{
                                    $msg = array('ok' => false, 'post'=> 'Ya está habilitado la vista asistencias.');
                                }
                            }                    
                        }
                }else{
                    $msg = array('ok' => false, 'post'=> 'No tiene asignación de programa con los datos seleccionados.');

                }   
                 
            }else{
                
                           
                $idDocente = $_SESSION['id'];
                $data = $this->AsistenciasModel->validarHabilitado($idDocente);
                $id_materia = isset($data[0]->idPrograma) ?  $data[0]->idPrograma : null;
                $idCurso = isset($data[0]->idCurso) ?  $data[0]->idCurso : null;
                $semestre = isset($data[0]->semestre) ?  $data[0]->semestre : null;

                    $resp = $this->AsistenciasModel->deshabilitarAsistencia($id_materia,$semestre,
                    $idCurso, $idDocente);
                    if($resp){
                        //obtenemos todos los alumnos registrado en ese semestre y curso
                        $alumnosSinAsistencia = $this->AsistenciasModel->getAlumnosSinAsistencia($idCurso, $semestre);                    
                        $fechaActual = date('Y-m-d H:i:s');

                            foreach ($alumnosSinAsistencia as $alumno) {
                               $idAlumno = $alumno->id;
                               //se valida cada alumno si tiene asistencia registrada
                               $asistenciaExistente = $this->AsistenciasModel->validarFechaRegistro($idAlumno,$idCurso, $semestre);

                              //si no asistencia del alumno registrado se registra como ausente y se envia un correo
                                if(empty($asistenciaExistente)){
                                    $this->AsistenciasModel->registrarAusente($idDocente, $idAlumno, $idCurso, $semestre,$id_materia, $fechaActual);
                                    $to = $alumno->correo;
                                    $subject = 'Notificación de Ausencia de Asistencia';
                                    $message = 'Estimado alumno,<br><br>Le informamos que usted ha sido registrado como ausente en la última sesión de asistencia<br>
                                    <br><strong>Curso:</strong> '.$alumno->curso.'<br>
                                    <br>Atentamente,<br>La Administración';                
                        
                                    $this->DocentesModel->sendEmailAusencia($to, $subject, $message);
                                }        
                         
                            } ;
                        // foreach ($alumnosSinAsistencia as $alumno) {
                        //     $this->AsistenciasModel->registrarAusente($idDocente, $alumno->id, $idCurso, $semestre,$id_materia, $fechaActual);
                      
                        //     $to = $alumno->correo;
                        //     $subject = 'Notificación de Ausencia de Asistencia';
                        //     $message = 'Estimado alumno,<br><br>Le informamos que usted ha sido registrado como ausente en la última sesión de asistencia<br>
                        //     <br><strong>Curso:</strong> '.$alumno->curso.'<br>
                        //     <br>Atentamente,<br>La Administración';                
                
                        //     $this->DocentesModel->sendEmailAusencia($to, $subject, $message);
                        // }
                
                        delete_cookie('asistencia_info');
                        $msg = array('ok' => true, 'post'=> 'Asistencia deshabilitado');
                    }else{
                        $msg = array('ok' => false, 'post'=> 'Se produjo un error');
                    }                
                
            }                
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            sleep(3); 
            die();
            // Resto del código para habilitar o deshabilitar la vista de asistencia...
        } else {
            // La cookie no está presente o ha expirado.
            // Puedes redireccionar a la página de inicio de sesión o mostrar un mensaje de que la sesión ha expirado.
            echo '<script>window.location.href="http://localhost/Asistencia_estudiantil/login"</script>';				

        }
        
	}
    //si caduca los cookie esta funcion es llamada automaticamente para actualizar la base de datos  
    private function procesarCookieCaducado($cookie_data) {

        $cookie_data = json_decode($_COOKIE['asistencia_info'], true);
        $asistencia_habilitada = $cookie_data['asistencia_habilitada'];
        $id_materia = $_SESSION['id_materia'];
        $idCurso = $_SESSION['idCurso'];
        $semestre = $_SESSION['semestre'];
            
        $idDocente = isset($_SESSION['id']) ? $_SESSION['id'] : null;
       // Guarda los datos en la base de datos y realiza las actualizaciones necesarias.
        $resp = $this->AsistenciasModel->deshabilitarAsistencia($id_materia,$semestre,
        $idCurso, $idDocente);
            if($resp){
           
                setcookie('asistencia_info', '', time() - 3600);
                $msg = array('ok' => true, 'post'=> 'Asistencia deshabilitado');
            }else{
                $msg = array('ok' => false, 'post'=> 'Se produjo un error');
            }
    }
    //vista marcar asistencia
    public function asistenciasHabilitada($idCurso) {

        $data['estudiantes'] = $this->AlumnosModel->getProgramas($idCurso);      
        if (!empty($data)) {
    
             if (!empty($this->AsistenciasModel->getCursoHabilitado($idCurso))){
                $data['docentes'] = $this->DashboardModel->contarDocentes();
                $data['alumnos'] = $this->DashboardModel->contarAlumnos();
                $data['cursos'] = $this->DashboardModel->contarCursos();
                $data['programas'] = $this->DashboardModel->contarProgramas();
    
                $data['suma'] = $data['docentes'] + $data['alumnos'] + $data['cursos'] + $data['programas'];
                // Cargar la vista asistencia_view.php con los datos de los estudiantes.
                $this->load->view('layout/template/header', $data);
                $this->load->view('layout/template/aside');
                $this->load->view('layout/asistencia/asistencia_view', $data);
                $this->load->view('layout/template/footer');
             
             }else {
                    echo '<script>window.location.href="http://localhost/Asistencia_estudiantil/asistencia/curso"</script>';
            }            
        } else {
              echo '<script>window.location.href="http://localhost/Asistencia_estudiantil/asistencia/curso"</script>';
        }
    }
    //accion marcar
    public function marcar() {

        $lat = $this->input->post('lat');
        $lng = $this->input->post('lng');
        $cedula = $this->input->post('cedula');
        $idDocente = $this->input->post('idDocente');
        $id = $_SESSION['id'];
        $idCurso = $this->input->post('idCurso');
        $idMateria = $this->input->post('idMateria');
        $semestre = $this->input->post('semestre');  
        date_default_timezone_set('America/Bogota');    
        $fecha = date('Y-m-d');
        $coordenadas = $this->DashboardModel->getCoordenadas();

        // Coordenadas de la ubicación deseada (Calle 23 11-11, Quibdó, Chocó, Colombia)
        $lat_deseada = $coordenadas[0]->latitud;
        $lng_deseada = $coordenadas[0]->longitud;

      //coordenada utch
        // $lat_deseada = 5.681879262541283;
        // $lng_deseada = -76.64704688313309;
    
        //direccion fucla
        // $lat_deseada = 5.685391656357563;
        // $lng_deseada = -76.66022005226155;
        // Simplemente como ejemplo, aquí asumimos que la ubicación es válida si está cerca de la dirección deseada.
        $distancia_maxima_aceptable = 0.01; // Ajusta esta distancia según tus necesidades
    
        $distancia = sqrt(($lat - $lat_deseada) ** 2 + ($lng - $lng_deseada) ** 2);
 
        if ($distancia <= $distancia_maxima_aceptable) {

            if($_SESSION['cedula'] == $cedula){
                  // Aquí puedes realizar la operación para marcar la asistencia en la base de datos y guardar la fecha, nombre del estudiante, etc.          
                $resp = $this->AsistenciasModel->setAsistencia($idDocente,$id,$idMateria,$idCurso,$semestre,$fecha);

                if($resp){
                    $msg = array('ok' => true, 'post' => 'Asistencia marcada con exito.');
                }else{
                    $msg = array('ok' => false, 'post' => 'Ya hay una asistencia registrada el día de hoy.');
                }
            }else{
                $msg = array('ok' => false, 'post' => 'No puedes marcar esta asistencia.');
            }      
        } else {
            $msg = array('ok' => false, 'post' => 'Solo puedes marcar asistencia dentro del plantel educativo.');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        sleep(3); 
        die();
    }
    //vista cursos
    public function asistenciasCursos() {

        // Obtiene el ID del docente y el token desde la información almacenada en la cookie.
        $idEstudiante = $_SESSION['id'];
        $data['Cursos'] = $this->DocentesModel->getProgramas($idEstudiante);

                $data['docentes'] = $this->DashboardModel->contarDocentes();
                $data['alumnos'] = $this->DashboardModel->contarAlumnos();
                $data['cursos'] = $this->DashboardModel->contarCursos();
                $data['programas'] = $this->DashboardModel->contarProgramas();
    
                $data['suma'] = $data['docentes'] + $data['alumnos'] + $data['cursos'] + $data['programas'];
                // Cargar la vista asistencia_view.php con los datos de los estudiantes.
                $this->load->view('layout/template/header', $data);
                $this->load->view('layout/template/aside');
                $this->load->view('layout/asistencia/asistencia', $data);
                $this->load->view('layout/template/footer');
                return;

    }
    //listar asistencias
    public function asistenciasMarcadas(){

        $data['docentes'] = $this->DashboardModel->contarDocentes();
        $data['alumnos'] = $this->DashboardModel->contarAlumnos();
        $data['cursos'] = $this->DashboardModel->contarCursos();
        $data['programas'] = $this->DashboardModel->contarProgramas();        

        $data['suma'] = $data['docentes'] + $data['alumnos'] + $data['cursos']+ $data['programas'] ;
		$this->load->view('layout/template/header',$data);
        $this->load->view('layout/template/aside');
        $this->load->view('layout/asistencia/listarAsistencias');
        $this->load->view('layout/template/footer');
    }
      //listar asistencias marcadas
      public function listar(){

        $idDocente = $_SESSION['id'];      
        $data = $this->AsistenciasModel->listarAsistencias($idDocente);
        for ($i=0; $i < count($data); $i++) {  

            if($data[$i]->asistencia == 'registrada'){
                $data[$i]->estado = '<span class="badge badge-success">registrada</span>';        

            }else{
                $data[$i]->estado = '<span class="badge badge-danger">ausente</span>';  
            }             
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();;
    }
    //asistencias marcadas
    public function asistenciasMarcadasA(){
        $data['docentes'] = $this->DashboardModel->contarDocentes();
        $data['alumnos'] = $this->DashboardModel->contarAlumnos();
        $data['cursos'] = $this->DashboardModel->contarCursos();
        $data['programas'] = $this->DashboardModel->contarProgramas();        

        $data['suma'] = $data['docentes'] + $data['alumnos'] + $data['cursos']+ $data['programas'] ;
		$this->load->view('layout/template/header',$data);
        $this->load->view('layout/template/aside');
        $this->load->view('layout/asistencia/asistenciasMarcadas');
        $this->load->view('layout/template/footer');
    }
      //listar asistencias marcadas alumnos
      public function listarA(){

        $idEstudiante = $_SESSION['id'];      
        $data = $this->AsistenciasModel->listarAsistenciasA($idEstudiante);
        for ($i=0; $i < count($data); $i++) {                 
            if($data[$i]->asistencia == 'registrada'){
                $data[$i]->estado = '<span class="badge badge-success">registrada</span>';        

            }else{
                $data[$i]->estado = '<span class="badge badge-danger">ausente</span>';  
            }          
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();;
    }
     //buscar asistencia por curso 
     public function buscarAsistencia($id){
        $data = $this->AsistenciasModel->buscarAsistenciasA($id);

        for ($i=0; $i < count($data); $i++) {                 
            if($data[$i]->asistencia == 'registrada'){
                $data[$i]->estado = '<span class="badge badge-success">registrada</span>';       

            }else{
                $data[$i]->estado = '<span class="badge badge-danger">ausente</span>';  
            }          
        }   
        echo json_encode( $data, JSON_UNESCAPED_UNICODE );
        die();
    }
  
    
}