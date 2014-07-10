<?php
if (!defined('BASEPATH'))
    exit('No permitir el acceso directo al script');

class Colores extends MY_Controller {

    protected $models = array('colores','idiomas');
    protected $asides = array();

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->data['colores'] = $this->colores->getColores('1');
        $this->data['languages'] = $this->idiomas->getIdiomas();
    }
    
    function add() {

        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|min_length[3]|max_length[100]|required|xss_clean');
        $this->form_validation->set_error_delimiters('<div class="form-group has-error"><label><i class="fa fa-warning"></i> ', '</label></div>');

        $this->form_validation->set_message('required', '%s obligatorio.');
        $this->form_validation->set_message('min_length', '%s tiene que tener como mínimo %s carácteres.');
        $this->form_validation->set_message('max_length', '%s tiene que tener como máximo %s carácteres.');

        $this->data['languages'] = $this->idiomas->getIdiomas();
        if ($this->form_validation->run() == FALSE) {
            
            $this->view = 'cms/colores/add';
        } else {


            $data = array(
                'nombre' => $this->input->post('nombre'),
                'fk_idioma' => $this->input->post('idioma')
            );

            if ($this->uri->segment(3) == 'add' && $this->uri->segment(4) != NULL && $this->uri->segment(5) != NULL) { //EDITANDO o traduccion
                $filas=$this->colores->existeTraduccion($data['fk_idioma'], $this->uri->segment(4));
                if ($filas > 0) {
                    //Editando
                    $id_color = $this->colores->editColor($this->uri->segment(4), $data);
                    $this->session->set_userdata('valido', 'Color editado correctamente.');
                } else {
                    //añadir traduccion
                    $id_color = $this->colores->addColor($this->uri->segment(4), $data);
                    $this->session->set_userdata('valido', 'Traducción insertada correctamente.');
                }
            } else {//NUEVO COLOR
                $id_color = $this->colores->addColor('', $data);
                $this->session->set_userdata('valido', 'Color insertado correctamente.');
            }

            redirect('cms/colores');
        }
    }
    
    function filtrar() {
        $idioma = $this->input->post('idioma');
        $this->data['colores'] = $this->colores->getColores($idioma);
        $this->data['languages'] = $this->idiomas->getIdiomas();
        $this->session->set_userdata('idioma', $idioma);
        $this->view = 'cms/colores/index';
    }
    
    
    public function edit() {
        $id = $this->uri->segment(4);
        $idioma = $this->uri->segment(5);
        $this->data['color'] = $this->colores->verColor($id, $idioma);
        $this->data['languages'] = $this->idiomas->getIdiomas();
        $this->view = 'cms/colores/add';
    }
    
    public function delete() {
        $id = $this->uri->segment(4);
        $idioma = $this->uri->segment(5);
        $delete = $this->colores->deleteColor($id, $idioma);
        if ($delete == TRUE) {
            $this->session->set_userdata('valido', 'Color eliminado correctamente.');
        } else {
            $this->session->set_userdata('novalido', 'No se ha podido eliminar el color.');
        }

        redirect('cms/colores');
    }
    
   
}
