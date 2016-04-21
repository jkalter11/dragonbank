<?php
/**
 * name.php Controller Class.
 */
class Name extends Application {

    function __construct(){
        parent::__construct();
    }
    
    function index(){
        $this->data['pagebody']  = 'name';
        $this->data['pagetitle'] = 'Dragon Bank | Name ';
        $this->render();
    }
}

/* End of file name.php */
/* Location: ./application/controllers/name.php */