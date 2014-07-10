<?php

if (!defined('BASEPATH'))
    exit('No permitir el acceso directo al script');

class Categorias extends MY_Controller {

    protected $models = array('categorias','idiomas');
    protected $asides = array();

    function __construct() {
        parent::__construct();
    }

    function index() {
        // $this->data['titulo'] = "Categorías";
        // $this->data['subtitulo']="Administrar categorías";  
        $this->data['languages'] = $this->idiomas->getIdiomas();
        $this->data['categorias'] = $this->categorias->getCategorias('1');
    }

    function filtrar() {
        $idioma = $this->input->post('idioma');
        $this->data['categorias'] = $this->categorias->getCategorias($idioma);
        $this->data['languages'] = $this->idiomas->getIdiomas();
        $this->session->set_userdata('idioma', $idioma);
        // redirect('cms/categorias');
        $this->view = 'cms/categorias/index';
    }

    function add() {

        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|min_length[3]|max_length[100]|required|xss_clean');
        $this->form_validation->set_rules('descripcion', 'Descripción', 'trim|min_length[25]|max_length[500]|required|xss_clean');
        $this->form_validation->set_error_delimiters('<div class="form-group has-error"><label><i class="fa fa-warning"></i> ', '</label></div>');

        $this->form_validation->set_message('required', '%s obligatorio.');
        $this->form_validation->set_message('min_length', '%s tiene que tener como mínimo %s carácteres.');
        $this->form_validation->set_message('max_length', '%s tiene que tener como máximo %s carácteres.');

        $this->data['languages'] = $this->idiomas->getIdiomas();
        if ($this->form_validation->run() == FALSE) {
            
            $this->view = 'cms/categorias/add';
        } else {


            $data = array(
                'nombre' => $this->input->post('nombre'),
                'descripcion' => $this->input->post('descripcion'),
                'fk_idioma' => $this->input->post('idioma')
            );

            if ($this->uri->segment(3) == 'add' && $this->uri->segment(4) != NULL && $this->uri->segment(5) != NULL) { //EDITANDO o traduccion
                $filas=$this->categorias->existeTraduccion($data['fk_idioma'], $this->uri->segment(4));
                if ($filas > 0) {
                    //Editando
                    $id_categoria = $this->categorias->editCategoria($this->uri->segment(4), $data);
                    $this->session->set_userdata('valido', 'Categoría editada correctamente.');
                } else {
                    //añadir traduccion
                    $id_categoria = $this->categorias->addCategoria($this->uri->segment(4), $data);
                    $this->session->set_userdata('valido', 'Traducción insertada correctamente.');
                }
            } else {//NUEVA CATEGORIA
                $id_categoria = $this->categorias->addCategoria('', $data);
                $this->session->set_userdata('valido', 'Categoría insertada correctamente.');
                //  $this->session->set_userdata('idioma', $data['fk_idioma']);
            }

            redirect('cms/categorias');
        }
    }

    public function delete() {
        $id = $this->uri->segment(4);
        $idioma = $this->uri->segment(5);
        $delete = $this->categorias->deleteCategoria($id, $idioma);
        if ($delete == TRUE) {
            $this->session->set_userdata('valido', 'Categoría eliminada correctamente.');
        } else {
            $this->session->set_userdata('novalido', 'No se ha podido eliminar la categoría.');
        }

        redirect('cms/categorias');
    }

    public function edit() {
        $id = $this->uri->segment(4);
        $idioma = $this->uri->segment(5);
        $this->data['categoria'] = $this->categorias->verCategoria($id, $idioma);
        $this->data['languages'] = $this->idiomas->getIdiomas();
        $this->view = 'cms/categorias/add';
    }

}
