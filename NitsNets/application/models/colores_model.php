<?php

if (!defined('BASEPATH'))
    exit('No permitir el acceso directo al script');

class Colores_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getColores($idioma = "1") {
        try {
            
            $sql="SELECT c.id as id, ci.nombre as nombre, ci.fk_idioma, c.visible FROM colores_idioma ci, colores c".
                 " WHERE c.id=ci.fk_color AND ci.fk_idioma=".$idioma." ORDER BY id";

            $query = $this->db->query($sql);
            $colores = array();
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $row->traducciones = $this->hasTranslation($row->id);
                    $row->Notraducciones = $this->notHasTranslation($row->id);
                    $colores[] = $row;
                }
                return $colores;
            }
            return NULL;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }
    }
    
    
      /*
     * Inserta un color en la base de datos y devuleve el id insertado
     */

    public function addColor($color = "", $data) {
        try {
            if ($color == '') {//nuevo color
                $this->db->trans_begin();

                $misdatos = array(
                    'visible' => '1'
                );

                $this->db->insert('colores', $misdatos);
                $colId = $this->db->insert_id();

                $data['fk_color'] = $colId;

                $this->db->insert('colores_idioma', $data);


                if ($this->db->trans_status() === TRUE) {
                    $this->db->trans_commit();
                    return $colId;
                }
            } else { //añadir traducción del color
                $data['fk_color'] = $color;
                $this->db->insert('colores_idioma', $data);
                return $color;
            }
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }
    }
    
    /*
     * Devuleve la información de un color
     */

    public function verColor($id, $idioma) {

        try {
            $query = $this->db->get_where('colores_idioma', array('fk_color' => $id, 'fk_idioma' => $idioma));
            if ($query->num_rows() > 0) {
                $row = $query->row();
                return $row;
            }
            return NULL;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }
    }
    
    
        /*
         * Comprueba si existe una traduccion para saber si estamos editando o añadiendo una color
         */
    function existeTraduccion($idioma, $col) {
        try {
            $this->db->like('fk_color', $col);
            $this->db->like('fk_idioma', $idioma);
            $this->db->from('colores_idioma');
            return $this->db->count_all_results();
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }
    }
    
    
     /*
     * Edita un color a partir de su id, devuelve id si es correcto o FALSE en caso contrario
     */

    function editColor($id, $data) {
        try {
            $data['fk_color'] = $id;
            $this->db->where('fk_color', $id);
            $this->db->where('fk_idioma', $data['fk_idioma']);
            $result = $this->db->update('colores_idioma', $data);
            // Return
            if ($result) {
                return $id;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }
    }
    
    /*
     * Devuelve los idiomas traducidos de un color
     */

    function hasTranslation($idcolor) {
        try {
            $sql = "SELECT ci.fk_idioma,i.short  " .
                    "FROM colores_idioma ci, idiomas i " .
                    "WHERE fk_color=" . $idcolor . " AND ci.fk_idioma=i.id";

            $query = $this->db->query($sql);
            $idiomas = array();
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $idiomas[] = $row;
                }
                return $idiomas;
            }
            return NULL;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }
    }
    
    /*
     * Devuelve los idiomas que no están traducidos de un color
     */
    function notHasTranslation($idcolor) {
        try {

            $sql = "SELECT id,short FROM idiomas WHERE id NOT IN(SELECT ci.fk_idioma FROM colores_idioma ci WHERE ci.fk_color=" . $idcolor . ")";

            $query = $this->db->query($sql);
            $idiomas = array();
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $idiomas[] = $row;
                }
                return $idiomas;
            }
            return NULL;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }
    }
    
     /*
     * Elimina un color a partir de su id, devuelve TRUE o FALSE
     */

    function deleteColor($id, $idioma) {
        try {
            $this->db->trans_begin();
            //Comprobamos si hay traducciones
            $this->db->like('fk_color', $id);
            $this->db->from('colores_idioma');
            if ($this->db->count_all_results() > 1) {//hay más de una traducción
                $this->db->where('fk_idioma', $idioma);
                $this->db->where('fk_color', $id);
                $this->db->delete('colores_idioma');
            } else {
                //Solo hay una traducción hay que borrar en la categoria en si.

                $this->db->where('fk_color', $id);
                $this->db->delete('colores_idioma');

                $this->db->where('id', $id);
                $this->db->delete('colores');
            }


            if ($this->db->affected_rows() > 0) {
                $this->db->trans_commit();
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }
    }

}
