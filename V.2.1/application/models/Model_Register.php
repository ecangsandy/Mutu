<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Register extends CI_Model{

  public function insert($value)
  {
    $this->db->insert('MASTER_USER', $value);
    return true;
  }
}
