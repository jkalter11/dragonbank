<?php

class Common_model extends CI_Model
{
	function __construct(){
		
		parent::__construct();
		$this->load->database();
	}	
	
	function save($table, $data)
	{
		$this->db->insert($table, $data);
         
    return $this->db->insert_id();
	}

  function get_ad($table)
  {
    $this->db->select('*');
    $this->db->from($table);
    $query = $this->db->get();
    return $query;
  }
	
    
    function getalldata($table)
    {
       //$con=array('confirm'=>1);
      //$query = $this->db->get($table);
      $this->db->select('*');
      $this->db->from($table);
      $this->db->limit('10');
      $query = $this->db->get();
      
      //$query = $this->db->get();
      return $query;
    }

    function get_alldata($table)
    {
       
      $query = $this->db->get($table);
      
      return $query;
    }



    
	
	
	function update($table, $data, $col)
	{
		$this->db->where($col);
		
		$this->db->update($table, $data);
		// $this->db->last_query();
        //exit;
		return true;
	}
	
	function get_all_data($table, $limit = '')
    {
    	if(!empty($limit))
    		$this->db->limit($limit);
    	
        $query =$this->db->get($table);
        return $query;
    }
    
    
    
	
    function delete($table,$where)
	{
		$this->db->delete($table,$where); 
	}

	function get_count($table,$con)
	{
		 $query =$this->db->get_where($table,$con);
         return $query; 
	}
	
	  
}
