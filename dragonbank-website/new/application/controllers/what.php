<?php
/**
 * what.php Controller Class.
 */
class What extends Application {

    function __construct(){
        parent::__construct();
    }
    
    function index(){
        $this->data['pagebody']  	= 'what';
        $this->data['pagetitle'] 	= 'What is the Dragon Bank';
		$this->data['keys']			= 'dragon, dragonbank, children, saving, spending, giving, den, money';
		$this->data['desc']			= 'Dragon Bank focus was to create a product that assists parents in teaching their children to save, spend, and give money.';
        $this->render();
    }
}

/* End of file what.php */
/* Location: ./application/controllers/what.php */