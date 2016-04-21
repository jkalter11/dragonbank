<?php

class Wishlistclass extends _Mymodel {

	/**
	 * Constructor to create instance of DB object
	 */
	public function __construct(){
		parent::__construct();
		$this->setTable('wishlist');
	}

	public function getCount()
	{
		return $this->size();
	}

	public function getWishlistByChildID($id)
	{
		$this->db->where('child_id', $id);
		$this->db->order_by('date ASC, item ASC');
		$results = $this->db->get($this->_tableName);
		return $results->result();
	}

	public function saveWishlist($id, $item, $cost)
	{
		$data = array(
    		'child_id' => $id,
			'item' => $item,
			'cost' => $cost,
			'date' => time()
		);

		$this->db->insert($this->_tableName, $data);
	}
}