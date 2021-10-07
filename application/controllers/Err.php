<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Err extends CI_Controller {

    public function index()
    {
        $data['content']   = 'errors/not_found';
        $this->load->view('Theme',$data);
    }

}

/* End of file Err.php */
