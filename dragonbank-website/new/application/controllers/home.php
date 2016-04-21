<?php
/**
 * home.php Controller Class.
 */
class Home extends Application {

    function __construct(){
        parent::__construct();
    }
    
    function index(){
        $this->data['pagebody']  	= 'v2/home';
        $this->data['pagetitle'] 	= 'Dragon Bank - Save, Spend, Give';
		$this->data['keys']			= 'dragon, dragonbank, children, saving, spending, giving, den, money, how';
		$this->data['desc']			= 'The Dragon Bank is a fantastic investment in your child’s financial future start saving the Dragon Way TODAY!';
        $this->render();
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */