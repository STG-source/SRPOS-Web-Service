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
class SalelistService {

	var $username = "root";
	var $password = "";
	var $server = "localhost";
	var $port = "3306";
	var $databasename = "stechschema";
	var $tablename = "salelist";

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
	public function getAllSalelist() {

		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->listIndex, $row->saleNo, $row->itemIndex, $row->salePrice, $row->saleQTY, $row->stockQTY, $row->saleDiscount, $row->saleClass, $row->CRE_USR, $row->CRE_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->listIndex, $row->saleNo, $row->itemIndex, $row->salePrice, $row->saleQTY, $row->stockQTY, $row->saleDiscount, $row->saleClass, $row->CRE_USR, $row->CRE_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE);
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
	public function getSalelistByID($itemID) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename where listIndex=?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'i', $itemID);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_result($stmt, $row->listIndex, $row->saleNo, $row->itemIndex, $row->salePrice, $row->saleQTY, $row->stockQTY, $row->saleDiscount, $row->saleClass, $row->CRE_USR, $row->CRE_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE);
		
		if(mysqli_stmt_fetch($stmt)) {
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
	public function createSalelist($item) {

		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (saleNo, itemIndex, salePrice, saleQTY, stockQTY, saleDiscount, saleClass, CRE_USR, CRE_DTE, UPD_USR, UPD_DTE, DEL_USR, DEL_DTE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'siddddsssssss', $item->saleNo, $item->itemIndex, $item->salePrice, $item->saleQTY, $item->stockQTY, $item->saleDiscount, $item->saleClass, $item->CRE_USR, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'));
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
	public function updateSalelist($item) {
	
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET saleNo=?, itemIndex=?, salePrice=?, saleQTY=?, stockQTY=?, saleDiscount=?, saleClass=?, CRE_USR=?, CRE_DTE=?, UPD_USR=?, UPD_DTE=?, DEL_USR=?, DEL_DTE=? WHERE listIndex=?");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'siddddsssssssi', $item->saleNo, $item->itemIndex, $item->salePrice, $item->saleQTY, $item->stockQTY, $item->saleDiscount, $item->saleClass, $item->CRE_USR, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->listIndex);		
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
	public function deleteSalelist($itemID) {
				
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
	public function getSalelist_paged($startIndex, $numItems) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename LIMIT ?, ?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ii', $startIndex, $numItems);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->listIndex, $row->saleNo, $row->itemIndex, $row->salePrice, $row->saleQTY, $row->stockQTY, $row->saleDiscount, $row->saleClass, $row->CRE_USR, $row->CRE_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->listIndex, $row->saleNo, $row->itemIndex, $row->salePrice, $row->saleQTY, $row->stockQTY, $row->saleDiscount, $row->saleClass, $row->CRE_USR, $row->CRE_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE);
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


	/*************************************************************************************************
	*   Add customized function.
	*
	**************************************************************************************************/

	/**
	 * Returns the item corresponding to the value specified for the primary key.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 *
	 *	Note:
	 *	This function is duplicated from createSalelist() to prove that "Create Operation" 
	 *  which generated from FB4 can not operate correctly in code but no such a problem 
	 *  when test with "Test Operation" Data/Services tool. 
	 *
	 *  For testing with FB4 Test Operation refer to "Ignore Date" in code.
	 */
	public function createSalelist_own($item) {

		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (saleNo, itemIndex, salePrice, saleQTY, stockQTY, saleDiscount, saleClass, CRE_USR, CRE_DTE, UPD_USR, UPD_DTE, DEL_USR, DEL_DTE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'siddddsssssss', $item->saleNo, $item->itemIndex, $item->salePrice, $item->saleQTY, $item->stockQTY, $item->saleDiscount, $item->saleClass, $item->CRE_USR, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'));
		$this->throwExceptionOnError();

		/** 
		 * Ref: "Ignore Date"
		 * From the upper code the binding parameters has been skipped the toString() function
		 * in each date parameter. For testing this code, comment out the above code and enable
		 * the below. After that place the following parameters at "Test Operation" Data/Services tool.
		 * {
		 * 	listIndex:99,
		 * 	saleNo:"bboo",
		 * 	itemIndex:10001,
		 * 	salePrice:99,
		 * 	saleQTY:1,
		 * 	saleDiscount:"j",
		 * 	CRE_USR:"jj",
		 * 	CRE_DTE:"",
		 * 	UPD_USR:"2000",
		 * 	UPD_DTE:"",
		 * 	DEL_USR:"2000",
		 * 	DEL_DTE:""
		 * } 
		 *
		mysqli_stmt_bind_param($stmt, 'siddsssssss', $item->saleNo, $item->itemIndex, $item->salePrice, $item->saleQTY, $item->saleDiscount, $item->CRE_USR, $item->CRE_DTE, $item->UPD_USR, $item->UPD_DTE, $item->DEL_USR, $item->DEL_DTE); */
		$this->throwExceptionOnError(); 
		
		/**
		 * Ref2: For shorter testing
		 *
		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (saleNo) VALUES (?)");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'siddsssssss', $item->saleNo);
		$this->throwExceptionOnError(); */

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		$autoid = mysqli_stmt_insert_id($stmt);

		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);

		return $autoid;
	}


	public function getSalelistItem_byBillNo($saleNo) {

	    $stmt = mysqli_prepare($this->connection,
		"SELECT  `c`.`listIndex` AS  `listIndex` ,  `c`.`saleNo` AS  `saleNo` ,  `c`.`itemIndex` AS  `itemIndex` ,  `j`.`itemID` AS  `itemID` ,  `j`.`itembarcodeID` AS  `itembarcodeID` ,  `j`.`itemName` AS  `itemName` ,  `c`.`salePrice` AS  `salePrice` ,  `c`.`saleQTY` AS  `saleQTY` ,  `c`.`stockQTY` AS  `stockQTY` ,  `c`.`saleDiscount` AS  `saleDiscount` ,  `c`.`saleClass` AS  `saleClass` ,  `c`.`CRE_USR` AS  `CRE_USR` ,  `c`.`CRE_DTE` AS `CRE_DTE` FROM (`salelist`  `c` JOIN  `_item`  `j`) WHERE (`c`.`itemIndex` =  `j`.`itemIndex`) AND (`c`.`saleNo` = '{$saleNo}')");
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt,
			$row->listIndex,
			$row->saleNo,
			$row->itemIndex,
			$row->itemID,
			$row->itembarcodeID,
			$row->itemName,
			$row->salePrice, 
			$row->saleQTY,
			$row->stockQTY,
			$row->saleDiscount,
			$row->saleClass,
			$row->CRE_USR,
			$row->CRE_DTE);

	    while (mysqli_stmt_fetch($stmt)) {
		  $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt,
			$row->listIndex,
			$row->saleNo,
			$row->itemIndex,
			$row->itemID,
			$row->itembarcodeID,
			$row->itemName,
			$row->salePrice, 
			$row->saleQTY,
			$row->stockQTY,
			$row->saleDiscount,
			$row->saleClass,
			$row->CRE_USR,
			$row->CRE_DTE);
	    }

		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);

		return $rows;
	}	


	public function updateSalelist_own($item) {
	
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET salePrice=?, saleQTY=?, stockQTY=?, saleDiscount=?, saleClass=?, UPD_USR=?, UPD_DTE=? WHERE listIndex=?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ddddsssi', $item->salePrice, $item->saleQTY, $item->stockQTY, $item->saleDiscount, $item->saleClass,  $item->UPD_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->listIndex);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		mysqli_stmt_free_result($stmt);
		mysqli_close($this->connection);
	}
	
	public function getSearch_ItemLatestCost($searchCause) {

	    $stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt,$row->CRE_DTE, $row->saleNo, $row->sumTotalAmount, $row->sumTotalDiscount , $row->sumTotalBalance, $row->sumLatestCost);

	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->CRE_DTE , $row->saleNo, $row->sumTotalAmount, $row->sumTotalDiscount , $row->sumTotalBalance, $row->sumLatestCost);
	    }

		mysqli_stmt_free_result($stmt);
		mysqli_close($this->connection);

		return $rows;
	}

	public function getSearch_CostByXXX($searchCause) {

	    $stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt, $row->CRE_YEAR, $row->CRE_XXX, $row->billCount, $row->sumTotalAmount, $row->sumTotalDiscount, $row->sumTotalBalance, $row->sumLatestCost);

	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->CRE_YEAR, $row->CRE_XXX, $row->billCount, $row->sumTotalAmount, $row->sumTotalDiscount, $row->sumTotalBalance, $row->sumLatestCost);
	    }

		mysqli_stmt_free_result($stmt);
		mysqli_close($this->connection);

		return $rows;
	}
}

?>
