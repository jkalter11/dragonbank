<?php
class Webservice
{
	var $con1 = false;
	var $con2 = false;
	var $db1='dragonbank_live';
	var $db2=''; 
	
	
	/***************************** database connectivity   ***************************/
	function __construct (){
		header('Content-type: application/json');
		//include('function.php');
		$this->con1=mysql_connect('103.15.67.74','pro1','123') or die('Cannot connect to the DB');
		if($this->con1){
			mysql_select_db($this->db1,$this->con1) or die('Cannot select the DB');
		}else{
			echo "connection not established";
		}
		if(isset($_REQUEST['apps_id'])){
			$this->getAppDB($_REQUEST['key']);
		}else{
			if(isset($_SESSION['appDBconnection'])){
				$this->con2= $_SESSION['appDBconnection'];
				$this->db2= $_SESSION['appDB'];
			}
		}
	}
	
		function accesscode_varify(){
		
	  if($_REQUEST['code'])
        {
       		$sql="select * from codes where `codename` = '".$_REQUEST['code']."' and `status`='1'"; 
			$page_rs = mysql_query($sql);
		    $page_num = mysql_num_rows($page_rs);
			if($page_num == 0){ 
				$post="Access Code Not Found.";
				$posts = array('success'=>'0','msg'=>$post);
			}
			else
			{
				$result=array();
				//print_r(mysql_fetch_assoc($page_rs));
				while($row = mysql_fetch_assoc($page_rs))
		   		{
		   		 		$result[] = array('id'=>$row['id'],
			  			'codename'=>$row['codename'],
			  			'advicer_id'=>$row['advisor_id']);
		   		}
		   		$post="Description.";
		   		$posts = array('success'=>'1','msg'=>$post,'result'=>$result);	
		   	}
		  
		}
		echo json_encode($posts);
  	}
	
}
////End of class
	$method = $_REQUEST['method'];
	$obj = new Webservice();
	switch ($method){	
		case 'accesscode_varify':
		echo $obj->accesscode_varify();
		break;

	} 

?>
