<?php

/**
 * models/mymodel.php
 *
 * Generic domain model.
 *
 * Intended to model both a single domain entity as well as a table.
 * This is consistent with CodeIgniter's interpretation of the Active Record
 * pattern, even though some of the functions are at the table level
 * while others are at the record level :-/
 *
 * Each such model is bound to a specific database table, using a designated
 * key field as the associative array index internally.
 *
 * @author	        RLR
 * @copyright           2013-2014, Ron L. Ross
 * ------------------------------------------------------------------------
 */
class _Mymodel extends CI_Model {

	var $_tableName;            // Which table is this a model for a row of?
	var $_keyField;                 // name of the primary key field

	// Constructor

	function __construct() {
		parent::__construct();
		$this->_tableName = strtolower( str_replace( "class", '', get_class($this) ) );
	}

	//---------------------------------------------------------------------------
	//  Table management functions
	//---------------------------------------------------------------------------
	// Load contents from & associate this object with a table
	function setTable($table, $key='id') {
		// prime our state
		$this->_tableName = $table;
		$this->_keyField = $key;
	}

	// Return the field names in this table
	function getFields() {
		return $this->db->list_fields($this->_tableName);
	}

	//---------------------------------------------------------------------------
	//  Record-oriented functions
	//---------------------------------------------------------------------------
	// Create a new data object.
	// Only use this method if intending to create an empty record and then populate it.
	function create() {
		$names = $this->db->list_fields($this->_tableName);
		$object = array();
		foreach ($names as $name)
			$object[$name] = "";
		return (object) $object;
	}

	// Retrieve an existing DB record as an object
	function get($key) {
		$this->db->where($this->_keyField, $key);
		$query = $this->db->get($this->_tableName);
		if ($query->num_rows() < 1)
			return null;
		return $query->row();
	}

	// Retrieve one db record and return single variable.
	function getVar($where, $what = null, $return = null){
		if(is_array($where))
			$this->db->where($where);
		else
			$this->db->where($this->_keyField, $key);
		$query = $this->db->get($this->_tableName);
		if ($query->num_rows() < 1)
			return null;
		return $query->row();
	}

	// Return all records as an array of associative arrays
	function getOneWhere($what, $which = null, $select = null, $limit = null, $order = null) {
		if($select != null)
			$this->db->select($select);

		if($this->_keyField != '' && $order == null)
			$this->db->order_by($this->_keyField, 'asc');
		elseif( is_string($order) )
			$this->db->order_by($order);


		if (($what == 'period') && ($which < 9)) {
			$this->db->where($what, $which); // special treatment for period
		} elseif(is_array($what)){
			$this->db->where($what);
		} else {
			$this->db->where($what, $which);
		}
		if($limit == null)
			$query = $this->db->get($this->_tableName);
		else
			$query = $this->db->get($this->_tableName, $limit);

		if ($query->num_rows() < 1)
			return FALSE;

		if($query->num_fields() > 1)
			return $query->row();

		// Returns a single variable.
		foreach($query->row() as $val)
			return $val;
	}

	// Retrieve an existing DB record as an associative array
	function get_array($key) {
		$this->db->where($this->_keyField, $key);
		$query = $this->db->get($this->_tableName);
		if ($query->num_rows() < 1)
			return null;
		// using a bogus iterator to get the first row
		foreach ($query->result_array() as $row)
			return $row;
	}

	// Add a record to the DB
	function add($record) {
		// convert object to associative array, if needed
		if (is_object($record)) {
			$data = get_object_vars($record);
		} else {
			$data = $record;
		}

		$this->db->insert($this->_tableName, $data);

		return $this->db->insert_id();
	}

	// Add a record to the DB
	function batch_add($record) {
		// convert object to associative array, if needed
		if (is_object($record)) {
			$data = get_object_vars($record);
		} else {
			$data = $record;
		}

		return $this->db->insert_batch($this->_tableName, $data);
	}

	// Update a record in the DB
	function update($record, $which = null, $set = null) {

		// convert object to associative array, if needed
		if (is_object($record)) {
			$data = get_object_vars($record);
		} else {
			$data = $record;
		}

		// update the DB table appropriately
		$key = $data[$this->_keyField];

		$this->db->where($this->_keyField, $key);

		if( $set != null && $which != null ){
			$this->db->set( $which, $set, FALSE );
			return $this->db->update( $this->_tableName );
		}

		$this->db->update($this->_tableName, $data);

		return $key;
	}

	function updateSet( $which = null, $set = null, $where = null ){

		if( $set == null || $which == null || $where == null )
			return false;

		$this->db->where($where);

		$this->db->set( $which, $set, FALSE );

		return $this->db->update( $this->_tableName );
	}

	// Update a record in the DB
	function updateWhere($record, $where = null, $which = null) {

		// convert object to associative array, if needed
		if (is_object($record)) {
			$data = get_object_vars($record);
		} else {
			$data = $record;
		}

		if($where == null){
			// update the DB table appropriately
			$key = $data[$this->_keyField];
			$this->db->where($this->keyField, $key);
		} else if (is_array($where) ) {
			$this->db->where($where);
		} else {
			$this->db->where($where, $which);
		}

		return $this->db->update($this->_tableName, $data);
	}

	// Update a record in the DB
	function updateBatchWhere($records, $where) {
		return $this->db->update_batch($this->_tableName, $records, $where);
	}

	// Update records' order in the DB
	function updateOrder($ids, $col){
		// convert object to associative array, if needed
		if (is_object($ids)) {
			$data = get_object_vars($ids);
		} else {
			$data = $ids;
		}

		$i = 1;

		// Updates order.
		foreach($data as $key){
			$this->db->where($this->_keyField, $key);
			if( ! $this->db->update( $this->_tableName, array( $col => $i++ ) ) )
				return false;
		}

		return true;
	}

	// Delete a record from the DB
	function delete($key) {
		$this->db->where($this->_keyField, $key);
		return $this->db->delete($this->_tableName);
	}

	// Delete all record from the DB
	function deleteAll() {
		return $this->db->empty_table($this->_tableName);
	}

	// Determine if a key exists
	function exists($key) {
		$this->db->where($this->_keyField, $key);
		$query = $this->db->get($this->_tableName);
		if ($query->num_rows() < 1)
			return false;
		return true;
	}

	// Determine if a key exists
	function existsWhere($where,$which) {
		if(is_array($where))
			$this->db->where($where);
		else
			$this->db->where($where, $which);
		$query = $this->db->get($this->_tableName);
		if ($query->num_rows() < 1)
			return false;
		return true;
	}

	//---------------------------------------------------------------------------
	//  Aggregate functions
	//---------------------------------------------------------------------------
	// Return all records as an array of objects
	function getAll() {
		if($this->_keyField != '')
			$this->db->order_by($this->_keyField, 'asc');
		$query = $this->db->get($this->_tableName);
		return $query->result();
	}

	// Return all records as an array of associative arrays
	function getWhere($what, $which = null, $select = null) {
		if($select != null)
			$this->db->select($select);
		if($this->_keyField != '')
			$this->db->order_by($this->_keyField, 'asc');
		if (($what == 'period') && ($which < 9)) {
			$this->db->where($what, $which); // special treatment for period
		} elseif(is_array($what)){
			$this->db->where($what);
		} else {
			$this->db->where($what, $which);
		}
		$query = $this->db->get($this->_tableName);
		return $query->result();
	}

	// Return all records as an array of associative arrays
	function getAll_array($order = null, $select = null) {
		if($select != null)
			$this->db->select($select);
		if((!is_array($order)) && $this->_keyField != '' && $order == null){
			$this->db->order_by($this->_keyField, 'asc');
		} else if(is_array($order)){
			foreach($order as $ord)
				$this->db->order_by($ord['key'], $ord['order']);
		} else if($order != null && is_string($order)){
			$this->db->order_by($order);
		}
		$query = $this->db->get($this->_tableName);
		return $query->result_array();
	}

	// Return all records as an array of associative arrays
	function getWhere_array($what, $which, $select = null, $order = null, $limit = null, $start = null) {
		if($select != null)
			$this->db->select($select);

		if($this->_keyField != '' && $order == null){
			$this->db->order_by($this->_keyField, 'asc');
		} else if($order != null) {
			$this->db->order_by($order, 'asc');
		}

		if (($what == 'period') && ($which < 9)) {
			$this->db->where($what, $which); // special treatment for period
		} else if(is_array($what)){
			$this->db->where($what);
		} else {
			$this->db->where($what, $which);
		}

		if( $limit !== null && $start !== null )
		{
			$query = $this->db->get($this->_tableName, $limit, $start);
		}
		else
		{
			$query = $this->db->get($this->_tableName);
		}

		return $query->result_array();
	}

	// Return all records as a result set
	function queryAll() {
		if($this->_keyField != '')
			$this->db->order_by($this->_keyField, 'asc');
		$query = $this->db->get($this->_tableName);
		return $query;
	}


	// Return the # of filtered records in a table
	function countWhich($where, $what = NULL) {

		if( $what != NULL)
		{
			$this->db->select($what);
		}

		$this->db->where($where);

		$query = $this->db->get($this->_tableName);

		return $query->num_rows();
	}

	// Return filtered records as a result set
	function querySome($what, $which) {
		if($this->_keyField != '')
			$this->db->order_by($this->_keyField, 'asc');
		if (($what == 'period') && ($which < 9)) {
			$this->db->where($what, $which); // special treatment for period
		} else
			$this->db->where($what, $which);
		$query = $this->db->get($this->_tableName);
		return $query;
	}

	function getJoin_array($table, $where, $select = null, $order = null, $type = null, $where_clause = null, $limit = 0){

		if(is_array($table) && is_array($where) && is_array($type) )
		{
			foreach( $table as $k => &$v )
			{
				$this->db->join($v, $where[ $k ], $type[ $k ]);
			}
		}
		elseif( $table != '' && is_string($table) && $where != null )
		{
			$this->db->join($table, $where, "LEFT OUTER");
		}

		if( $where_clause != null )
		{
			$this->db->where( $where_clause );
		}

		if($select != null)
			$this->db->select($select);

		if($this->_keyField != '' && $order == null){
			$this->db->order_by($this->_keyField, 'asc');

		} elseif($order != null){
			$this->db->order_by($order, 'asc');
		}

		if( is_array( $limit ) && isset( $limit['amount'] ) && isset($limit['offset']) )
		{
			$this->db->limit( $limit['amount'], $limit['offset'] );
		}

		$query = $this->db->get($this->_tableName);

		return $query->result_array();
	}

	function getUnion_array($table1, $table2, $select1, $select2, $where1 = '', $where2 = '', $order = null){

		// Dont' feel like dealing with arrays
		if( ( ! is_string($where1) ) || ( ! is_string($where2) ) )
			return false;

		if($where1 == null)
			$where1 = '';
		else
			$where1 = " WHERE ".$where1;

		if($where2 == null)
			$where2 = '';
		else
			$where2 = " WHERE ".$where2;

		// CodeIgniter does not support UNION, so created my own query.
		$query = $this->db->query("SELECT ".$select1." FROM ".$table1.$where1." UNION DISTINCT SELECT ".$select2." FROM ".$table2.$where2." ORDER BY ".$order);

		return $query->result_array($query);
	}

	function getJoinWhere_array($table, $join, $where = null, $select = null, $order = null){

		if($table != '' && is_string($table) && $where != null )
			$this->db->join($table, $join);
		else
			return false;

		if($select != null)
			$this->db->select($select, false);

		if($where != null)
			$this->db->where($where);

		if($this->_keyField != '' && $order == null){
			$this->db->order_by($this->_keyField, 'asc');
		} elseif($order != null){
			$this->db->order_by($order, 'asc');
		}

		$query = $this->db->get($this->_tableName);

		return $query->result_array();
	}

	function getMultiJoin_array($join, $where = null, $select = null, $order = null, $dup_tables = NULL, $limit = array()){

		if( is_array( $join ) )
		{
			// $k = table & $v = condition.
			foreach( $join as $k => $v )
			{
				$this->db->join($k, $v);
			}

			if( is_array( $dup_tables ) ) {
				// $k = table & $v = condition.
				foreach( $dup_tables as $k => $v )
				{
					$this->db->join($k, $v);
				}
			}
		}

		if($select != null)
			$this->db->select($select, false);
		else
			$this->db->select("*");

		if($where != null)
			$this->db->where($where);

		if($this->_keyField != '' && $order == null){
			$this->db->order_by($this->_keyField, 'asc');
		} elseif($order != null){
			$this->db->order_by($order, 'asc');
		}

		if( is_array( $limit ) && isset( $limit['amount'] ) && isset($limit['offset']) )
		{
			$this->db->limit( $limit['amount'], $limit['offset'] );
		}

		$query = $this->db->get($this->_tableName);

		return $query->result_array();
	}

	// Return the number of records in this table
	function size() {
		$query = $this->db->get($this->_tableName);
		return $query->num_rows();
	}

	// Returns the max record.
	function getMax($which, $where = null, $what = null){
		$this->db->select("MAX(".$which.")");

		if($where != null){
			if(is_array($where)){
				$this->db->where($where);
			} else {
				$this->db->where($where, $what);
			}
		}

		// Get only 1.
		$query = $this->db->get($this->_tableName, 1);

		// Returns a single variable.
		foreach($query->row() as $val)
			return $val;
	}

	function sumWhich( $what, $where = NULL, $alias = FALSE )
	{
		if( is_array( $what ) )
		{
			foreach( $what as $k => $v )
			{
				if( $alias === TRUE )
				{
					$this->db->select_sum($v, $k);
				}
				else
				{
					$this->db->select_sum($v);
				}
			}
		}
		else
		{
			$this->db->select_sum($what);
		}

		if( $where != NULL )
			$this->db->where( $where );

		$query = $this->db->get($this->_tableName);

		return $query->result_array();
	}

	// Does this field exist?
	function fieldExists( $field, $value ){
		return ! ( ! $this->getOneWhere( $field, $value, $field ) );
	}
}



/* End of file Mymodel.php */
/* Location: application/models/mymodel.php */