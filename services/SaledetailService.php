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
class SaledetailService {

	var $username = "root";
	var $password = "";
	var $server = "localhost";
	var $port = "3306";
	var $databasename = "stechschema";
	var $tablename = "saledetail";
	var $table_saledetail = "saledetail";
	var $table_salelist = "salelist";
	var $table_salelist_opt = "salelist_opt";
	var $table_monitor = "_till_monitor";
	var $table_item = "_item";

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
	public function getAllSaledetail() {

		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->saleIndex, $row->saleNo, $row->saleType, $row->customerIndex, $row->saleDone, $row->creditCardID, $row->approvalCode, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance, $row->creditCardAuthorizer, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->saleIndex, $row->saleNo, $row->saleType, $row->customerIndex, $row->saleDone, $row->creditCardID, $row->approvalCode, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance, $row->creditCardAuthorizer, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
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
	public function getSaledetailByID($itemID) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename where saleIndex=?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'i', $itemID);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_result($stmt, $row->saleIndex, $row->saleNo, $row->saleType, $row->customerIndex, $row->saleDone, $row->creditCardID, $row->approvalCode, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance, $row->creditCardAuthorizer, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
		
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
	public function createSaledetail($item, $doOnce = true) {

		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (saleIndex, saleNo, saleType, customerIndex, saleDone, creditCardID, approvalCode, saleTotalAmount, saleTotalDiscount, saleTotalBalance, creditCardAuthorizer, CRE_DTE, CRE_USR, UPD_DTE, UPD_USR, DEL_DTE, DEL_USR) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'isiiissdddsssssss', $item->saleIndex, $item->saleNo, $item->saleType, $item->customerIndex, $item->saleDone, $item->creditCardID, $item->approvalCode, $item->saleTotalAmount, $item->saleTotalDiscount, $item->saleTotalBalance, $item->creditCardAuthorizer, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		$autoid = $item->saleIndex;

		mysqli_stmt_free_result($stmt);
		if ($doOnce == true)
			mysqli_close($this->connection);

		return $autoid;
	}

	/**
	 * Returns the item corresponding to the value specified for the primary key.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 *
	 *	Note:
	 *	This function is duplicated from createSaledetail()  for details,
	 *  refer to createSalelist_own($item) in SalelistService.php 
	 */
	public function createSaledetail_own($item) {

		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (saleIndex, saleNo, saleType, customerIndex, saleDone, creditCardID, approvalCode, saleTotalAmount, saleTotalDiscount, saleTotalBalance, creditCardAuthorizer, CRE_DTE, CRE_USR, UPD_DTE, UPD_USR, DEL_DTE, DEL_USR) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'isiiissdddsssssss', $item->saleIndex, $item->saleNo, $item->saleType, $item->customerIndex, $item->saleDone, $item->creditCardID, $item->approvalCode, $item->saleTotalAmount, $item->saleTotalDiscount, $item->saleTotalBalance, $item->creditCardAuthorizer, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		$autoid = $item->saleIndex;

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
	public function updateSaledetail($item) {
	
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET saleNo=?, saleType=?, customerIndex=?, saleDone=?, creditCardID=?, approvalCode=?, saleTotalAmount=?, saleTotalDiscount=?, saleTotalBalance=?, creditCardAuthorizer=?, CRE_DTE=?, CRE_USR=?, UPD_DTE=?, UPD_USR=?, DEL_DTE=?, DEL_USR=? WHERE saleIndex=?");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'siiissdddsssssssi', $item->saleNo, $item->saleType, $item->customerIndex, $item->saleDone, $item->creditCardID, $item->approvalCode, $item->saleTotalAmount, $item->saleTotalDiscount, $item->saleTotalBalance, $item->creditCardAuthorizer, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->saleIndex);		
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
	public function deleteSaledetail($itemID) {
				
		$stmt = mysqli_prepare($this->connection, "DELETE FROM $this->tablename WHERE saleIndex = ?");
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

	public function getBillQueue($searchCause) {

	    $stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt, $row->CRE_DTE, $row->billCount);

	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->CRE_DTE, $row->billCount);
	    }

		mysqli_stmt_free_result($stmt);
		mysqli_close($this->connection);

		return $rows;
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
	public function getSaledetail_paged($startIndex, $numItems) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename LIMIT ?, ?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ii', $startIndex, $numItems);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->saleIndex, $row->saleNo, $row->saleType, $row->customerIndex, $row->saleDone, $row->creditCardID, $row->approvalCode, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance, $row->creditCardAuthorizer, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->saleIndex, $row->saleNo, $row->saleType, $row->customerIndex, $row->saleDone, $row->creditCardID, $row->approvalCode, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance, $row->creditCardAuthorizer, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
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
	 * Returns max bill number from saledetail table
	 *   duplicated from SaledetailviewService 
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function getMax_billNo($searchCause) {
		$stmt = mysqli_prepare($this->connection, $searchCause);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->saleNo);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->saleNo);
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
	} 
	
	
	public function getSaledetail_bySaleNo($saleNo) {
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename where saleNo='{$saleNo}' ");
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->saleIndex, $row->saleNo, $row->saleType, $row->customerIndex, $row->saleDone, $row->creditCardID, $row->approvalCode, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance, $row->creditCardAuthorizer, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->saleIndex, $row->saleNo, $row->saleType, $row->customerIndex, $row->saleDone, $row->creditCardID, $row->approvalCode, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance, $row->creditCardAuthorizer, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
	}


	public function updateSaledetail_own($item) {
	
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET saleType=?, customerIndex=?, saleDone=?, creditCardID=?, approvalCode=?, saleTotalAmount=?, saleTotalDiscount=?, saleTotalBalance=?, creditCardAuthorizer=?, UPD_DTE=?, UPD_USR=? WHERE saleIndex=?");		
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'iiissdddsssi', $item->saleType, $item->customerIndex, $item->saleDone, $item->creditCardID, $item->approvalCode, $item->saleTotalAmount, $item->saleTotalDiscount, $item->saleTotalBalance, $item->creditCardAuthorizer, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->saleIndex);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);
	}


	public function testStubucy() {
	    /** Return Magic Number **/
		return (String)12123;
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
	 *	This function is duplicated from addSalelist() to prove that "Create Operation" 
	 *  which generated from FB4 can not operate correctly in code but no such a problem 
	 *  when test with "Test Operation" Data/Services tool. 
	 *
	 *  For testing with FB4 Test Operation refer to "Ignore Date" in code.
	 */
	public function addSalelistTransition($saledetail,$itemlist) {

		$autoidlist = array();
		//for($i = 0;$i<sizeof($itemlist);$i++){
		//	$item = $itemlist[$i];
		foreach($itemlist as $item){
			// Query Check Item Qty
			$itemStock = 0;
			/*
			if ($result = mysqli_query($this->connection, "SELECT itemStock FROM $this->table_item WHERE itemIndex = $item->itemIndex LIMIT 1")) {
				if ($row = mysqli_fetch_row($result)) {
					// $row[0]
					$itemStock = $row[0];
				}
				// free result set 
				mysqli_free_result($result);
			}
			*/
			
			$stmt = mysqli_prepare($this->connection, "SELECT itemStock FROM $this->table_item WHERE itemIndex = ? LIMIT 1");
			$this->throwExceptionOnError();
			
			mysqli_stmt_bind_param($stmt, "i", $item->itemIndex);
			$this->throwExceptionOnError();
			
			mysqli_stmt_execute($stmt);
			$this->throwExceptionOnError();
			
			mysqli_stmt_bind_result($stmt, $col1);
			$this->throwExceptionOnError();
			
			mysqli_stmt_fetch($stmt);
			$this->throwExceptionOnError();
			$itemStock = $col1;
			mysqli_stmt_free_result($stmt);
			mysqli_stmt_close($stmt);
			$saleQTY = $item->saleQTY;
			$stockQty = $itemStock - $item->saleQTY; // $item->stockQTY
			
			// CreateSaleList
			$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->table_salelist (saleNo, itemIndex, salePrice, saleQTY, stockQTY, saleDiscount, saleClass, CRE_USR, CRE_DTE, UPD_USR, UPD_DTE, DEL_USR, DEL_DTE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$this->throwExceptionOnError();

			//mysqli_stmt_bind_param($stmt, 'siddddsssssss', $item->saleNo, $item->itemIndex, $item->salePrice, $item->saleQTY, $stockQty, $item->saleDiscount, $item->saleClass, $item->CRE_USR, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'));
			mysqli_stmt_bind_param($stmt, 'siddddsssssss', $item->saleNo, $item->itemIndex, $item->salePrice, $item->saleQTY, $stockQty, $item->saleDiscount, $item->saleClass, $saledetail->CRE_USR, $saledetail->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->UPD_USR, $saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->DEL_USR, $saledetail->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'));
			$this->throwExceptionOnError();

			mysqli_stmt_execute($stmt);		
			$this->throwExceptionOnError();

			$item_autoid = mysqli_stmt_insert_id($stmt);
			
			array_push($autoidlist,$item_autoid);
			
			mysqli_stmt_free_result($stmt);	
			
			mysqli_stmt_close($stmt);
			
			// Update Item
			
			//$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_item SET itemStock = itemStock + ? WHERE itemIndex = ?");
			$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_item SET itemStock = ? WHERE itemIndex = ?");
			$this->throwExceptionOnError();
			
			//$item->saleQTY
			//mysqli_stmt_bind_param($stmt, 'ii', $qty, $itemID);
			mysqli_stmt_bind_param($stmt, 'ii', $stockQty, $item->itemIndex);
			$this->throwExceptionOnError();
			
			mysqli_stmt_execute($stmt);
			$this->throwExceptionOnError();
			
			mysqli_stmt_free_result($stmt);	
			
			mysqli_stmt_close($stmt);
			
			// ITEM OPTION ============================ START ==============================
			
			if(sizeof($item->itemOPT)){
				foreach($item->itemOPT as $itemOpt)
				{
					$stockQty = 0;
					if($itemOpt->saleClass == "Rt"){
						// Query Check Item Qty
						$itemStock = 0;
						
						$stmt = mysqli_prepare($this->connection, "SELECT itemStock FROM $this->table_item WHERE itemIndex = ? LIMIT 1");
						$this->throwExceptionOnError();
						
						mysqli_stmt_bind_param($stmt, "i", $itemOpt->itemIndex);
						$this->throwExceptionOnError();
						
						mysqli_stmt_execute($stmt);
						$this->throwExceptionOnError();
						
						mysqli_stmt_bind_result($stmt, $col1);
						$this->throwExceptionOnError();
						
						mysqli_stmt_fetch($stmt);
						$this->throwExceptionOnError();
						$itemStock = $col1;
						mysqli_stmt_free_result($stmt);
						mysqli_stmt_close($stmt);
						$saleQTY = $itemOpt->saleQTY;
						$stockQty = $itemStock - $itemOpt->saleQTY; // $item->stockQTY
						
						// Update Item
					
						//$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_item SET itemStock = itemStock + ? WHERE itemIndex = ?");
						$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_item SET itemStock = ? WHERE itemIndex = ?");
						$this->throwExceptionOnError();
						
						//$itemOpt->saleQTY
						//mysqli_stmt_bind_param($stmt, 'ii', $qty, $itemID);
						mysqli_stmt_bind_param($stmt, 'ii', $stockQty, $itemOpt->itemIndex);
						$this->throwExceptionOnError();
						
						mysqli_stmt_execute($stmt);
						$this->throwExceptionOnError();
						
						mysqli_stmt_free_result($stmt);	
						
						mysqli_stmt_close($stmt);
					}
					
					// CreateSaleList OPT
					$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->table_salelist_opt (saleNo, primary_listindex, itemIndex, salePrice, saleQTY, stockQTY, saleDiscount, saleClass, localDataIndex, name, description, CRE_USR, CRE_DTE, UPD_USR, UPD_DTE, DEL_USR, DEL_DTE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$this->throwExceptionOnError();

					//mysqli_stmt_bind_param($stmt, 'siddddsssssss', $item->saleNo, $item->itemIndex, $item->salePrice, $item->saleQTY, $stockQty, $item->saleDiscount, $item->saleClass, $item->CRE_USR, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'));
					mysqli_stmt_bind_param($stmt, 'siiddddsissssssss', $itemOpt->saleNo, $item_autoid, $itemOpt->itemIndex, $itemOpt->salePrice, $itemOpt->saleQTY, $stockQty, $itemOpt->saleDiscount, $itemOpt->saleClass, $itemOpt->localDataIndex, $itemOpt->name, $itemOpt->desc, $saledetail->CRE_USR, $saledetail->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->UPD_USR, $saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->DEL_USR, $saledetail->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'));
					$this->throwExceptionOnError();

					mysqli_stmt_execute($stmt);		
					$this->throwExceptionOnError();
					
					mysqli_stmt_free_result($stmt);	
					
					mysqli_stmt_close($stmt);
					
				}
			}
			
			// ITEM OPTION ============================ END ==============================
		
		}
		
		// CreateSaleDetail
		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (saleIndex, saleNo, saleType, customerIndex, saleDone, creditCardID, approvalCode, saleTotalAmount, saleTotalDiscount, saleTotalBalance, creditCardAuthorizer, CRE_DTE, CRE_USR, UPD_DTE, UPD_USR, DEL_DTE, DEL_USR) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		$saleIndex = 0; // $saledetail->saleIndex
		
		mysqli_stmt_bind_param($stmt, 'isiiissdddsssssss', $saleIndex, $saledetail->saleNo, $saledetail->saleType, $saledetail->customerIndex, $saledetail->saleDone, $saledetail->creditCardID, $saledetail->approvalCode, $saledetail->saleTotalAmount, $saledetail->saleTotalDiscount, $saledetail->saleTotalBalance, $saledetail->creditCardAuthorizer, $saledetail->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->CRE_USR, $saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->UPD_USR, $saledetail->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->DEL_USR);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		//$autoid = $saledetail->saleIndex;
		$autoid_saledetail = mysqli_stmt_insert_id($stmt);

		mysqli_stmt_free_result($stmt);
		//return $autoid;
		
		mysqli_stmt_close($stmt);
		
		// retrieve last rows from Till Monitor
		if ($result = mysqli_query($this->connection, "SELECT drawerBalance FROM $this->table_monitor ORDER BY actionIndex DESC LIMIT 1")) {
			if ($row = mysqli_fetch_row($result)) {
				// $row[0]
				$drawerBalance_old = $row[0];
			}
			// free result set
			mysqli_free_result($result);
		}
		
		// Create Till Monitor
		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->table_monitor (actionIndex, drawerIndex, actionType, actionAmount, drawerBalance, CRE_DTE, CRE_USR, UPD_DTE, UPD_USR, DEL_DTE, DEL_USR) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();
		
		$actionIndex = 0; // $item_monitor->actionIndex
		$drawerIndex = 1; // $item_monitor->drawerIndex
		$actionType = $saledetail->saleNo; // $item_monitor->actionType
		$actionAmount = $saledetail->saleTotalBalance; // $item_monitor->actionAmount
		$drawerBalance = $drawerBalance_old + $saledetail->saleTotalBalance; // $item_monitor->drawerBalance
		
		mysqli_stmt_bind_param($stmt, 'iisddssssss', $actionIndex, $drawerIndex, $actionType, $actionAmount, $drawerBalance, $saledetail->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->CRE_USR, $saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->UPD_USR, $saledetail->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->DEL_USR);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		//$autoid = $item->actionIndex;
		//$autoid_monitor = $item_monitor->actionIndex;
		//$autoid_monitor = $actionIndex;
		$autoid_monitor = mysqli_stmt_insert_id($stmt);

		mysqli_stmt_free_result($stmt);	
		
		mysqli_close($this->connection);
		
		//$return_result = array("autoidlist"=>$autoidlist,"autoid_monitor"=>$autoid_monitor,"autoid_saledetail"=>$autoid_saledetail);
		//$return_result = (object)array("autoidlist"=>$autoidlist,"autoid_monitor"=>$autoid_monitor,"autoid_saledetail"=>$autoid_saledetail);
/*
		$return_result = {
			autoidlist: $autoidlist,
			autoid_monitor: $autoid_monitor,
			autoid_saledetail: $autoid_saledetail
		};
*/	
		//return $return_result;
		return 1;
	}
	public function testItemList($itemlist) {
		return $itemlist;
	}
	public function checkarray($itemlist) {
		return sizeof($itemlist);
	}
	
	public function countItemOpt($saledetail,$itemlist) {
		$totalOpt = 0;
		foreach($itemlist as $item){
			$totalOpt += sizeof($item->itemOPT);
		}
		return $totalOpt;
	}
	
	public function checkItemOpt($saledetail,$itemlist) {
		$totalOpt = 0;
		$i = 0;
		foreach($itemlist as $item){
			$i++;
			$totalOpt += sizeof($item->itemOPT);
			if(sizeof($item->itemOPT)){
				$o = 0;
				foreach($item->itemOPT as $itemOpt)
				{
					$o++;
					// Record Text File
					$now = date("Y-m-d H:i:s");
					$result = "[".$now."][i:".$i."][o:".$o."]".json_encode($itemOpt)."\r\n";
					$filename = 'checkdata.txt';
					$handle = fopen($filename , 'a');
					fwrite($handle,$result);
					fclose($handle);
				}
			}
		}
		return $totalOpt;
	}
	
	public function testAddItemOpt($saledetail,$itemlist) {
		foreach($itemlist as $item){
			if(sizeof($item->itemOPT)){
				foreach($item->itemOPT as $itemOpt)
				{
					$stockQty = 0;
					if($itemOpt->saleClass == "Rt"){
						// Query Check Item Qty
						$itemStock = 0;
						
						$stmt = mysqli_prepare($this->connection, "SELECT itemStock FROM $this->table_item WHERE itemIndex = ? LIMIT 1");
						$this->throwExceptionOnError();
						
						mysqli_stmt_bind_param($stmt, "i", $itemOpt->itemIndex);
						$this->throwExceptionOnError();
						
						mysqli_stmt_execute($stmt);
						$this->throwExceptionOnError();
						
						mysqli_stmt_bind_result($stmt, $col1);
						$this->throwExceptionOnError();
						
						mysqli_stmt_fetch($stmt);
						$this->throwExceptionOnError();
						$itemStock = $col1;
						mysqli_stmt_free_result($stmt);
						mysqli_stmt_close($stmt);
						$saleQTY = $itemOpt->saleQTY;
						$stockQty = $itemStock - $itemOpt->saleQTY; // $item->stockQTY
					}
					
					// CreateSaleList
					$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->table_salelist_opt (saleNo, primary_listindex, itemIndex, salePrice, saleQTY, stockQTY, saleDiscount, saleClass, localDataIndex, name, description, CRE_USR, CRE_DTE, UPD_USR, UPD_DTE, DEL_USR, DEL_DTE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$this->throwExceptionOnError();

					//mysqli_stmt_bind_param($stmt, 'siddddsssssss', $item->saleNo, $item->itemIndex, $item->salePrice, $item->saleQTY, $stockQty, $item->saleDiscount, $item->saleClass, $item->CRE_USR, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'));
					mysqli_stmt_bind_param($stmt, 'siiddddsissssssss', $itemOpt->saleNo, $item_autoid, $itemOpt->itemIndex, $itemOpt->salePrice, $itemOpt->saleQTY, $stockQty, $itemOpt->saleDiscount, $itemOpt->saleClass, $itemOpt->localDataIndex, $itemOpt->name, $itemOpt->desc, $saledetail->CRE_USR, $saledetail->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->UPD_USR, $saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->DEL_USR, $saledetail->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'));
					$this->throwExceptionOnError();

					mysqli_stmt_execute($stmt);		
					$this->throwExceptionOnError();

					$autoid = mysqli_stmt_insert_id($stmt);
					
					mysqli_stmt_free_result($stmt);	
					
					mysqli_stmt_close($stmt);
					
					// Update Item
					
					if($itemOpt->saleClass == "Rt"){
						//$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_item SET itemStock = itemStock + ? WHERE itemIndex = ?");
						$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_item SET itemStock = ? WHERE itemIndex = ?");
						$this->throwExceptionOnError();
						
						//$itemOpt->saleQTY
						//mysqli_stmt_bind_param($stmt, 'ii', $qty, $itemID);
						mysqli_stmt_bind_param($stmt, 'ii', $stockQty, $itemOpt->itemIndex);
						$this->throwExceptionOnError();
						
						mysqli_stmt_execute($stmt);
						$this->throwExceptionOnError();
						
						mysqli_stmt_free_result($stmt);	
						
						mysqli_stmt_close($stmt);
					}
				}
			}
		}
		return true;
	}
	
}

class Saledetail {
/**
'isiiissdddsssssss', $item->saleIndex, $item->saleNo, $item->saleType, $item->customerIndex, $item->saleDone, $item->creditCardID, $item->approvalCode, $item->saleTotalAmount, $item->saleTotalDiscount, $item->saleTotalBalance, $item->creditCardAuthorizer, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR
**/

	var $saleIndex;
	var $saleNo;
	var $saleType;
	var $customerIndex;
	var $saleDone;
	var $creditCardID;
	var $approvalCode;
	var $saleTotalAmount;
	var $saleTotalDiscount;
	var $saleTotalBalance;
	var $creditCardAuthorizer;
	var $CRE_DTE;
	var $CRE_USR;
	var $UPD_DTE;
	var $UPD_USR;
	var $DEL_DTE;
	var $DEL_USR;
}
?>
