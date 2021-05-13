<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        /* Load MLogin model*/
        $this->load->model('mlogin');


        
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('form_validation');

    }

    public function index() {
        /* Load the login screen, if the user is not log in */
        $this->load->library('encryption');
        $this->load->database();

        if (isset($_SESSION['login']['id'])) { 
            $this->load->view('dashboard');
        } else {
            /* if not, display the login window */
            $this->load->view('login');
        }
    }

    public function dashboard() {
        /* Load the dashboard screen, if the user is already log in */
        if (isset($_SESSION['login']['id'])) {
            $this->load->view('dashboard');
        } else {
            $this->load->view('login');
        }
    }

    public function register() {
        /* Load the dashboard screen, if the user is already log in */
        if (isset($_SESSION['login']['id'])) {
            $this->load->view('login');
        } else {
            $this->load->view('register');

        }
    }

    function getLogin() {
        /* Data that we receive from ajax */
        $username = $this->input->post('UserName');
        $Password = $this->input->post('Password');
        if (!isset($username) || $username == '' || $username == 'undefined') {
            /* If Username that we recieved is invalid, go here, and return 2 as output */
            echo 2;
            exit();
        }
        if (!isset($Password) || $Password == '' || $Password == 'undefined') {
            /* If Password that we recieved is invalid, go here, and return 3 as output */
            echo 3;
            exit();
        }
        $this->form_validation->set_rules('UserName', 'UserName', 'required');
        $this->form_validation->set_rules('Password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            /* If Both Username &  Password that we recieved is invalid, go here, and return 4 as output */
            echo 4;
            exit();
        } else {
            /* Create object of model MLogin.php file under models folder */
            $Login = new MLogin();
            /* validate($username, $Password) is the function in Mlogin.php */
            $result = $Login->validate($username, $Password);
            if (count($result) == 1) {
                /* If everything is fine, then go here, and return 1 as output and set session */
                $data = array(
                    'id' => $result[0]->id,
                    'username' => $result[0]->username
                );
                $this->session->set_userdata('login', $data);
                echo 1;
            } else {
                /* If Both Username &  Password that we recieved is invalid, go here, and return 5 as output */
                echo 5;
            }
        }
    }

    public function create_user(){
        $insert = new MLogin();
        if($_POST){
            $user_fullname = $this->input->post('fullname');
            $user_username = $this->input->post('username');
            $user_password = $this->input->post('password');
            $new_user_insert_data = array(
                'fullname' => $user_fullname,
                'username' => $user_username,
                'password' => $user_password,
            );
            $insert_result = $insert->AddUser($new_user_insert_data);
            if($insert_result > 0){
                $message = array(
                    'status' => true,
                    'title' => 'Registration Done',
                    'message' => 'Registration successfully done',
                    'val' => $insert_result
                );
            }
            else{
                $message = array(
                    'status' => false,
                    'title' => 'Error',
                    'message' => 'Something wrong',
                    'val' => $insert_result
                );
            }
        }
        else{
           $message = array(
                'status' => false,
                'title' => 'Error',
                'message' => 'Please Fill all the required files',
            );
        }
        echo json_encode($message);
    }
}
