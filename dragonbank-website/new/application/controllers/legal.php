<?php
/**
 * legal.php Controller Class.
 */
class Legal extends Application {

    function __construct(){
        parent::__construct();
    }
    
    function index(){
        $this->data['pagebody']  	= 'v2/legal';
        $this->data['pagetitle'] 	= 'Legal ';
		$this->data['keys']			= 'dragon, dragonbank, children, saving, spending, giving, den, money, how';
		$this->data['desc']			= 'Dragon bank cares about their users. Legal documents protect their users and children.';
        $this->render();
    }
}

/* End of file legal.php */
/* Location: ./application/controllers/legal.php */