<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AsistenciasModel extends CI_Model {

    public function __construct(){

        parent::__construct();

    }
    //habilitar asistencias
    public function habilitarAsistencia($programa,$semestre,$curso,$idDocente,$fecha){

        $data = array(
            'idDocente' =>$idDocente,
            'semestre'=>$semestre,
            'idPrograma'=>$programa,
            'idCurso'=>$curso,
            'fecha' => $fecha,
        );

        return $this->db->insert('habilitar',$data); 

    }
    //validar vista habilitado
    public function validarHabilitado($idDocente){

        $this->db->select('*');
        $this->db->from('habilitar');
        $this->db->where('idDocente',$idDocente);
        $this->db->where('estado', "habilitado");
        return$this->db->get()->result();

    }
    //deshabilitar vista
    public function deshabilitarAsistencia($programa,$semestre,$curso,$idDocente){

        $this->db->where('idDocente', $idDocente);
        $this->db->where('estado', "habilitado");
        $this->db->SET('idDocente',"");
        $this->db->SET('semestre',"");
        $this->db->SET('idPrograma',"");
        $this->db->SET('idCurso',"");
        $this->db->SET('estado',"");

        $data = array(
            'idDocente' =>$idDocente,
            'semestre'=>$semestre,
            'idPrograma'=>$programa,
            'idCurso'=>$curso,
            'estado'=> "deshabilitado",
        );

        return $this->db->update('habilitar',$data);
    }
    //listar los docentes con los programas asignados
    public function asignacion($id_materia,$semestre,$idCurso,$idDocente) {
        $this->db->select('a.idMateria,a.semestre ,a.estado, a.idCurso');
        $this->db->from('asignar_materias a');
        $this->db->join('docentes d', 'a.idDocente = d.id');
        $this->db->join('cursos c', 'a.idCurso = c.id');;
        $this->db->where('a.estado', "Asignado");
        $this->db->where('a.idDocente', $idDocente);
        $this->db->where('a.idCurso', $idCurso);
        $this->db->where('a.semestre', $semestre);
        $this->db->where('a.idMateria', $id_materia);
        return $this->db->get()->result();
 
    }
    //
    public function programa($programa,$semestre,$curso,$idDocente){

        $this->db->select('*');
        $this->db->from('asignar_materias');
        $this->db->where('idMateria',$programa);
        $this->db->where('idDocente',$idDocente);
        $this->db->where('semestre',$semestre);
        $this->db->where('idCurso',$curso);
        $this->db->where('estado',"Asignado");
        return $this->db->get()->result();

    }
    //
 
    public function setToken($id_materia, $idCurso, $semestre, $idDocente, $token) {
        $this->db->where("idDocente", $idDocente);
        $this->db->where("idMateria", $id_materia);
        $this->db->where("idCurso", $idCurso);
        $this->db->where("semestre", $semestre);
    
        $data = array(
            'token' => $token,
        );
    
        $this->db->update('alumnos', $data);
    }
    //vista habilitada
    public function habilitada($idDocente){
        $this->db->select('estado');
        $this->db->from('habilitar');
        $this->db->where('idDocente',$idDocente);
        $this->db->where('estado', 'habilitado');
        return $this->db->get()->result();
    }
    //registrar asistencia
    public function setAsistencia($idDocente,$estudianteId,$idMateria,$idCurso,$semestre,$fecha){
        $this->db->select('idAlumno');
        $this->db->from('asistencias');
        $this->db->where('idAlumno',$estudianteId);
        $this->db->where('asistencia', 'registrada');
        $this->db->where('DATE(fecha_registro) ', $fecha); // Asegura que la fecha sea menor o igual
        $result = $this->db->get()->result();
        if(empty($result)){
            $fech = date('Y-m-d H:i:s');
            $data = array (
                'idDocente' => $idDocente,
                'idAlumno' => $estudianteId,
                'idMateria' => $idMateria,
                'idCurso' => $idCurso,
                'semestre' => $semestre,
                'fecha_registro' => $fech,
                'asistencia' => 'registrada',

            );
            $resp = $this->db->insert('asistencias', $data);
        }else{
            $resp = false;
        }

        return $resp;
    }
    //obtener el curso habilitado
    public function getCursoHabilitado($idCurso){
        $this->db->select('*');
        $this->db->from('habilitar');
        $this->db->where('idCurso',$idCurso);
        $this->db->where('estado', 'habilitado');
        return $this->db->get()->result();
    }
    //listar asistencias para el docente
    public function listarAsistencias($idDocente){
        $this->db->select('as.id,as.semestre,as.fecha_registro as fecha,as.asistencia, a.nombre,a.apellidos,a.cedula,c.curso,m.materia');
        $this->db->from('asistencias as');
        $this->db->join('alumnos a', 'as.idAlumno = a.id');
        $this->db->join('materias m', 'as.idMateria = m.id');
        $this->db->join('cursos c', 'as.idCurso = c.id');
        $this->db->join('docentes d', 'as.idDocente = d.id');
        $this->db->where('d.id', $idDocente);
        return $this->db->get()->result();
    }
        //listar asistencias para el alumno
    public function listarAsistenciasA($idEstudiante){
            $this->db->select('as.id,as.semestre,as.fecha_registro as fecha,as.asistencia, a.nombre,a.apellidos,a.cedula,c.curso,m.materia');
            $this->db->from('asistencias as');
            $this->db->join('alumnos a', 'as.idAlumno = a.id');
            $this->db->join('materias m', 'as.idMateria = m.id');
            $this->db->join('cursos c', 'as.idCurso = c.id');
            $this->db->join('docentes d', 'as.idDocente = d.id');
            $this->db->where('a.id', $idEstudiante);
            return $this->db->get()->result();
    }
          //buscar asistencias para el alumno
    public function buscarAsistenciasA($idCurso){
       $this->db->select('as.id,as.semestre,as.fecha_registro as fecha,as.asistencia, a.nombre,a.apellidos,a.cedula,c.curso,m.materia');
       $this->db->from('asistencias as');
       $this->db->join('alumnos a', 'as.idAlumno = a.id');
       $this->db->join('materias m', 'as.idMateria = m.id');
       $this->db->join('cursos c', 'as.idCurso = c.id');
       $this->db->join('docentes d', 'as.idDocente = d.id');
       $this->db->where('as.asistencia', 'registrada');
       $this->db->where('as.idCurso', $idCurso);
       $this->db->where('a.id', $_SESSION['id']);

    return $this->db->get()->result();
    }
//obtener los datos del alumno
    // public function getAlumnosSinAsistencia($idCurso, $semestre) {
    //     $fecha = date('Y-m-d H:i:s');
    //     $this->db->select('alumnos.id, alumnos.correo, cursos.curso as curso');
    //     $this->db->from('alumnos');
    //     $this->db->join('cursos', 'alumnos.idCurso = cursos.id'); // Unir con la tabla cursos
    //     $this->db->where('alumnos.idCurso', $idCurso);
    //     $this->db->where('alumnos.semestre', $semestre);
    //     $this->db->where_not_in('alumnos.id', "SELECT idAlumno FROM asistencias WHERE idCurso = $idCurso AND semestre = $semestre AND fecha_registro != $fecha
    //      ");
    //     return $this->db->get()->result();
    // }
    public function getAlumnosSinAsistencia($idCurso, $semestre) {
        $this->db->select('a.id, a.correo, c.curso');
        $this->db->from('alumnos a');
        $this->db->join('cursos c', 'a.idCurso = c.id');
        $this->db->where('a.idCurso', $idCurso);
        $this->db->where('a.semestre', $semestre);
        $this->db->where_not_in('a.id', "SELECT idAlumno FROM asistencias WHERE idCurso = $idCurso AND semestre = $semestre");
        return $this->db->get()->result();
    }
    
    public function validarFechaRegistro($idAlumno, $idCurso, $semestre) {
        $fechaActual = date('Y-m-d');        

        $this->db->select('idAlumno,fecha_registro');
        $this->db->from('asistencias');
        $this->db->where('idAlumno', $idAlumno);
        $this->db->where('idCurso', $idCurso);
        $this->db->where('semestre', $semestre);
        $fechaRegistroFormatted = date('Y-m-d', strtotime($fechaActual));
        $this->db->where('DATE(fecha_registro)',DATE($fechaRegistroFormatted));

        return $this->db->get()->row();
    }
    //registrar asistencias ausentes
    public function registrarAusente($idDocente,$idAlumno, $idCurso, $semestre, $idMateria, $fecha) {
     
        $data = array (
            'idDocente' => $idDocente,

            'idAlumno' => $idAlumno,
            'idMateria' => $idMateria,
            'idCurso' => $idCurso,
            'semestre' => $semestre,
            'fecha_registro' => $fecha,
            'asistencia' => 'ausente'

        );
        $this->db->insert('asistencias', $data);
  
    }  

}