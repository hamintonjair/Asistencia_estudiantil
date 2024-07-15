<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model {

    public function __construct(){

        parent::__construct();

    }
    //validacion de logueo
	public function ValidarLogin($correo,$rol)
	{
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('correo', $correo);
        $this->db->where('rol', $rol);

        return $this->db->get()->result();
	}
    public function getUserEmail($correo){
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('correo', $correo);
        return $this->db->get()->result();

    }
        //envio del token para restaurar la contraseña
    public function setTokenUser($idpersona,$token)
    { 
        $this->db->where('idDocente', $idpersona);    
        $this->db->SET('token',$token ); 
        return $this->db->update('usuarios'); 
    
    }
          //envio del token para restaurar la contraseña
    public function setTokenUserA($idpersona,$token)
     { 
        $this->db->where('idAlumno', $idpersona);    
        $this->db->SET('token',$token ); 
        return $this->db->update('usuarios'); 
          
    }
    //consultar el id personas con las siguientes condiciones
    public function getUsuario($email,$token)
    {
      $this->db->select("*");
      $this->db->from('usuarios');
      $this->db->where('correo', $email);
      $this->db->where('token', $token);
     
      $resultados = $this->db->get();
      if($resultados->num_rows() > 0)
       {
        return $resultados->row();
      }
    }
      //insertar el nuevo password reseteado
    public function insertPassword($idpersona,$password)
    {
        if(!empty($idpersona['idDocente'])){
            $this->db->where('idDocente', $idpersona['idDocente']);    
        }else{
            $this->db->where('idAlumno', $idpersona['idAlumno']);  
        }
        // $this->db->SET('clave',"" ); 
        // $this->db->SET('token',"" ); 
        
        $data = array(
            'clave' => $password,
            'token' => "",
        ) ;
        return $this->db->update('usuarios',$data);

    }
     
   //funcion para las cadenas de caracteres y reemplazarlas, eliminando exceso de espacios entre palabras
   public function strClean($strCadena){   
    $string = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''], $strCadena);
    $string = trim($string); //Elimina espacios en blanco al inicio y al final      
    $string = stripslashes($string); // Elimina las \ invertidas
    $string = str_ireplace("<script>","",$string);
    $string = str_ireplace("</script>","",$string);
    $string = str_ireplace("<script src>","",$string);
    $string = str_ireplace("<script type=>","",$string);
    $string = str_ireplace("SELECT * FROM","",$string);
    $string = str_ireplace("DELETE FROM","",$string);
    $string = str_ireplace("INSERT INTO","",$string);
    $string = str_ireplace("SELECT COUNT(*) FROM","",$string);
    $string = str_ireplace("DROP TABLE","",$string);
    $string = str_ireplace("OR '1'='1","",$string);
    $string = str_ireplace('OR "1"="1"',"",$string);
    $string = str_ireplace('OR ´1´=´1´',"",$string);
    $string = str_ireplace("is NULL; --","",$string);
    $string = str_ireplace("is NULL; --","",$string);
    $string = str_ireplace("LIKE '","",$string);
    $string = str_ireplace('LIKE "',"",$string);
    $string = str_ireplace("LIKE ´","",$string);
    $string = str_ireplace("OR 'a'='a","",$string);
    $string = str_ireplace('OR "a"="a',"",$string);
    $string = str_ireplace("OR ´a´=´a","",$string);
    $string = str_ireplace("OR ´a´=´a","",$string);
    $string = str_ireplace("--","",$string);
    $string = str_ireplace("^","",$string);
    $string = str_ireplace("[","",$string);
    $string = str_ireplace("]","",$string);
    $string = str_ireplace("==","",$string);
    return $string;    
   }
   //Obtener cedula
   public function getCedula($id){
      $this->db->select("cedula");
      $this->db->from('alumnos');
      $this->db->where('id', $id);
      return $this->db->get()->result();
   }
}