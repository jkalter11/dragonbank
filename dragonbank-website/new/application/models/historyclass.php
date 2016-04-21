<?php

class Historyclass extends _Mymodel {

    /**
     * Constructor to create instance of DB object
     */
    public function __construct(){
        parent::__construct();
        $this->setTable('history','history_id');
    }

	public function getHistory( $cid = 0 )
	{
		$cid = (int)$cid;
		
		return $this->getWhere_array("history_child_id", $cid, "*", "history_id");
	}
	
	public function getSaveHistory( $cid = 0 )
	{
		return $this->getOneWhere("history_child_id", (int)$cid, "save_history, save_balance, transaction, desc" );
	}
	
	public function getGiveHistory( $cid = 0 )
	{
		return $this->getOneWhere("history_child_id", (int)$cid, "give_history, give_balance, transaction, desc");
	}
	
	public function getSpendHistory( $cid = 0 )
	{
		return $this->getOneWhere("history_child_id", (int)$cid, "spend_history, spend_balance, transaction, desc");
	}
	
	public function getBalanceHistory( $cid = 0 )
	{
		return $this->getOneWhere("history_child_id", (int)$cid, "balance, debit, credit, transaction, desc");
	}
	
	public function getRecentDate( $where )
	{
		return $this->getOneWhere( $where, NULL, 'transaction, date', 1, "history_id DESC" );
	}
	
	public function searchHistory($start = 0, $end = 0, $child_id = 0)
	{
		$where = array();
		
		if( $start !== 0 )
		{
			$where['date >='] = $start;
		}
		
		if( $end !== 0 )
		{
			$where['date <='] = $end;
		}
		
		if( $child_id > 0 )
		{
			$where['history_child_id'] = $child_id;
		}

		return $this->getWhere_array( $where, NULL);
	}
}