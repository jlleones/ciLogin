<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MLogin extends CI_Model {

    public $Modal;

    public function __construct() {
        parent::__construct();
    }

    /* function to use fetch the data from users table */

    function validate($user, $pass) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('password', $pass);
        $this->db->where('username', $user);
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }

    public function AddUser($data){

        if($this->db->insert('users', $data)){
            return $this->db->insert_id();
        }
        else{
            return 0;
        }
    }

}
