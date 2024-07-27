<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Super extends CI_Controller {

    public function hello() {
        echo json_encode(array("message" => "Hello"));
    }
}
