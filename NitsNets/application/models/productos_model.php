<?php

if (!defined('BASEPATH'))
    exit('No permitir el acceso directo al script');

class Productos_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getProductos($idioma = "1") {
        try {
//            if ($idioma == '-') {
//                $sql = "SELECT ci.nombre as nombre, ci.descripcion as descripcion, c.id as id, i.short as idioma, ci.fk_idioma" .
//                        " FROM categorias c, categoria_idioma ci, idiomas i" .
//                        " WHERE c.id=ci.fk_categoria AND i.id=ci.fk_idioma";
//                " ORDER BY id,fk_idioma";
//            } else {
            $sql = "SELECT pi.nombre as nombre, pi.descripcion as descripcion, p.id as id, i.short as idioma, pi.fk_idioma" .
                    " FROM productos p, productos_idioma pi, idiomas i" .
                    " WHERE i.id=" . $idioma . " AND p.id=pi.fk_producto AND i.id=pi.fk_idioma";
            " ORDER BY id ASC";
//            }


            $query = $this->db->query($sql);
            $productos = array();
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $row->traducciones = $this->hasTranslation($row->id);
                    $row->Notraducciones = $this->notHasTranslation($row->id);
                    $productos[] = $row;
                }
                return $productos;
            }
            return NULL;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }
    }

    /*
     * Devuelve los idiomas traducidos de un producto
     */

    function hasTranslation($idproducto) {
        try {
            $sql = "SELECT pi.fk_idioma,i.short  " .
                    "FROM productos_idioma pi, idiomas i " .
                    "WHERE fk_producto=" . $idproducto . " AND pi.fk_idioma=i.id";

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
     * Devulve los idiomas que no estan traducidos en un producto
     */

    function notHasTranslation($idproducto) {
        try {

            $sql = "SELECT id,short FROM idiomas WHERE id NOT IN(SELECT pi.fk_idioma FROM productos_idioma pi WHERE pi.fk_producto=" . $idproducto . ")";

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
     * Inserta un producto en la base de datos y devuleve el id insertado
     */

    public function addProducto($producto = "", $miproducto) {
        try {
            if ($producto == '') {//nuevo producto
                $this->db->trans_begin();


                $misdatos = array(
                    'sku' => $miproducto['sku'],
                    'precio' => $miproducto['precio'],
                    'fk_categoria' => $miproducto['fk_categoria']
                );

                $this->db->insert('productos', $misdatos);
                $prodId = $this->db->insert_id();

                $produtos_idioma = array(
                    'fk_producto' => $prodId,
                    'fk_idioma' => $miproducto['fk_idioma'],
                    'nombre' => $miproducto['nombre'],
                    'descripcion' => $miproducto['descripcion']
                );

                $this->db->insert('productos_idioma', $produtos_idioma);

                foreach ($miproducto['fk_color'] as $key => $value) {

                    $produtos_color = array(
                        'fk_producto' => $prodId,
                        'fk_color' => $value
                    );

                    $this->db->insert('productos_colores', $produtos_color);
                }


                if ($this->db->trans_status() === TRUE) {
                    $this->db->trans_commit();
                    return $prodId;
                }
            } else { //añadir traducción
             $this->db->trans_begin();
                //Actualizamos la tabla productos
                $misdatos = array(
                    'sku' => $miproducto['sku'],
                    'precio' => $miproducto['precio'],
                    'fk_categoria' => $miproducto['fk_categoria']
                );

                $this->db->where('id', $producto);
                $this->db->update('productos', $misdatos);


                //añadimos traducción
                $produtos_idioma = array(
                    'fk_producto' => $producto,
                    'fk_idioma' => $miproducto['fk_idioma'],
                    'nombre' => $miproducto['nombre'],
                    'descripcion' => $miproducto['descripcion']
                );
                $this->db->insert('productos_idioma', $produtos_idioma);

                //Eliminamos todos los colores
                $this->db->delete('productos_colores', array('fk_producto' => $producto));

                //Damos de alta los colores nuevos
                foreach ($miproducto['fk_color'] as $key => $value) {

                    $produtos_color = array(
                        'fk_producto' => $producto,
                        'fk_color' => $value
                    );

                    $this->db->insert('productos_colores', $produtos_color);
                }


                if ($this->db->trans_status() === TRUE) {
                    $this->db->trans_commit();
                    return $producto;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }
    }

    /*
     * Edita una producto a partir de su id, devuelve id si es correcto o FALSE en caso contrario
     */

    function editProducto($id, $data) {
        try {
            $this->db->trans_begin();

            //Actualizamos la tabla productos
            $misdatos = array(
                'sku' => $data['sku'],
                'precio' => $data['precio'],
                'fk_categoria' => $data['fk_categoria']
            );

            $this->db->where('id', $id);
            $this->db->update('productos', $misdatos);

            //Actualizamos la tabla productos_idioma
            $produtos_idioma = array(
                'fk_producto' => $id,
                'fk_idioma' => $data['fk_idioma'],
                'nombre' => $data['nombre'],
                'descripcion' => $data['descripcion']
            );

            $data['fk_categoria'] = $id;
            $this->db->where('fk_producto', $id);
            $this->db->where('fk_idioma', $data['fk_idioma']);
            $this->db->update('productos_idioma', $produtos_idioma);

            //Eliminamos todos los colores
            $this->db->delete('productos_colores', array('fk_producto' => $id));

            //Damos de alta los colores nuevos
            foreach ($data['fk_color'] as $key => $value) {

                $produtos_color = array(
                    'fk_producto' => $id,
                    'fk_color' => $value
                );

                $this->db->insert('productos_colores', $produtos_color);
            }


            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                return $id;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }
    }

    /*
     * Devuleve la información de un producto
     */

    public function verProducto($id, $idioma) {

        try {
            $query = $this->db->get_where('productos_idioma', array('fk_producto' => $id, 'fk_idioma' => $idioma));
            if ($query->num_rows() > 0) {
                $row = $query->row();

                $query = $this->db->get_where('productos', array('id' => $id));
                if ($query->num_rows() > 0) {
                    //JUNTA LOS DOS OJETOS EN UNO
                    $rows = (object) array_merge((array) $row, (array) $query->row());

                    $query = $this->db->get_where('productos_colores', array('fk_producto' => $id));
                    if ($query->num_rows() > 0) {
                        foreach ($query->result() as $row) {
                            $rows->miscolores[] = $row;
                        }
                    }
                }
                return $rows;
            }
            return NULL;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }
    }

    /*
     * Comprueba si existe una traduccion para saber si estamos editando o añadiendo una traduccion
     */

    function existeTraduccion($idioma, $prod) {
        try {
            $this->db->like('fk_producto', $prod);
            $this->db->like('fk_idioma', $idioma);
            $this->db->from('productos_idioma');
            $total = $this->db->count_all_results();
            return $total;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }
    }

    /*
     * Devuelve la información común de un producto
     */

    function comunProducto($id) {
        $query = $this->db->get_where('productos', array('id' => $id));
        if ($query->num_rows() > 0) {
            $row = $query->row();

            $query = $this->db->get_where('productos_colores', array('fk_producto' => $id));
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                    $row->miscolores[] = $rows;
                }
            }


            return $row;
        }
        return false;
    }
    
    
    /*
     * Elimina un producto a partir de su id e idioma. devuelve TRUE o FALSE
     */

    function deleteProducto($id, $idioma) {
        try {
            $this->db->trans_begin();
            //Comprobamos si hay traducciones
            $this->db->like('fk_producto', $id);
            $this->db->from('productos_idioma');
            if ($this->db->count_all_results() > 1) {//hay más de una traducción
                $this->db->where('fk_idioma', $idioma);
                $this->db->where('fk_producto', $id);
                $this->db->delete('productos_idioma');
                
                
            } else {
                //Solo hay una traducción hay que borrar todo el producto.

                $this->db->where('fk_producto', $id);
                $this->db->delete('productos_idioma');

                $this->db->where('id', $id);
                $this->db->delete('productos');
                
                $this->db->where('fk_producto', $id);
                $this->db->delete('productos_colores');
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
