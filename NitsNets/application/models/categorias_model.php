<?php

if (!defined('BASEPATH'))
    exit('No permitir el acceso directo al script');

class Categorias_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*
     * Devuelve un array con todas las categorías
     */

    public function getCategorias($idioma = "1") {
        try {
            if ($idioma == '-') {
                $sql = "SELECT ci.nombre as nombre, ci.descripcion as descripcion, c.id as id, i.short as idioma, ci.fk_idioma" .
                        " FROM categorias c, categoria_idioma ci, idiomas i" .
                        " WHERE c.id=ci.fk_categoria AND i.id=ci.fk_idioma";
                " ORDER BY id,fk_idioma";
            } else {
                $sql = "SELECT ci.nombre as nombre, ci.descripcion as descripcion, c.id as id, i.short as idioma, ci.fk_idioma" .
                        " FROM categorias c, categoria_idioma ci, idiomas i" .
                        " WHERE i.id=" . $idioma . " AND c.id=ci.fk_categoria AND i.id=ci.fk_idioma";
                " ORDER BY id,fk_idioma";
            }


            $query = $this->db->query($sql);
            $categorias = array();
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $row->traducciones = $this->hasTranslation($row->id);
                    $row->Notraducciones = $this->notHasTranslation($row->id);
                    $categorias[] = $row;
                }
                return $categorias;
            }
            return NULL;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }
    }

    /*
     * Devuleve la información de una categoria
     */

    public function verCategoria($id, $idioma) {

        try {
            $query = $this->db->get_where('categoria_idioma', array('fk_categoria' => $id, 'fk_idioma' => $idioma));
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
     * Inserta una categoría en la base de datos y devuleve el id insertado
     */

    public function addCategoria($categoria = "", $data) {
        try {
            if ($categoria == '') {//nueva categoria
                $this->db->trans_begin();

                $misdatos = array(
                    'visible' => '1',
                    'imagen' => ''
                );

                $this->db->insert('categorias', $misdatos);
                $catId = $this->db->insert_id();

                $data['fk_categoria'] = $catId;

                $this->db->insert('categoria_idioma', $data);


                if ($this->db->trans_status() === TRUE) {
                    $this->db->trans_commit();
                    return $catId;
                }
            } else { //añadir traducción
                $data['fk_categoria'] = $categoria;
                $this->db->insert('categoria_idioma', $data);
                return $categoria;
            }
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }
    }

    /*
     * Elimina una categoría a partir de su id, devuelve TRUE o FALSE
     */

    function deleteCategoria($id, $idioma) {
        try {
            $this->db->trans_begin();
            //Comprobamos si hay traducciones
            $this->db->like('fk_categoria', $id);
            $this->db->from('categoria_idioma');
            if ($this->db->count_all_results() > 1) {//hay más de una traducción
                $this->db->where('fk_idioma', $idioma);
                $this->db->where('fk_categoria', $id);
                $this->db->delete('categoria_idioma');
            } else {
                //Solo hay una traducción hay que borrar en la categoria en si.

                $this->db->where('fk_categoria', $id);
                $this->db->delete('categoria_idioma');

                $this->db->where('id', $id);
                $this->db->delete('categorias');
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

    /*
     * Edita una categoría a partir de su id, devuelve id si es correcto o FALSE en caso contrario
     */

    function editCategoria($id, $data) {
        try {
            $data['fk_categoria'] = $id;
            $this->db->where('fk_categoria', $id);
            $this->db->where('fk_idioma', $data['fk_idioma']);
            $result = $this->db->update('categoria_idioma', $data);
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
     * Devuelve los idiomas traducidos de una categoria
     */

    function hasTranslation($idcategoria) {
        try {
            $sql = "SELECT ci.fk_idioma,i.short  " .
                    "FROM categoria_idioma ci, idiomas i " .
                    "WHERE fk_categoria=" . $idcategoria . " AND ci.fk_idioma=i.id";

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
     * Devuelve los idiomas que no están traducidos en una categoria
     */
    function notHasTranslation($idcategoria) {
        try {

            $sql = "SELECT id,short FROM idiomas WHERE id NOT IN(SELECT ci.fk_idioma FROM categoria_idioma ci WHERE ci.fk_categoria=" . $idcategoria . ")";

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
         * Comprueba si existe una traduccion para saber si estamos editando o añadiendo una traduccion
         */
    function existeTraduccion($idioma, $cat) {
        try {
//            $sql = "SELECT count(*)" .
//                    "FROM categoria_idioma ci".
//                    " WHERE fk_idioma=".$idioma;
//            $query = $this->db->query($sql);
//            $idiomas = array();
//            if ($query->num_rows() > 0) {
//                foreach ($query->result() as $row) {
//                    $idiomas[] = $row;
//                }
//                return $idiomas;
//            }
//            return NULL;
            $this->db->like('fk_categoria', $cat);
            $this->db->like('fk_idioma', $idioma);
            $this->db->from('categoria_idioma');
            return $this->db->count_all_results();
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }
    }

}
