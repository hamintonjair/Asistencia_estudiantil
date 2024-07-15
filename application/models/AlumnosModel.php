<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AlumnosModel extends CI_Model {

    public function __construct(){

        parent::__construct();

    }
    //listar Alumnos
	public function listar()
	{
        $this->db->select('cedula');
        $this->db->from('alumnos');
        $this->db->where('estado',1);
        $this->db->where('idDocente',$_SESSION['id']);
        $this->db->group_by('cedula'); 
        return $this->db->get()->result();
	}
    //validar
    public function validarCorreo($correo,$idCurso){
        $this->db->select("*");
        $this->db->from("alumnos");
        $this->db->where("correo", $correo);
        $this->db->where("idCurso", $idCurso);
        $this->db->where("estado", 1);
        return $this->db->get()->result();
    }
    public function validarCedula($cedula,$idCurso){
        $this->db->select("*");
        $this->db->from("alumnos");
        $this->db->where("cedula", $cedula);
        $this->db->where("idCurso", $idCurso);
        $this->db->where("estado", 1);
        return $this->db->get()->result();
    }
      //registrar
    public function registerAlumno($nombre,$apellidos,$cedula,$telefono, $direccion,$correo,
    $id_materia,$semestre,$perfil,$matriculado,$idDocente,$pass,$idCurso){

        $data = array(
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'cedula' => $cedula,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'correo' => $correo,
            'idMateria' => $id_materia,
            'semestre' => $semestre,
            'idDocente' => $idDocente,
            'aprobado' => $matriculado,
            'idCurso' => $idCurso,
    

        );
        $result = $this->db->insert("alumnos",$data);
        $id = $this->db->insert_id();
            
            if($result){
                $this->db->select("*");
                $this->db->from("usuarios");                
                $this->db->where("correo", $correo);
                $resultado = $this->db->get()->result();

                if(empty($resultado)){
                    $dato = array(
                    'nombre' => $nombre.' '.$apellidos,
                    'correo' => $correo,
                    'clave' => $pass,
                    'rol' => $perfil,
                    'idAlumno' => $id,               
                    );
                    $this->db->insert("usuarios",$dato);
                }
            }               
 
        return $result;
    }   
    //listar para editar
    public function getEditar($id){
        $this->db->select("a.*, u.clave, u.rol");
        $this->db->from("Alumnos a");
        $this->db->join('usuarios u', "a.id = u.idDocente");
        $this->db->where("a.id",$id);
        return $this->db->get()->result();
    }
    //update materia
    public function updateAlumno($nombre,$apellidos,$cedula,$telefono, $direccion,$correo,
    $id_materia,$semestre,$perfil,$matriculado,$idDocente,$pass,$idCurso,$id){  
        
            $this->db->where("id", $id);
            $this->db->SET("nombre", "");
            $this->db->SET("apellidos", "");
            $this->db->SET("cedula", "");
            $this->db->SET("telefono", "");
            $this->db->SET("direccion", "");
            $this->db->SET("correo", "");
            $this->db->SET("idMateria", "");
            $this->db->SET("idDocente", "");
            $this->db->SET("aprobado", "");
            $this->db->SET("idCurso", "");

            $data = array(
                'nombre' => $nombre,
                'apellidos' => $apellidos,
                'cedula' => $cedula,
                'telefono' => $telefono,
                'direccion' => $direccion,
                'correo' => $correo,
                'idMateria' => $id_materia,
                'semestre' => $semestre,
                'idDocente' => $idDocente,
                'aprobado' => $matriculado,
                'idCurso' => $idCurso,
            );
            $resp = $this->db->update("alumnos",$data);

            if(!empty($resp)){
                $this->db->where("idAlumno", $id);
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
    public function deleteAlumno($id){
        $this->db->where('id',$id);
        $this->db->delete('alumnos');

        $this->db->where('idAlumno',$id);
        $this->db->delete('alumnos');
        return $this->db->affected_rows();
     
    }
    //ver detalles
    public function verDetalle($id){
        $this->db->select('a.*, c.curso, m.materia as programa, d.nombre as nomb, d.apellidos as apell');
        $this->db->from('alumnos a');
        $this->db->join('materias m', 'a.idMateria = m.id');
        $this->db->join('docentes d', 'a.idDocente = d.id');
        $this->db->join('cursos c', 'a.idCurso = c.id');
        $this->db->where('a.estado',1);
        $this->db->where('a.id',$id);
        $resultados = $this->db->get();
        if($resultados->num_rows() > 0)
        {
           return $resultados->row();
        }	
    }
    //buscar aestudiante por cedula
    public function getCedula($cedula){

            $this->db->select('*');
            $this->db->from('alumnos');
            $this->db->where('cedula', $cedula);
            $data = $this->db->get()->result();
            $id = $data[0]->id;
            $this->db->select('a.*, u.clave');
            $this->db->from('alumnos a');
            $this->db->from('usuarios u', 'a.id = u.idDocente');
            $this->db->where('u.idDocente', $id);
            $dato = $this->db->get()->result();

            if (!empty($dato) ) {
                $result = $dato ;
                // array( 'ok' => true, 1 => $data ) ;
            } else {
                $result = false;
            }
            return $result;
    } 
    //listar Alumnos por docente
    public function listarAlumnos($idDocente){

        $this->db->select('*');
        $this->db->from('alumnos');
        $this->db->where('idDocente',$idDocente);
        $this->db->where('estado',1);
        return $this->db->get()->result();
    }
    //listar 
    public function listarEstudiantes($idDocente){
        $this->db->select('a.nombre, a.apellidos, a.cedula');
        $this->db->from('alumnos a');
        $this->db->join('docentes d', 'a.idDocente = d.id');
        $this->db->where('ha.estado', 'habilitado');
        // $this->db->where('ha.token', $docente_token);
        $this->db->where('a.idDocente', $idDocente);
        return $this->db->get()->result();
    }
      //listar cursos de alumnos
    public function getProgramas($idCurso){
        $this->db->select('*');
        $this->db->from('alumnos');
        $this->db->where('idCurso', $idCurso);
        return $this->db->get()->result();
    }
}