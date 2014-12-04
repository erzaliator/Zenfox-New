<?php
//TODO Make it as simple as possible


class Zenfox_Paginator_Adapter_DoctrineQuery implements Zend_Paginator_Adapter_Interface {
	protected $_query;
	protected $_count_query;
	protected $_conns;
	protected $_session;
	protected $_totalFetchResults;
	
	public function __construct($query, $partitionKey, $session = NULL) {
		$this->_session = $session;
		$this->_query = $query;
		$this->_conns = Zenfox_Partition::getInstance ()->getConnections ( $partitionKey );
	}
	
	/*
     * Return the final result
     * TODO
     * Write a function to get the result only from a particular partition
     * partitionkey is given
     */
	public function getItems($offset, $itemsPerPage) {
		if (is_array ( $this->_conns )) {
			//Get the total no of results that have to be fetched
			$this->_totalFetchResults = count ( $this->_conns ) * $itemsPerPage;
			if ($this->_session->value) {
				foreach ( $this->_session->value as $sConnection => $value ) {
					$store [$sConnection] = $value;
				}
			} else {
				$store = NULL;
			}
			//Get the position from where to display the data
			$number = $offset % $this->_totalFetchResults;
			$offset = floor ( $offset / $this->_totalFetchResults );
			$getAllData = $this->getFinalResult ( $offset, $itemsPerPage, 0, $store );
			//Result Array Index
			$rIndex = 0;
			for($index = $number; $index < ($number + $itemsPerPage); $index ++) {
				if (isset($getAllData [0] [$index])) {
					$result [$rIndex] = $getAllData [0] [$index];
				}
				$rIndex ++;
			}
		} else {
			$result = $this->getItemsFromPartition ( $this->_conns, $offset, $itemsPerPage );
		}
		return $result;
	}
	
	/*
     * This function checks if the result is already stored in session or not
     * return array
     */
	public function getFinalResult($offset, $itemsPerPage, $noOfResults, $store) {
		for($num = ($offset - 1); $num > 0; $num --) {
			if (! $this->_session->offset [$num]) {
				$callOffset = $offset - 1;
				;
				$this->getFinalResult ( $callOffset, $itemsPerPage, $noOfResults, $store );
				break;
			} else {
				break;
			}
		}
		$sessionData = "";
		if($num != -1)
		{
			$sessionData = $this->_session->offset [$num];
		}
		$result = $this->getResult ( $offset, $itemsPerPage, $noOfResults, $sessionData );
		return $result;
	}
	
	public function getResult($offset, $itemsPerPage, $noOfResults, $store) {
		$newOffset = $offset;
		$count = false;
		$i = 0;
		$final = array();
		foreach ( $this->_conns as $conn ) {
			//Check if offset it stored in session for the partition
			if (isset($store [$conn])) {
				$offset = $store [$conn];
			}
			$result = $this->getItemsFromPartition ( $conn, $offset, $itemsPerPage );
			//Store the number of results fetched in session
			//Used as offset
			if(isset($store [$conn]) && $store [$conn])
			{
				$store [$conn] += count ( $result );
			}
			else
			{
				$store [$conn] = count ( $result );
			}
			if ($result) {
				foreach ( $result as $data ) {
					$final [$i] = $data;
					$i ++;
				}
			}
			if (count ( $result )) {
				$count = true;
			}
			$noOfResults += count ( $result );
			if ($noOfResults == $this->_totalFetchResults) {
				$this->updateSession ( $newOffset, $store );
				return array ($final, $store );
			} elseif ($noOfResults > $this->_totalFetchResults) {
				$store [$conn] = $store [$conn] - ($noOfResults - $this->_totalFetchResults);
				$this->updateSession ( $newOffset, $store );
				return array ($final, $store );
			}
		}
		if (! $count) {
			return array ($final, $store );
		}
		if ($noOfResults < $this->_totalFetchResults) {
			$newItemsPerPage = $this->_totalFetchResults - $noOfResults;
			$getData = $this->getResult ( $newOffset, $newItemsPerPage, $noOfResults, $store );
			if ($getData [0]) {
				foreach ( $getData [0] as $data ) {
					$final [$i] = $data;
					$i ++;
				}
			}
			$store = $getData [1];
		}
		$this->updateSession ( $newOffset, $store );
		return array ($final, $store );
	}
	
	/*
     * This function update the session and store the offsets for the partitions
     */
	public function updateSession($offsetArrayIndex, $store) {
		$this->_session->value = $store;
		if ($this->_session->offset) {
			foreach ( $this->_session->offset as $index => $value ) {
				$offsetArray [$index] = $value;
			}
		}
		$offsetArray [$offsetArrayIndex] = $store;
		$this->_session->offset = $offsetArray;
	}
	
	public function getItemsFromPartition($conn, $offset = NULL, $itemsPerPage = NULL) {
		Doctrine_Manager::getInstance ()->setCurrentConnection ( $conn );
		$data = null;
		if ($itemsPerPage) {
			$str = $this->_query . "->offset($offset)" . "->limit($itemsPerPage);";
			eval ( "\$str=" . $str );
		} else {
			$str = $this->_query . ";";
			eval ( "\$str=" . $str );
		}
		try {
			//$data = $str->execute ( array (), Doctrine::HYDRATE_RECORD );
			$data = $str->fetchArray();
		} catch ( Exception $e ) {
		
		}
		if ($data) {
			return $data;
		}
		return NULL;
	}
	
	public function count() {
		$paginatorSession = new Zend_Session_Namespace ( 'paginationCount' );
		if (! $paginatorSession->value) {
			if (is_array ( $this->_conns )) {
				foreach ( $this->_conns as $conn ) {
					$result = $this->getItemsFromPartition ( $conn );
					$this->_count_query += count ( $result );
				}
			} else {
				$result = $this->getItemsFromPartition ( $this->_conns );
				$this->_count_query += count ( $result );
			}
		}
		$paginatorSession->value = true;
		return $this->_count_query;
	}
}
