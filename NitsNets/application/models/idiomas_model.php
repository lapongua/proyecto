<?php

if (!defined('BASEPATH'))
    exit('No permitir el acceso directo al script');

class Idiomas_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*
     * Devuelve un array con todos los idiomas
     */

    public function getIdiomas() {
        try {

            $query = $this->db->get('idiomas');
            $idiomas=array();
            foreach ($query->result() as $row) {
                $idiomas[]=$row;
            }
            return $idiomas;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }
    }

}
