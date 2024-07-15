<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Calendar extends CI_Calendar {

public function generate($year = '', $month = '', $data = array()) {
    // Si no se proporciona el año y el mes, usamos la fecha actual
    if (empty($year) || empty($month)) {
        $year = date('Y');
        $month = date('m');
    }

   
    // Generamos el calendario utilizando la función original de CI_Calendar
    return parent::generate($year, $month, $data);
   }
}
?>