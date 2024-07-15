<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MateriasModel extends CI_Model {

    public function __construct(){

        parent::__construct();

    }
    //registrar
    public function registerMaterias($materia){

        $data = array(
            'materia' => $materia,
        );
        $this->db->select("*");
        $this->db->from("materias");
        $this->db->where("materia", $materia);
        $this->db->where("estado", 1);

        $result = $this->db->get()->result();

        if(empty($result)){
            $resp = $this->db->insert("materias",$data);
            $result = true;

        }else{
            $result = false;
        }
        return $result;
    }
    //listar
    public function listar(){
        $this->db->select("*");
        $this->db->from("materias");
        $this->db->where("estado",1);
        return $this->db->get()->result();
    }
    //listar para editar
    public function getEditar($id){
        $this->db->select("*");
        $this->db->from("materias");
        $this->db->where("id",$id);
        return $this->db->get()->result();
    }
    //update materia
    public function updateMateria($materia,$id){
        
        $this->db->where("id", $id);
        $this->db->SET("materia", "");

        $data = array(
            'materia' => $materia,
        );
        $resp = $this->db->update("materias",$data);
        return $resp;
    }
    //eliminar materia
    public function deletePrograma($id){
        $this->db->where('id',$id);
        $this->db->delete('materias');
        return $this->db->affected_rows();
    }
    //listar asignados
    public function listarAsignados(){
        $this->db->select("a.*,d.nombre as nombre, d.apellidos as apellidos, m.materia as programa, c.curso as curso");
        $this->db->from("asignar_materias a");
        $this->db->join("docentes d", "a.idDocente = d.id");
        $this->db->join("materias m", "a.idMateria = m.id");
        $this->db->join("cursos c", "a.idCurso = c.id");
        $this->db->where("a.estado","Asignado");
        $this->db->where("a.idJefe", $_SESSION['id']);
        return $this->db->get()->result();
    }
    //asignar programas
    public function asignarPrograma(  $idJefe ,$id_materia, $id_docentes, $id_semestre, $idCurso ){
        $data = array(
            'idMateria' => $id_materia,
            'idDocente' => $id_docentes,
            'semestre' => $id_semestre,
            'idCurso' => $idCurso,
            'idjefe' => $idJefe,
        );
        $this->db->select("*");
        $this->db->from("asignar_materias");
        $this->db->where("idCurso", $idCurso);
        $this->db->where("idDocente", $id_docentes);
        $this->db->where("estado", "Asignado");
        $result = $this->db->get()->result();

        if(empty($result)){
            $resp = $this->db->insert("asignar_materias",$data);
            $result = true;
        }else{
            $result = false;
        }
        return $result;
    }
    //actualizar asignacion de programas
    public function updatePrograma(  $idJefe ,$id_materia, $id_docentes, $semestre, $idCurso ,$id){
 
   
        $this->db->select("*");
        $this->db->from("asignar_materias");
        $this->db->where("idCurso", $idCurso);
        $this->db->where("estado", "Asignado");
        $result = $this->db->get()->result();

        if(empty($result)){
            $this->db->where("id", $id);
            $this->db->SET("idMateria", "");
            $this->db->SET("idDocente", "");
            $this->db->SET("semestre", "");
            $this->db->SET("idCurso", "");
            $this->db->SET("idJefe", "");

            $data = array(
                'idMateria' => $id_materia,
                'idDocente' => $id_docentes,
                'semestre' => $semestre,
                'idCurso' => $idCurso,
            );
    
            return $this->db->update("asignar_materias",$data);
        }else{
            return false;
        }

    }
    //eliminar asignacion
    public function deleteAsignacion($id){
        $this->db->where('id',$id);
        $this->db->delete('asignar_materias');
        return $this->db->affected_rows();
    }
     //listar para editar
     public function getEditarAsignacion($id){
        $this->db->select("*");
        $this->db->from("asignar_materias");
        $this->db->where("id",$id);
        return $this->db->get()->result();
    }
      //listar curso
    public function listarCursos(){
        $this->db->select("*");
        $this->db->from("cursos");
        $this->db->where("estado",1);
        return $this->db->get()->result();
    }
     //registrar curso
     public function registerCurso($curso){

        $data = array(
            'curso' => $curso,
        );
        $this->db->select("*");
        $this->db->from("cursos");
        $this->db->where("curso", $curso);
        $this->db->where("estado", 1);

        $result = $this->db->get()->result();

        if(empty($result)){
            $result = $this->db->insert("cursos",$data);
            $result = true;

        }else{
            $result = false;
        }
        return $result;
    }
      //actualizar cursos
    public function updateCurso($curso,$id){
 
        $this->db->where("id", $id);
        $this->db->SET("curso", "");      

        $data = array(
            'curso' => $curso,
        );
        $resp = $this->db->update("cursos",$data);
        return $resp;
    }
    //listar para editar el curos
    public function getEditarCurso($id){
        $this->db->select("*");
        $this->db->from("cursos");
        $this->db->where("id",$id);
        return $this->db->get()->result();
    }
     //eliminar curso
     public function deleteCurso($id){
        $this->db->where('id',$id);
        $this->db->delete('cursos');
        return $this->db->affected_rows();
    }
    //listar programas acorde al id del docente
    public function listarP($id_docentes){
        if($_SESSION['rol'] == 'Jefe'){
            $this->db->select("a.idMateria, m.materia");
            $this->db->from("asignar_materias a");
            $this->db->join("materias m", "a.idMateria = m.id" );
            $this->db->join("docentes d", "a.idDocente = d.id" );
            $this->db->where("a.idDocente", 'd.id');
            $this->db->group_by(' m.materia'); 
        }else{
             $this->db->select("a.idMateria, m.materia");
            $this->db->from("asignar_materias a");
            $this->db->join("materias m", "a.idMateria = m.id" );
            $this->db->where("a.idDocente",$id_docentes);
            $this->db->group_by(' m.materia'); 
        }       

        return $this->db->get()->result();
    }
        //listar cursos acorde al id del docente
    public function listarC($id_docentes){
        if($_SESSION['rol'] == 'Jefe'){
            $this->db->select("a.idCurso, c.curso");
            $this->db->from("asignar_materias a");
            $this->db->join("cursos c", "a.idCurso = c.id" );
            $this->db->join("docentes d", "a.idDocente = d.id" );
            $this->db->where("a.idDocente", 'd.id');
        }
        if($_SESSION['rol'] == 'Docente'){
            $this->db->select("a.idCurso, c.curso");
            $this->db->from("asignar_materias a");
            $this->db->join("cursos c", "a.idCurso = c.id" );
            $this->db->where("a.idDocente",$id_docentes);
        }
        if($_SESSION['rol'] == 'Estudiante'){
            $this->db->select("a.idCurso, c.curso");
            $this->db->from("alumnos a");
            $this->db->join("cursos c", "a.idCurso = c.id" );
            $this->db->where("a.id",$id_docentes);
        }                  
            // $this->db->group_by(' c.cursos');     
        return $this->db->get()->result();
    }
  //listar semestre acorde al id del docente
    public function listarS($id_docentes){
        $this->db->select("id, semestre");
        $this->db->from("asignar_materias");
        $this->db->where("idDocente",$id_docentes);
        $this->db->group_by(' semestre');     
        return $this->db->get()->result();
   }
   //listar programas
   public function programas(){
      $this->db->select("*");
      $this->db->from("materias");
      return $this->db->get()->result();;
   }

}