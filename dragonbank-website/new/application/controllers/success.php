<?php
/**
 * success.php Controller Class.
 */
class Success extends Application {

    function __construct(){
        parent::__construct();
    }
    
    function index(){
        $this->data['pagebody']  = 'v2/success';
        $this->data['pagetitle'] = 'Dragon Bank | Success ';
        $this->render();
    }
}

/* End of file success.php */
/* Location: ./application/controllers/success.php */