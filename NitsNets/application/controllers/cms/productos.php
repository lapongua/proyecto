<?php
if (!defined('BASEPATH'))
    exit('No permitir el acceso directo al script');

class Productos extends MY_Controller {

    protected $models = array('productos','categorias','colores','idiomas');
    protected $asides = array();

    function __construct() {
        parent::__construct();
    }

    function index() {
    $this->data['productos'] = $this->productos->getProductos();
    $this->data['languages'] = $this->idiomas->getIdiomas();
        
    }
    
    function add() {

        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|min_length[3]|max_length[100]|required|xss_clean');
        $this->form_validation->set_rules('descripcion', 'Descripción', 'trim|min_length[25]|max_length[500]|required|xss_clean');
       // $this->form_validation->set_rules('categoria', 'Categoría', 'required');
       // $this->form_validation->set_rules('color[]', 'Colores', 'trim|required|xss_clean');
        $this->form_validation->set_rules('precio', 'Precio', 'trim|required|xss_clean');
        $this->form_validation->set_rules('sku', 'Referencia', 'trim|required|xss_clean');
        $this->form_validation->set_error_delimiters('<div class="form-group has-error"><label><i class="fa fa-warning"></i> ', '</label></div>');

        $this->form_validation->set_message('required', '%s obligatorio.');
        $this->form_validation->set_message('min_length', '%s tiene que tener como mínimo %s carácteres.');
        $this->form_validation->set_message('max_length', '%s tiene que tener como máximo %s carácteres.');

        $this->data['categorias']=$this->categorias->getCategorias();
        $this->data['colores']=$this->colores->getColores();
        $this->data['languages'] = $this->idiomas->getIdiomas();

        
        if ($this->form_validation->run() == FALSE) {
            if($this->productos->existeTraduccion($this->uri->segment(5),$this->uri->segment(4))==0)//si no existe la traduccion
            {
                $this->data['producto']=$this->productos->comunProducto($this->uri->segment(4));
            }
            $this->view = 'cms/productos/add';
        } else {

            $miproducto=array(
                'sku'=> $this->input->post('sku'),
                'precio' => $this->input->post('precio'),
                'fk_categoria' => $this->input->post('categoria'),
                'nombre'=> $this->input->post('nombre'),
                'descripcion' => $this->input->post('descripcion'),
                'fk_idioma' => $this->input->post('idioma'),
                'fk_color'=>$this->input->post('color')
            );
            

            if ($this->uri->segment(3) == 'add' && $this->uri->segment(4) != NULL && $this->uri->segment(5) != NULL) { //EDITANDO o traduccion
                $filas=$this->productos->existeTraduccion($miproducto['fk_idioma'], $this->uri->segment(4));
                if ($filas > 0) {
                    //Editando
                    $id_producto = $this->productos->editProducto($this->uri->segment(4), $miproducto);
                    $this->session->set_userdata('valido', 'Producto editado correctamente.');
                } else {
                    //añadir traduccion
                    $id_producto = $this->productos->addProducto($this->uri->segment(4), $miproducto);
                    $this->session->set_userdata('valido', 'Traducción insertada correctamente.');
                }
            } else {//NUEVO PRODUCTO
                $id_producto = $this->productos->addProducto('', $miproducto);
                $this->session->set_userdata('valido', 'Producto insertado correctamente.');

            }

            redirect('cms/productos');
        }
    }
    
//    function _categoria_check($str)
//    {
//        if ($str == '-')
//        {
//            $this->form_validation->set_message('categoria_check', 'Debe selecionar una categoría');
//            return FALSE;
//        }
//        else
//        {
//            return TRUE;
//        }
//    }
    
    
     public function edit() {
        $id = $this->uri->segment(4);
        $idioma = $this->uri->segment(5);
        $this->data['producto'] = $this->productos->verProducto($id, $idioma);
        $this->data['categorias']=$this->categorias->getCategorias();
        $this->data['colores']=$this->colores->getColores();
        $this->data['languages'] = $this->idiomas->getIdiomas();
        $this->view = 'cms/productos/add';
    }
    
    public function delete() {
        $id = $this->uri->segment(4);
        $idioma = $this->uri->segment(5);
        $delete = $this->productos->deleteProducto($id, $idioma);
        if ($delete == TRUE) {
            $this->session->set_userdata('valido', 'Producto eliminado correctamente.');
        } else {
            $this->session->set_userdata('novalido', 'No se ha podido eliminar el producto.');
        }

        redirect('cms/productos');
    }
    
    
    function filtrar() {
        $idioma = $this->input->post('idioma');
        $this->data['productos'] = $this->productos->getProductos($idioma);
        $this->data['languages'] = $this->idiomas->getIdiomas();
        $this->session->set_userdata('idioma', $idioma);
        // redirect('cms/categorias');
        $this->view = 'cms/productos/index';
    }
    
   
}
