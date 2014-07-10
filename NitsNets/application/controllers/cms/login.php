<?php
if (!defined('BASEPATH'))
    exit('No permitir el acceso directo al script');

class Login extends MY_Controller {

    protected $models = array('login');
    protected $asides = array();

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->layout = 'layouts/login.php';
    }    
    
    public function log_in() {
        $this->layout = 'layouts/login.php';
        $this->form_validation->set_rules('password', 'Contraseña', 'trim|min_length[5]|max_length[12]|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_message('required', 'Obligatorio');
        $this->form_validation->set_message('min_length', 'Email o contraseña incorrectos6.');
        $this->form_validation->set_message('max_length', 'Email o contraseña incorrectos12.');


        if ($this->form_validation->run() == FALSE) {
           $this->view = 'cms/login/index';
        } else {
           //Comprovem  que el usuari y la contraseña coinsidix en algun usuari de la nostra base de datos
            $email = $this->input->post('email');
            $pass = $this->input->post('password');
            $valido=$this->login->validate_user($email,$pass);
            if($valido)
            {
                //$this->view = 'cms/dashboard/index';
                redirect('cms/dashboard');
            }
            else
            {   //El usuario no existe  
                $this->session->set_userdata('novalido','Email o contraseña incorrectos12222.');
                $this->view = 'cms/login/index';                
            }          
        }
    }
    
    public function logout()
    {     
        $this->login->logout();
        redirect('/');
    }

  
}
