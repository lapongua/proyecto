<?php

if (!defined('BASEPATH'))
    exit('No permitir el acceso directo al script');

class Login_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

   function validate_user($email, $password) {
        // Build a query to retrieve the user's details
        // based on the received username and password
        $this->db->from('usuarios');
        $this->db->where('email', $email);
        $this->db->where('contrasenya', sha1($password));
        $login = $this->db->get()->result();

        // The results of the query are stored in $login.
        // If a value exists, then the user account exists and is validated
        if (is_array($login) && count($login) == 1) {
            // Set the users details into the $details property of this class
            $this->details = $login[0];
            // Call set_session to set the user's session vars via CodeIgniter
            $this->set_session();
            return true;
        }

        return false;
    }

    function set_session() {
        if ($this->details->rol == 'administrador') {
            $admin = true;
        } else {
            $admin = false;
        }

        $this->session->set_userdata(array(
            'id' => $this->details->id,
            'name' => $this->details->nombre,
            'fullname' => $this->details->nombre . ' ' . $this->details->apellidos,
            'email' => $this->details->email,
            'isAdmin' => $admin,
            'isLoggedIn' => true
                )
        );
    }

    function logout() {
        $user_data = $this->session->all_userdata();
        foreach ($user_data as $key => $value) {
            if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
                $this->session->unset_userdata($key);
            }
        }
        $this->session->sess_destroy();      
    }
}
