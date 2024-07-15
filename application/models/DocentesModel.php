<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DocentesModel extends CI_Model {

    public function __construct(){

        parent::__construct();

    }
   
    //listar docentes asignado al jefe de programa
	public function listar()
	{
        $this->db->select('*');
        $this->db->from('docentes');
        $this->db->where('estado',1);
        $this->db->where('idJefe',$_SESSION['id']);
        return $this->db->get()->result();
	}
     //listar docentes
	public function listarJ()
	{
        $this->db->select('d.*, u.rol, m.materia as programa');
        $this->db->from('docentes d');
        $this->db->join('usuarios u', "d.id = u.idDocente");
        $this->db->join('materias m', "d.idMateria = m.id");
        $this->db->where('d.estado',1);
        $this->db->where('u.rol', "Jefe");

        return $this->db->get()->result();
	}
    //listar cedulas docentes
    public function listarCedula(){
        $this->db->select('d.id,d.cedula, d.nombre, d.apellidos');
        $this->db->from('docentes d');
        $this->db->join('usuarios u', "d.id = u.idDocente");
        $this->db->join('asignar_materias a', "d.id = a.idDocente");
        $this->db->join('materias m', "a.idMateria = m.id");
        $this->db->where('d.estado',1);
        $this->db->where('u.rol', "Docente");
        $this->db->where('a.idJefe', $_SESSION['id']);

        return $this->db->get()->result();
    }
       //listar cedulas jefe de programas
       public function listarCedulaJ(){
        $this->db->select('cedula');
        $this->db->from('docentes');
        $this->db->where('estado',1);
        $this->db->where('idMateria != "" ');
        return $this->db->get()->result();
    }
      //registrar
    public function registerDocente($nombre,$apellidos,$cedula,$telefono, $direccion,$correo,$perfil,$pass,$id_materia){

        $data = array(
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'cedula' => $cedula,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'correo' => $correo,
            'idMateria' => $id_materia,
        );


        $this->db->select("*");
        $this->db->from("docentes");
        $this->db->where("cedula", $cedula);
        $this->db->where("estado", 1);
        $cedula1 = $this->db->get()->result();

        $this->db->select("*");
        $this->db->from("docentes");
        $this->db->where("correo", $correo);
        $this->db->where("estado", 1);
        $correo1 = $this->db->get()->result();
        
        if(empty($cedula1) && empty($correo1)){
            $result = $this->db->insert("docentes",$data);
            $id = $this->db->insert_id();

            $this->db->select("*");
            $this->db->from("usuarios");
            $this->db->where("correo", $correo);
            $existe = $this->db->get()->result();

            if(empty($existe)){              

                if($result){
                    $dato = array(
                    'nombre' => $nombre.' '.$apellidos,
                    'correo' => $correo,
                    'clave' => $pass,
                    'rol' => $perfil,
                    'idDocente' => $id,               
                    );
                
                    $this->db->insert("usuarios",$dato);         
                }    
                 return true;      
            }
           
        }else{
            return false;
        }
    }   
    //listar para editar
    public function getEditar($id){
        $this->db->select("d.*, u.clave, u.rol");
        $this->db->from("docentes d");
        $this->db->join('usuarios u', "d.id = u.idDocente");
        $this->db->where("d.id",$id);
        return $this->db->get()->result();
    }
        //listar para editar
    public function getEditarJ($id){
            $this->db->select("d.*, u.clave, u.rol");
            $this->db->from("docentes d");
            $this->db->join('usuarios u', "d.id = u.idDocente");
            $this->db->where("d.id",$id);
            return $this->db->get()->result();
    }
    //update materia
    public function updateDocente($nombre,$apellidos,$cedula,$telefono, $direccion,$correo,$perfil,$pass,$id, $id_materia){
        
        $this->db->where("id", $id);
        $this->db->SET("nombre", "");
        $this->db->SET("apellidos", "");
        $this->db->SET("cedula", "");
        $this->db->SET("telefono", "");
        $this->db->SET("direccion", "");
        $this->db->SET("correo", "");
        $this->db->SET("idMateria", "");

        $data = array(
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'cedula' => $cedula,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'correo' => $correo,
            'idMateria' => $id_materia,
        );
        $resp = $this->db->update("docentes",$data);

        if(!empty($resp)){
            $this->db->where("idDocente", $id);
            $this->db->SET("nombre", "");
            $this->db->SET("correo", "");
            $this->db->SET("clave", "");
            $this->db->SET("rol", "");
            $dato = array(
                'nombre' => $nombre,
                'correo' => $correo,
                'clave' => $pass,
                'rol' => $perfil,           
            );
           $this->db->update("usuarios",$dato);
        }       
       
        return $resp;
    }
    //eliminar materia
    public function deleteDocente($id){
        $this->db->where('id',$id);
        $this->db->delete('docentes');

        $this->db->where('idDocente', $id);
        $this->db->delete('usuarios');
        return $this->db->affected_rows();
    }

    //email
    public function sendEmail($data,$template)
    {      
        $asunto = $data['asunto'];
        $emailDestino = $data['email'];
        $usuario = $data['nombreUsuario'];      
  
       try {    
            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'smtp.gmail.com',
                'smtp_user' => 'hamintonjair@gmail.com', //Su Correo de Gmail Aqui
                'smtp_pass' => 'eorjdlcmzvzufiuw', // Su Password de Gmail aqui
                'smtp_port' => '465',
                'smtp_crypto' =>'ssl',
                'mailtype' => 'html',
                'wordwrap' => TRUE,
                'charset' => 'utf-8'
                );
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");

                ob_start();
                $this->load->view('layout/email/'.$template.'.php', $data);
                $mensaje = ob_get_clean();
                $this->email->from("no-reply@miuniclaretiana.edu.co", "Sistema de asistencias Uniclaretiana");
                $this->email->subject( $asunto);
                $this->email->message($mensaje);
                $this->email->to($emailDestino,$usuario);                                     
                if($respuesta = $this->email->send()){
                    return $respuesta;
                }else {
                 return false;
                }   
                
        } catch (Exception $e) {
                    return false;
        }
              
        
    }  
    //envio de ausencias
    public function sendEmailAusencia($to, $subject, $message) {
            
       try {    
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_user' => 'hamintonjair@gmail.com', //Su Correo de Gmail Aqui
            'smtp_pass' => 'eorjdlcmzvzufiuw', // Su Password de Gmail aqui
            'smtp_port' => '465',
            'smtp_crypto' =>'ssl',
            'mailtype' => 'html',
            'wordwrap' => TRUE,
            'charset' => 'utf-8'
            );
            $messageWithLogo = '
            <html>
            <head></head>
            <body>
                <img src="https://www.ecci.edu.co/wp-content/uploads/2022/07/Res_Rectoral_02_2022__BANNER-e1664286000597.png" alt="Logotipo">
                ' . $message . '
            </body>
            </html>
        ';
    
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            ob_start();
            $mensaje = ob_get_clean();
            $this->email->from("no-reply@miuniclaretiana.edu.co", "Sistema de asistencias Uniclaretiana");
            $this->email->subject( $subject);
            $this->email->message($messageWithLogo);
            $this->email->to($to);                                     
            if($respuesta = $this->email->send()){
                return $respuesta;
            }else {
             return false;
            }   
            
    } catch (Exception $e) {
                return false;
    }
    }
    //envio de email cambio d eocngtraseña
    public function sendEmailUpdate($data,$template)
    {      
        $asunto = $data['asunto'];
        $emailDestino = $data['email'];
        $usuario = $data['nombreUsuario'];      
  
       try {    
            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'smtp.gmail.com',
                'smtp_user' => 'hamintonjair@gmail.com', //Su Correo de Gmail Aqui
                'smtp_pass' => 'eorjdlcmzvzufiuw', // Su Password de Gmail aqui
                'smtp_port' => '465',
                'smtp_crypto' =>'ssl',
                'mailtype' => 'html',
                'wordwrap' => TRUE,
                'charset' => 'utf-8'
                );
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");

                ob_start();
                $this->load->view('layout/email/'.$template.'.php', $data);
                $mensaje = ob_get_clean();
                $this->email->from("no-reply@miuniclaretiana.edu.co", "Sistema de asistencias Uniclaretiana");
                $this->email->subject( $asunto);
                $this->email->message($mensaje);
                $this->email->to($emailDestino,$usuario);                                     
                if($respuesta = $this->email->send()){
                    return $respuesta;
                }else {
                 return false;
                }   
                
        } catch (Exception $e) {
                    return false;
        }
              
        
    } 
      //funcion para generar un token y poder restablecer contraseña
    public function token()
    {
          $r1 = bin2hex(random_bytes(10));
          $r2 = bin2hex(random_bytes(10));
          $r3 = bin2hex(random_bytes(10));
          $r4 = bin2hex(random_bytes(10));
          $token = $r1.'-'.$r2.'-'.$r3.'-'.$r4;
          return $token;
    }
    public function generateToken() {
        $token = bin2hex(random_bytes(32));
        return $token;
    }
    
    public function verDetalle($id){
        $this->db->select('d.id, ap.idCurso as curso,  m.materia as programa,ap.estado as asignaciones, ap.semestre, ap.fecha, c.curso');
        $this->db->from('docentes d');
        $this->db->where('d.id', $id);
        $this->db->join('asignar_materias ap', 'd.id = ap.idDocente', 'left');
        $this->db->join('cursos c', 'ap.idCurso = c.id', 'left');
        $this->db->join('materias m', 'ap.idMateria = m.id', 'left');
        return $this->db->get()->result();

    }
    //obtener el idDocente
    public function getId(){

    }
    //listar programas asignados
    public function getProgramas($idEstudiante){
        $this->db->select('cedula');
        $this->db->from('alumnos');
        $this->db->where('id', $idEstudiante);
        $result = $this->db->get()->result();

        if(!empty($result)){
            $this->db->select('c.id,c.curso');
            $this->db->from('alumnos a');
            $this->db->join('cursos c', 'a.idCurso = c.id','inner');
            $this->db->where('a.cedula', $result[0]->cedula);
            return $this->db->get()->result();
        }
    }
    public function getHabilitado($idEstudiante){
        $this->db->select('idDocente');
        $this->db->from('alumnos');
        $this->db->where('id', $idEstudiante);
        $result = $this->db->get()->result();

        if(!empty($result)){
            $this->db->select('ha.estado');
            $this->db->from('habilitar ha');
            $this->db->join('docentes d','ha.idDocente = d.id');
            $this->db->where('ha.estado', 'habilitado');
            $this->db->where('d.id', $result[0]->idDocente);
            return $this->db->get()->result();
        }
    }
 
    public function buscarEstudiantesPorDocente($idDocente) {

       $this->db->select('a.*');
       $this->db->from('alumnos a');
       $this->db->join('docentes d', 'a.idDocente = d.id');
       $this->db->where('d.id', $idDocente);
       $query = $this->db->get()->result();
    
          if (!empty($query)) {
             return $query;
          } else {
             return false;
          }
    }
}