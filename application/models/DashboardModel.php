<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardModel extends CI_Model {

    public function __construct(){

        parent::__construct();

    }
    //validacion de logueo
    //funcion para generar el password
    public function passGenerator($length = 10)
    {
        $pass = "";
        $longitudPass=$length;
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $longitudCadena=strlen($cadena);

        for($i=1; $i<=$longitudPass; $i++)
        {
            $pos = rand(0,$longitudCadena-1);
            $pass .= substr($cadena,$pos,1);
        }
        return $pass;
    }
    //perfil
    public function getPerfil($id){

        if($_SESSION['rol'] == 'Docente' || $_SESSION['rol'] == 'Jefe'|| $_SESSION['rol'] == 'Admin' ){
            $this->db->select('d.*, u.rol,u.clave');
            $this->db->from('docentes d');
            $this->db->join('usuarios u','d.id = u.idDocente');
            $this->db->where('d.id', $id);
            $this->db->where('d.estado', 1);
            $result = $this->db->get()->result();
        }else{
        
            $this->db->select('a.*, u.rol,u.clave');
            $this->db->from('alumnos a');
            $this->db->join('usuarios u','a.id = u.idAlumno');
            $this->db->where('a.id', $id);
            $this->db->where('a.estado', 1);
            $result = $this->db->get()->result();
            
        }       
      
        return $result;
    }
    public function getPerfilAlumno($id){

        $this->db->select('a.semestre,a.estado,d.fecha, m.materia as programa, c.curso');
        $this->db->from('asignar_materias a');
        $this->db->join('docentes d','a.idDocente = d.id');
        $this->db->join('materias m','a.idMateria = m.id');
        $this->db->join('cursos c','a.idCurso = c.id');
        $this->db->join('usuarios u','d.id = u.idDocente');
        $this->db->where('a.idDocente', $id);
        $this->db->where('a.estado', "Asignado");
        $result = $this->db->get()->result();
   
        if(empty($result)){
            $this->db->select('a.aprobado, a.fecha, a.estado, a.semestre, m.materia as programa ,d.nombre,d.apellidos,c.curso');
            $this->db->from('alumnos a');
            $this->db->join('usuarios u','a.id = u.idDocente');
            $this->db->join('materias m','a.idMateria = m.id');
            $this->db->join('docentes d','a.idDocente = d.id');
            $this->db->join('cursos c','a.idCurso = c.id');
            $this->db->where('a.cedula', $id);
            $this->db->where('a.estado', 1);
            $result = $this->db->get()->result();
        }
        return $result;
      
    }
    //actualizar perfil
    public function updatePerfil($perfil, $correo, $telefono, $direccion, $pass ,$id){
        $this->db->where("id", $id);
        $this->db->SET("correo", "");
        $this->db->SET("telefono", "");
        $this->db->SET("direccion", "");

        $data = array(
            'correo' => $correo,
            'telefono' => $telefono,
            'direccion' => $direccion,
           
        );
        if($perfil == "Admin" || $perfil == "Docente"){
            $resp = $this->db->update("docentes",$data);
        }
        if($perfil == "Estudiante"){
              $resp = $this->db->update("alumnos",$data);
        }      

        if(!empty($resp)){
            $this->db->where("idDocente", $id);
            $this->db->SET("correo", "");
            $this->db->SET("clave", "");
            $dato = array(
                'correo' => $correo,
                'clave' => $pass,
            );
           $this->db->update("usuarios",$dato);
        }       
       
        return $resp;
    }
    //contar
    public function contarDocentes(){
        
        $this->db->select('*');
        $this->db->from('docentes');
        $result = $this->db->get()->result();
        return count($result);
    }
    public function contarAlumnos(){
        
        $this->db->select('*');
        $this->db->from('alumnos');
        $result = $this->db->get()->result();
        return count($result);
    }
    public function contarAlumnosD($id){
        
        $this->db->select('*');
        $this->db->from('alumnos');
        $this->db->where('idDocente',$id);
        $result = $this->db->get()->result();
        return count($result);
    }
    public function contarAlumnosP(){
        
        $this->db->select('idMateria');
        $this->db->from('docentes');
        $this->db->where('id', $_SESSION['id']);
        $resul = $this->db->get()->result();

        if(!empty($resul)){
            $this->db->select('*');
            $this->db->from('alumnos');
            $this->db->where('idMateria',$resul[0]->idMateria);
            $result = $this->db->get()->result();
        }
        return count($result);
    }
    public function contarCursos(){
        
        $this->db->select('*');
        $this->db->from('cursos');
        $result = $this->db->get()->result();
        return count($result);
    }
    public function contarProgramas(){
        
        $this->db->select('*');
        $this->db->from('materias');
        $result = $this->db->get()->result();
        return count($result);
    }
    //listar las notas personales
    public function getNotas($id){

        if($_SESSION['rol'] == 'Admin' ){
            $this->db->select('*');
            $this->db->from('notas');
            $this->db->where('idDocente',$id);
        }
        if($_SESSION['rol'] == 'Jefe'){
            $this->db->select('*');
            $this->db->from('notas');
            $this->db->where('idDocente',$id);
        }
        if($_SESSION['rol'] == 'Docente'){
            $this->db->select('*');
            $this->db->from('notas');
            $this->db->where('idDocente',$id);
        }
        if($_SESSION['rol'] == 'Estudiante'){
             $this->db->select('n.*, c.curso');
            $this->db->from('notas n');
            $this->db->join('cursos c', 'n.idCurso = c.id');
            $this->db->where('n.idAlumno',$id);
        }
       
        return $this->db->get()->result();
    }
    //obtener las nota publica de acuerdo a la peticion
    public function obtenerNotas($idCurso){
        if($_SESSION['rol'] == 'Admin'){
            $this->db->select('*');
            $this->db->from('notas ');
            $this->db->where('tipo', 'admin');
            $this->db->where('docente', 'Admin');
        }
        //para el jefe del programa
        if($_SESSION['rol'] == 'Jefe' && $idCurso == 'Docente'){
            $this->db->select('idMateria');
            $this->db->from('docentes');
            $this->db->where('id',$_SESSION['id']);
            $this->db->where('estado', 1);
            $resp = $this->db->get()->result();         

            $this->db->select('n.*');
            $this->db->from('notas n');
            $this->db->join('asignar_materias a', 'n.idDocente = a.idDocente', 'a.idMateria = '.$resp[0]->idMateria.'');
            $this->db->where('n.tipo', 'publica');
            $this->db->where('n.docente', 'Jefe');
        }
        //para el jefe y que el id
        if($_SESSION['rol'] == 'Jefe' && $idCurso == 'Admin'){ 

            $this->db->select('*');
            $this->db->from('notas');
            $this->db->where('tipo', 'jefe');
            $this->db->where('docente', 'Jefe_');
        }
        //para el docente y que el id sea numérico
        if($_SESSION['rol'] == 'Docente' &&  is_numeric($idCurso)){
            $this->db->select('*');
            $this->db->from('notas');
            $this->db->where('idCurso',$idCurso);
            $this->db->where('tipo','publica');
            // $this->db->where('idDocente != '.$_SESSION['id'].'');
            // $this->db->or_where('idAlumno != '.$_SESSION['id'].'');

        }
        //para el docente y que el id traiga jefe
        if($_SESSION['rol'] == 'Docente' && $idCurso == 'Jefe'){
            $this->db->select('idMateria');
            $this->db->from('asignar_materias');
            $this->db->where('idDocente',$_SESSION['id']);
            $this->db->where('estado', 'Asignado');
            $resp = $this->db->get()->result();         

            $this->db->select('id');
            $this->db->from('docentes');
            $this->db->where('idMateria = '.$resp[0]->idMateria.'');
            $this->db->where('estado', 1);
            $resp = $this->db->get()->result();  

            $this->db->select('*');
            $this->db->from('notas n');
            $this->db->where('idDocente = '.$resp[0]->id.'');
            $this->db->where('tipo', 'publica');
            $this->db->where('docente', 'Docente');

        }
        //para el estudiante
        if($_SESSION['rol'] == 'Estudiante'){
            $this->db->select('*');
            $this->db->from('notas');
            $this->db->where('idCurso',$idCurso);
            $this->db->where('tipo','publica');
            // $this->db->where('idDocente != '.$_SESSION['id'].'');
            // $this->db->or_where('idAlumno != '.$_SESSION['id'].'');

        }
        return $this->db->get()->result();

    }
    //insertar nota
    public function setNotas($titulo,$contenido,$color,$tipo_nota,$dato,$id){

        if(is_numeric($dato)){
            if($_SESSION['rol'] == 'Estudiante'){
                $data = array(
                    'titulo' => $titulo,
                    'contenido' => $contenido,
                    'color' => $color,
                    'tipo' => $tipo_nota,
                    'idCurso' => $dato,
                    'idAlumno' => $id ,
                ); 
            }
            if($_SESSION['rol'] == 'Docente'){
                $data = array(
                    'idDocente' => $id ,
                    'titulo' => $titulo,
                    'contenido' => $contenido,
                    'color' => $color,
                    'tipo' => $tipo_nota,
                    'idCurso' => $dato,
                ); 
            }
           
        }else{
             $data = array(
            'idDocente' => $id,
            'titulo' => $titulo,
            'contenido' => $contenido,
            'color' => $color,
            'tipo' => $tipo_nota,
            'docente' => $dato,
             );
        }
      
        return $this->db->insert('notas', $data);
    }
    //eliminar notas
    public function deleteNotas($id){
        $this->db->select('id');
        $this->db->from('notas');
        $this->db->where('id',$id);
        $resp = $this->db->get()->result();

        if($resp[0]->id == $id ){
          $this->db->where('id', $id);
          $this->db->delete('notas');
          $resp = $this->db->affected_rows();
        } else{
            $resp = 0;
        }      
      
        return $resp;
    }
    //insertar coordenadas
    public function insertCoordenadas($latitud,$longitud){

        $dato = array(
            'latitud' => $latitud,
            'longitud' => $longitud,
        );    

       return $this->db->update('coordenada', $dato);
    }
    //listar coordenadas
    public function getCoordenadas(){
        $this->db->select('*');
        $this->db->from('coordenada');
        return $this->db->get()->result();
    }
}