<?php
/**
 * home.php Controller Class.
 */
class Home extends Application {

    function __construct(){
        parent::__construct();
        $this->load->helper('url');
    }
    
   function index()
   {
       echo "heloo";
   }

   
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */