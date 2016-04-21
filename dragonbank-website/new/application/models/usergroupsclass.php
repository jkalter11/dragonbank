<?php

class Usergroupsclass extends _Mymodel{

    /**
     * Constructor to create instance of DB object
     */
    public function __construct(){
        parent::__construct();
        $this->setTable('user_groups','group_id');
    }
    
    // Get group by id and return name.
    function getGroup($id){
        $row = $this->get($id);
        
        return $row->user_group;
    }
    
}   
?>