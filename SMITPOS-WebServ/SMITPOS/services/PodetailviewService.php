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
class PodetailviewService {

	var $username = "root";
	var $password = "";
	var $server = "localhost";
	var $port = 3306;
	var $databasename = "stechschema";
	var $tablename = "podetailview";

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
	 */
	public function getAllPodetailview() {

		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->inIndex, $row->inID, $row->orderNo, $row->supplierIndex, $row->itemIndex, $row->branchIndex, $row->inPrice, $row->inQTY, $row->inDone, $row->inTransportCost, $row->paymentDue, $row->orderDate, $row->receiveDate, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->supplierID, $row->name, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->setvalue, $row->inTotal);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->paymentDue = new DateTime($row->paymentDue);
	      $row->orderDate = new DateTime($row->orderDate);
	      $row->receiveDate = new DateTime($row->receiveDate);
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->inIndex, $row->inID, $row->orderNo, $row->supplierIndex, $row->itemIndex, $row->branchIndex, $row->inPrice, $row->inQTY, $row->inDone, $row->inTransportCost, $row->paymentDue, $row->orderDate, $row->receiveDate, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->supplierID, $row->name, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->setvalue, $row->inTotal);
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
	public function getPodetailviewByID($itemID) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename where inIndex=?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'i', $itemID);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_result($stmt, $row->inIndex, $row->inID, $row->orderNo, $row->supplierIndex, $row->itemIndex, $row->branchIndex, $row->inPrice, $row->inQTY, $row->inDone, $row->inTransportCost, $row->paymentDue, $row->orderDate, $row->receiveDate, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->supplierID, $row->name, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->setvalue, $row->inTotal);
		
		if(mysqli_stmt_fetch($stmt)) {
	      $row->paymentDue = new DateTime($row->paymentDue);
	      $row->orderDate = new DateTime($row->orderDate);
	      $row->receiveDate = new DateTime($row->receiveDate);
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
	public function createPodetailview($item) {

		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (inIndex, inID, orderNo, supplierIndex, itemIndex, branchIndex, inPrice, inQTY, inDone, inTransportCost, paymentDue, orderDate, receiveDate, CRE_DTE, CRE_USR, UPD_DTE, UPD_USR, DEL_DTE, DEL_USR, supplierID, name, itemID, itembarcodeID, itemName, itemCatagoryIndex, itemUnitIndex, setvalue, inTotal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'issiiidiidssssssssssssssiisd', $item->inIndex, $item->inID, $item->orderNo, $item->supplierIndex, $item->itemIndex, $item->branchIndex, $item->inPrice, $item->inQTY, $item->inDone, $item->inTransportCost, $item->paymentDue->toString('YYYY-MM-dd HH:mm:ss'), $item->orderDate->toString('YYYY-MM-dd HH:mm:ss'), $item->receiveDate->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->supplierID, $item->name, $item->itemID, $item->itembarcodeID, $item->itemName, $item->itemCatagoryIndex, $item->itemUnitIndex, $item->setvalue, $item->inTotal);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		$autoid = $item->inIndex;

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
	public function updatePodetailview($item) {
	
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET inIndex=?, inID=?, orderNo=?, supplierIndex=?, itemIndex=?, branchIndex=?, inPrice=?, inQTY=?, inDone=?, inTransportCost=?, paymentDue=?, orderDate=?, receiveDate=?, CRE_DTE=?, CRE_USR=?, UPD_DTE=?, UPD_USR=?, DEL_DTE=?, DEL_USR=?, supplierID=?, name=?, itemID=?, itembarcodeID=?, itemName=?, itemCatagoryIndex=?, itemUnitIndex=?, setvalue=?, inTotal=? WHERE inIndex=?");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'issiiidiidssssssssssssssiisdi', $item->inIndex, $item->inID, $item->orderNo, $item->supplierIndex, $item->itemIndex, $item->branchIndex, $item->inPrice, $item->inQTY, $item->inDone, $item->inTransportCost, $item->paymentDue->toString('YYYY-MM-dd HH:mm:ss'), $item->orderDate->toString('YYYY-MM-dd HH:mm:ss'), $item->receiveDate->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->supplierID, $item->name, $item->itemID, $item->itembarcodeID, $item->itemName, $item->itemCatagoryIndex, $item->itemUnitIndex, $item->setvalue, $item->inTotal, $item->inIndex);		
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
	public function deletePodetailview($itemID) {
				
		$stmt = mysqli_prepare($this->connection, "DELETE FROM $this->tablename WHERE inIndex = ?");
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
	public function getPodetailview_paged($startIndex, $numItems) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename LIMIT ?, ?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ii', $startIndex, $numItems);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->inIndex, $row->inID, $row->orderNo, $row->supplierIndex, $row->itemIndex, $row->branchIndex, $row->inPrice, $row->inQTY, $row->inDone, $row->inTransportCost, $row->paymentDue, $row->orderDate, $row->receiveDate, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->supplierID, $row->name, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->setvalue, $row->inTotal);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->paymentDue = new DateTime($row->paymentDue);
	      $row->orderDate = new DateTime($row->orderDate);
	      $row->receiveDate = new DateTime($row->receiveDate);
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->inIndex, $row->inID, $row->orderNo, $row->supplierIndex, $row->itemIndex, $row->branchIndex, $row->inPrice, $row->inQTY, $row->inDone, $row->inTransportCost, $row->paymentDue, $row->orderDate, $row->receiveDate, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->supplierID, $row->name, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->setvalue, $row->inTotal);
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
	
	/**
	 * Returns poview matched the search criteria (KP)
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function getSearch_poview($searchCause) {
		 
	    $stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();
				
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->inIndex, $row->inID, $row->orderNo, $row->supplierIndex, $row->itemIndex, $row->branchIndex, $row->inPrice, $row->inQTY, $row->inDone, $row->inTransportCost, $row->paymentDue, $row->orderDate, $row->receiveDate, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->supplierID, $row->name, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->setvalue, $row->inTotal);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->paymentDue = new DateTime($row->paymentDue);
	      $row->orderDate = new DateTime($row->orderDate);
	      $row->receiveDate = new DateTime($row->receiveDate);
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->inIndex, $row->inID, $row->orderNo, $row->supplierIndex, $row->itemIndex, $row->branchIndex, $row->inPrice, $row->inQTY, $row->inDone, $row->inTransportCost, $row->paymentDue, $row->orderDate, $row->receiveDate, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->supplierID, $row->name, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->setvalue, $row->inTotal);
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
	public function myCreate_poview($SQLInsert) {

		$stmt = mysqli_prepare($this->connection, $SQLInsert);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);

	}
	
	/**
	 * Updates the passed item in the table.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * @param stdClass $item
	 * @return void
	 */
	public function myUpdate_poview($item) {
		
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET inIndex=?, inID=?, orderNo=?, supplierIndex=?, itemIndex=?, branchIndex=?, inPrice=?, inQTY=?, inDone=?, inTransportCost=?, paymentDue=?, orderDate=?, receiveDate=?, CRE_DTE=?, CRE_USR=?, UPD_DTE=?, UPD_USR=?, DEL_DTE=?, DEL_USR=?, supplierID=?, name=?, itemID=?, itembarcodeID=?, itemName=?, itemCatagoryIndex=?, itemUnitIndex=?, setvalue=?, inTotal=? WHERE inIndex=?");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'issiiidiidssssssssssssssiisdi', $item->inIndex, $item->inID, $item->orderNo, $item->supplierIndex, $item->itemIndex, $item->branchIndex, $item->inPrice, $item->inQTY, $item->inDone, $item->inTransportCost, $item->paymentDue->toString('YYYY-MM-dd HH:mm:ss'), $item->orderDate->toString('YYYY-MM-dd HH:mm:ss'), $item->receiveDate->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->supplierID, $item->name, $item->itemID, $item->itembarcodeID, $item->itemName, $item->itemCatagoryIndex, $item->itemUnitIndex, $item->setvalue, $item->inTotal, $item->inIndex);
		$this->throwExceptionOnError();
		
		
		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);
	}
	
	/**
	 * Returns distinct setvalue from all elements (KP)
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function getDistinct_status() {
		$stmt = mysqli_prepare($this->connection, "SELECT DISTINCT (setvalue) FROM $this->tablename");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->setvalue);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->setvalue);
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
	}
	
	/**
	 * Returns max inIndex from all elements (KP)
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function getMax_inIndex() {
		$stmt = mysqli_prepare($this->connection, "SELECT MAX(inIndex) As inIndex FROM inventoryin");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->inIndex);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->inIndex);
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
	}
	
	/**
	 * Returns max orderNo from inventoryin (KP)
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function getMax_orderNo($searchCause) {
		$stmt = mysqli_prepare($this->connection, $searchCause);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->orderNo);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->orderNo);
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
	}
}

?>
