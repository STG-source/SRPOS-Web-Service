<?php

/**
 *  README for sample service
 *
 *  This generated sample service contains functions that illustrate typical service operations.
 *  Use these functions as a starting point for creating your own service implementation. Modify the 
 *  function signatures, references to the database, and implementation according to your needs. 
 *  Delete the functions that you do not use.
 *
 *  Save your changes and return to Flash Builder. In Flash Builder Data/Services View, refresh 
 *  the service. Then drag service operations onto user interface components in Design View. For 
 *  example, drag the getAllItems() operation onto a DataGrid.
 *  
 *  This code is for prototyping only.
 *  
 *  Authenticate the user prior to allowing them to call these methods. You can find more 
 *  information at http://www.adobe.com/go/flex_security
 *
 */
class SccrrbaseService {

	var $username = "root";
	var $password = "";
	var $server = "localhost";
	var $port = "3306";
	var $databasename = "srpos_cws";
	var $tablename = "_ccrr_base";

	var $connection;

	/**
	 * The constructor initializes the connection to database. Everytime a request is 
	 * received by Zend AMF, an instance of the service class is created and then the
	 * requested method is invoked.
	 */
	public function __construct() {
	  	$this->connection = mysqli_connect(
	  							$this->server,  
	  							$this->username,  
	  							$this->password, 
	  							$this->databasename,
	  							$this->port
	  						);

		$this->throwExceptionOnError($this->connection);
	}

	/**
	 * Returns all the rows from the table.
	 *
	 * Add authroization or any logical checks for secure access to your data 
	 *
	 * @return array
	 */
	public function getAll_ccrr_base() {

		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->listIndex, $row->saleNo, $row->CWS_index, $row->serviceUserID, $row->cardID, $row->reserveDuration, $row->CHKIN_DTE, $row->CHKOUT_DTE, $row->CHKOUT_ROLL, $row->CHKOUT_saleNo, $row->spentDuration, $row->CRE_USR, $row->CRE_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE, $row->Note);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CHKIN_DTE = new DateTime($row->CHKIN_DTE);
	      $row->CHKOUT_DTE = new DateTime($row->CHKOUT_DTE);
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->listIndex, $row->saleNo, $row->CWS_index, $row->serviceUserID, $row->cardID, $row->reserveDuration, $row->CHKIN_DTE, $row->CHKOUT_DTE, $row->CHKOUT_ROLL, $row->CHKOUT_saleNo, $row->spentDuration, $row->CRE_USR, $row->CRE_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE, $row->Note);
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
	}

	/**
	 * Returns the item corresponding to the value specified for the primary key.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function get_ccrr_baseByID($itemID) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename where listIndex=?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'i', $itemID);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_result($stmt, $row->listIndex, $row->saleNo, $row->CWS_index, $row->serviceUserID, $row->cardID, $row->reserveDuration, $row->CHKIN_DTE, $row->CHKOUT_DTE, $row->CHKOUT_ROLL, $row->CHKOUT_saleNo, $row->spentDuration, $row->CRE_USR, $row->CRE_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE, $row->Note);
		
		if(mysqli_stmt_fetch($stmt)) {
	      $row->CHKIN_DTE = new DateTime($row->CHKIN_DTE);
	      $row->CHKOUT_DTE = new DateTime($row->CHKOUT_DTE);
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      return $row;
		} else {
	      return null;
		}
	}

	/**
	 * Returns the item corresponding to the value specified for the primary key.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function create_ccrr_base_own($item) {

		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (saleNo, CWS_index, serviceUserID, cardID, reserveDuration, CHKIN_DTE, CHKOUT_DTE, CHKOUT_ROLL, CHKOUT_saleNo, spentDuration, CRE_USR, CRE_DTE, UPD_USR, UPD_DTE, DEL_USR, DEL_DTE, Note) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'sississisisssssss', $item->saleNo, $item->CWS_index, $item->serviceUserID, $item->cardID, $item->reserveDuration, 
		$item->CHKIN_DTE->toString('YYYY-MM-dd HH:mm:ss'), 
		$item->CHKOUT_DTE->toString('YYYY-MM-dd HH:mm:ss'), 
		$item->CHKOUT_ROLL, $item->CHKOUT_saleNo, $item->spentDuration, $item->CRE_USR, 
		$item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, 
		$item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, 
		$item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->Note);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		$autoid = mysqli_stmt_insert_id($stmt);

		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);

		return $autoid;
	}

	/**
	 * Updates the passed item in the table.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * @param stdClass $item
	 * @return void
	 */
	public function update_ccrr_base($item) {
	
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET saleNo=?, CWS_index=?, serviceUserID=?, cardID=?, reserveDuration=?, CHKIN_DTE=?, CHKOUT_DTE=?, CHKOUT_ROLL=?, CHKOUT_saleNo=?, spentDuration=?, CRE_USR=?, CRE_DTE=?, UPD_USR=?, UPD_DTE=?, DEL_USR=?, DEL_DTE=?, Note=? WHERE listIndex=?");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'sississisisssssssi', $item->saleNo, $item->CWS_index, $item->serviceUserID, $item->cardID, $item->reserveDuration, $item->CHKIN_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CHKOUT_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CHKOUT_ROLL, $item->CHKOUT_saleNo, $item->spentDuration, $item->CRE_USR, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->Note, $item->listIndex);		
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);
	}

	/**
	 * Deletes the item corresponding to the passed primary key value from 
	 * the table.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return void
	 */
	public function delete_ccrr_base($itemID) {
				
		$stmt = mysqli_prepare($this->connection, "DELETE FROM $this->tablename WHERE listIndex = ?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'i', $itemID);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);
	}


	/**
	 * Returns the number of rows in the table.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 */
	public function count() {
		$stmt = mysqli_prepare($this->connection, "SELECT COUNT(*) AS COUNT FROM $this->tablename");
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_result($stmt, $rec_count);
		$this->throwExceptionOnError();
		
		mysqli_stmt_fetch($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_free_result($stmt);
		mysqli_close($this->connection);
		
		return $rec_count;
	}


	/**
	 * Returns $numItems rows starting from the $startIndex row from the 
	 * table.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * 
	 * @return array
	 */
	public function get_ccrr_base_paged($startIndex, $numItems) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename LIMIT ?, ?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ii', $startIndex, $numItems);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->listIndex, $row->saleNo, $row->CWS_index, $row->serviceUserID, $row->cardID, $row->reserveDuration, $row->CHKIN_DTE, $row->CHKOUT_DTE, $row->CHKOUT_ROLL, $row->CHKOUT_saleNo, $row->spentDuration, $row->CRE_USR, $row->CRE_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE, $row->Note);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CHKIN_DTE = new DateTime($row->CHKIN_DTE);
	      $row->CHKOUT_DTE = new DateTime($row->CHKOUT_DTE);
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->listIndex, $row->saleNo, $row->CWS_index, $row->serviceUserID, $row->cardID, $row->reserveDuration, $row->CHKIN_DTE, $row->CHKOUT_DTE, $row->CHKOUT_ROLL, $row->CHKOUT_saleNo, $row->spentDuration, $row->CRE_USR, $row->CRE_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE,$row->Note);
	    }

		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);
		
		return $rows;
	}
	
	
	/**
	 * Utility function to throw an exception if an error occurs 
	 * while running a mysql command.
	 */
	private function throwExceptionOnError($link = null) {
		if($link == null) {
			$link = $this->connection;
		}
		if(mysqli_error($link)) {
			$msg = mysqli_errno($link) . ": " . mysqli_error($link);
			throw new Exception('MySQL Error - '. $msg);
		}		
	}
	
	
	public function get_still_checkIn_user($searchKey) {
		$cardID = $searchKey;
		$sql_query_field = "SELECT * FROM  `_ccrr_base` WHERE  `cardID` =  '{$cardID}' AND  `CHKOUT_ROLL` =0 AND `spentDuration` =0";

		$stmt = mysqli_prepare($this->connection, $sql_query_field);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->listIndex, $row->saleNo, $row->CWS_index, $row->serviceUserID, $row->cardID, $row->reserveDuration, $row->CHKIN_DTE, $row->CHKOUT_DTE, $row->CHKOUT_ROLL, $row->CHKOUT_saleNo, $row->spentDuration, $row->CRE_USR, $row->CRE_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE, $row->Note);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CHKIN_DTE = new DateTime($row->CHKIN_DTE);
	      $row->CHKOUT_DTE = new DateTime($row->CHKOUT_DTE);
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->listIndex, $row->saleNo, $row->CWS_index, $row->serviceUserID, $row->cardID, $row->reserveDuration, $row->CHKIN_DTE, $row->CHKOUT_DTE, $row->CHKOUT_ROLL, $row->CHKOUT_saleNo, $row->spentDuration, $row->CRE_USR, $row->CRE_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE,$row->Note);
	    }
		
		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);
		
		return $rows;
	}
}

?>
