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
class ItemmovementviewService {

	var $username = "root";
	var $password = "";
	var $server = "localhost";
	var $port = "3306";
	var $databasename = "stechschema";
	var $tablename = "itemmovementview";

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

		mysqli_query($this->connection, "SET NAMES 'utf8'");
	}

	/**
	 * Returns all the rows from the table.
	 *
	 * Add authroization or any logical checks for secure access to your data 
	 *
	 * @return array
	 ************************* Does not work in flex code  ************************/
	public function getAllItemmovementview() {

		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->actionType, $row->QTY, $row->stockQTY, $row->CRE_DTE);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->actionType, $row->QTY, $row->stockQTY, $row->CRE_DTE);
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
	}

	/**
	 * Returns all the rows from the table.
	 *
	 * Add authroization or any logical checks for secure access to your data 
	 *
	 * @return array
	 */
	public function getMovement_byItemIndex($itemIndex) {

		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename where itemIndex=?");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'i', $itemIndex);
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->actionType, $row->QTY, $row->stockQTY, $row->CRE_DTE);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, 
		  $row->itemIndex, 
		  $row->itemID, 
		  $row->actionType, 
		  $row->QTY, 
		  $row->stockQTY, 
		  $row->CRE_DTE);
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
	public function getItemmovementviewByID($itemID) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename where itemID=?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'i', $itemID);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->actionType, $row->QTY, $row->stockQTY, $row->CRE_DTE);
		
		if(mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
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
	public function createItemmovementview($item) {

		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (itemIndex, itemID, actionType, QTY, stockQTY, CRE_DTE) VALUES (?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'issdds', 
		$item->itemIndex, 
		$item->itemID, 
		$item->actionType, 
		$item->QTY, 
		$item->stockQTY, 
		$item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'));
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		$autoid = $item->itemID;

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
	public function updateItemmovementview($item) {
	
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET itemIndex=?, itemID=?, actionType=?, QTY=?, stockQTY=?, CRE_DTE=? WHERE itemID=?");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'issddss', $item->itemIndex, $item->itemID, $item->actionType, $item->QTY, $item->stockQTY, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->itemID);		
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
	public function deleteItemmovementview($itemID) {
				
		$stmt = mysqli_prepare($this->connection, "DELETE FROM $this->tablename WHERE itemID = ?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 's', $itemID);
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
	public function getItemmovementview_paged($startIndex, $numItems) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename LIMIT ?, ?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ii', $startIndex, $numItems);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->actionType, $row->QTY, $row->stockQTY, $row->CRE_DTE);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->actionType, $row->QTY, $row->stockQTY, $row->CRE_DTE);
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
}

?>
