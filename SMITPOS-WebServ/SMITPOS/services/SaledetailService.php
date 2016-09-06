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


// Version 1.15e <-- Need To Fix
class SaledetailService {

	var $username = "root";
	var $password = "";
	var $server = "127.0.0.1"; //var $server = "localhost";
	var $port = "3306";
	var $databasename = "stechschema";
	var $tablename = "saledetail";

	var $table_saledetail = "saledetail";
	var $table_salelist = "salelist";
	var $table_salelist_opt = "salelist_opt";
	var $table_monitor = "_till_monitor";
	var $table_item = "_item";
	var $table_orderinfo = "orderinfo";

	var $connection;
	var $connection2;

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
	* Get Summary saleDetail by customerIndex
	* Get List of Sale Detail By CustomerIndex
	* Return SaleDetail Summary	
	* Return List of Sale Detail
	**/
	public function get_Summary_And_List_SaleDetail_By_CustomerIndex($customerIndex, $saleStatus){
		$result_summary = null;
		$strSQL = "SELECT 
					a.saleTotalBalance as Accumulated_Total,
					b.saleTotalBalance as Paid_Total,
					c.saleTotalBalance as Outstanding_balance
					 FROM (					
						SELECT 
						sum(saleTotalBalance) as saleTotalBalance,
						customerIndex 
						FROM saledetail  
						WHERE customerIndex = $customerIndex 
						AND saleDone <> -1
					)  a 
					LEFT OUTER JOIN
					(
						SELECT 
						sum(saleTotalBalance) as saleTotalBalance,
						customerIndex 
						FROM saledetail  
						WHERE customerIndex = $customerIndex 
						AND saleDone <> -1 AND saleDone <> 0 
					)  b  ON b.customerIndex  = a.customerIndex 
					LEFT OUTER JOIN
					(					
						SELECT 
						sum(saleTotalBalance) as saleTotalBalance,
						customerIndex 
						FROM saledetail  
						WHERE customerIndex = $customerIndex 
						AND saleDone = 0 
					)  c  ON  c.customerIndex  = a.customerIndex ";


		
		$stmt = mysqli_prepare($this->connection, $strSQL);
		$this->throwExceptionOnError();		
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_result($stmt, $row_Summary->Accumulated_Total, $row_Summary->Paid_Total, $row_Summary->Outstanding_balance);
		
		if(mysqli_stmt_fetch($stmt)) {			
	      $result_summary = $row_Summary;
		} else {			
	      $result_summary = null;
		}	
		
		mysqli_stmt_free_result($stmt);				
		
		/*******************************************************************/
		// Get List SaleDetail
		
		//$strSQL = "SELECT * FROM saleDetail WHERE customerIndex = $customerIndex";
		
		$strSQL = "SELECT sd.*, CONCAT_WS(' ',u.userID ,u.fullname) as userName FROM saleDetail  sd
				INNER JOIN _myuser u ON u.userID = sd.CRE_USR
				WHERE customerIndex = $customerIndex";
			
		if ($saleStatus == 0){
			$strSQL = $strSQL." AND saleDone = 0";
		}
		
		$stmt = mysqli_prepare($this->connection, $strSQL);
		$this->throwExceptionOnError();		
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows_list_saleDetail = array();
		
		mysqli_stmt_bind_result($stmt, $row->saleIndex
								,$row->saleNo
								,$row->saleType
								,$row->customerIndex
								,$row->saleDone
								,$row->creditCardID
								,$row->approveCode
								,$row->saleTotalAmount
								,$row->saleTotalDiscount
								,$row->saleTotalBalance
								,$row->creditCardAuthorizer
								,$row->CRE_DTE
								,$row->CRE_USR
								,$row->UPD_DTE
								,$row->UPD_USR
								,$row->DEL_DTE
								,$row->DEL_USR
								,$row->userName);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows_list_saleDetail[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->saleIndex
								,$row->saleNo
								,$row->saleType
								,$row->customerIndex
								,$row->saleDone
								,$row->creditCardID
								,$row->approveCode
								,$row->saleTotalAmount
								,$row->saleTotalDiscount
								,$row->saleTotalBalance
								,$row->creditCardAuthorizer
								,$row->CRE_DTE
								,$row->CRE_USR
								,$row->UPD_DTE
								,$row->UPD_USR
								,$row->DEL_DTE
								,$row->DEL_USR
								,$row->userName);
	    }
		
		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);
		
		
		$rows_data = new stdClass();
		$rows_data->saleSummary = $result_summary;
		$rows_data->listSaleDetail = $rows_list_saleDetail;
		
		return $rows_data;

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


	/*
	*
	* addSalelistTransition + Topping = addSalelistTransition_andTopping()
	*
	*/
	public function addSalelistTransition_andTopping($saledetail,$itemlist) {

		$autoidlist = array();
		//for($i = 0;$i<sizeof($itemlist);$i++){
		//	$item = $itemlist[$i];
		foreach($itemlist as $item){
			// Query Check Item Qty
			$itemStock = 0;

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
					else if($itemOpt->saleClass == "Fl"){
						// Query Check Item Qty
						$itemStock = 0;
						$quantity = 0;

						/*
						*
						* check flavor before update stockQTY
						* Beware this hard code $itemOpt->itemIndex and flavorID
						*/
						if($itemOpt->name === '0gS')
						{
							$flavorID = 990000;
							$itemOpt->itemIndex = 229;
							$quantity = 1;
						}
						else if($itemOpt->name === '15gS')
						{
							$flavorID = 990001;
							$itemOpt->itemIndex = 230;
							$quantity = 1;
						}
						else if($itemOpt->name === '30gS')
						{
							$flavorID = 990002;
							$itemOpt->itemIndex = 231;
							$quantity = 1;
						}
						else if($itemOpt->name === '45gS')
						{
							$flavorID = 990003;
							$itemOpt->itemIndex = 232;
							$quantity = 1;
						}
						else if($itemOpt->name === '60gS')
						{
							$flavorID = 990004;
							$itemOpt->itemIndex = 233;
							$quantity = 1;
						} // End of Syrup Topping

						if($flavorID !== null){
							$stmt = mysqli_prepare($this->connection,
								"SELECT itemStock 
								FROM $this->table_item 
								WHERE itemID = ? LIMIT 1"
							);
							$this->throwExceptionOnError();

							mysqli_stmt_bind_param($stmt,"i",$flavorID);
							$this->throwExceptionOnError();

							mysqli_stmt_execute($stmt);
							$this->throwExceptionOnError();

							mysqli_stmt_bind_result($stmt,$col1);
							$this->throwExceptionOnError();

							mysqli_stmt_fetch($stmt);
							$this->throwExceptionOnError();
							$itemStock = $col1;
							mysqli_stmt_free_result($stmt);
							mysqli_stmt_close($stmt);
							$saleQTY = $quantity;
							$stockQty = $itemStock - $quantity; // $item->stockQTY

							// Update Item

							//$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_item SET itemStock = itemStock + ? WHERE itemID = ?");
							$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_item SET itemStock = ? WHERE itemID = ?");
							$this->throwExceptionOnError();

							//$itemOpt->saleQTY
							//mysqli_stmt_bind_param($stmt, 'ii', $qty, $itemID);
							mysqli_stmt_bind_param($stmt, 'ii', $stockQty, $flavorID);
							$this->throwExceptionOnError();

							mysqli_stmt_execute($stmt);
							$this->throwExceptionOnError();

							mysqli_stmt_free_result($stmt);

							mysqli_stmt_close($stmt);

						}
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

	/*************************************************************************************************
	*   Add Bill/Order Transaction function.
	*
	**************************************************************************************************/

	/**
	 * createBillTransaction untested
	 */
	public function createBillTransaction($saledetail,$itemlist,$orderinfo) {
		$stockQty = 0;
		// CreateOrderInfo
		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->table_orderinfo (orderIndex, saleNo, tableNo, customerNum, order_DTE, UPD_DTE, UPD_USR, DEL_DTE, DEL_USR) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		$orderIndex = 0; // $orderinfo->orderIndex
		
		mysqli_stmt_bind_param($stmt, 'ississsss', 
		$orderIndex, $orderinfo->saleNo, $orderinfo->tableNo, 
		$orderinfo->customerNum, $orderinfo->order_DTE->toString('YYYY-MM-dd HH:mm:ss'), 
		$orderinfo->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $orderinfo->UPD_USR, 
		$orderinfo->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $orderinfo->DEL_USR);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		$autoid_orderinfo = mysqli_stmt_insert_id($stmt);

		mysqli_stmt_free_result($stmt);

		mysqli_stmt_close($stmt);
		
		// CreateSaleDetail
		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (saleIndex, saleNo, saleType, customerIndex, saleDone, creditCardID, approvalCode, saleTotalAmount, saleTotalDiscount, saleTotalBalance, creditCardAuthorizer, CRE_DTE, CRE_USR, UPD_DTE, UPD_USR, DEL_DTE, DEL_USR) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		$saleIndex = 0; // $saledetail->saleIndex
		$saleDone = 0; // $saledetail->saleDone
		mysqli_stmt_bind_param($stmt, 'isiiissdddsssssss', $saleIndex, $saledetail->saleNo, $saledetail->saleType, $saledetail->customerIndex, $saleDone, $saledetail->creditCardID, $saledetail->approvalCode, $saledetail->saleTotalAmount, $saledetail->saleTotalDiscount, $saledetail->saleTotalBalance, $saledetail->creditCardAuthorizer, $saledetail->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->CRE_USR, $saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->UPD_USR, $saledetail->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->DEL_USR);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		$autoid_saledetail = mysqli_stmt_insert_id($stmt);

		mysqli_stmt_free_result($stmt);
		
		mysqli_stmt_close($stmt);
		
		// CreateSaleList
		$autoidlist = array();
		foreach($itemlist as $item){
			
			// CreateSaleList
			$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->table_salelist (saleNo, itemIndex, salePrice, saleQTY, stockQTY, saleDiscount, saleClass, CRE_USR, CRE_DTE, UPD_USR, UPD_DTE, DEL_USR, DEL_DTE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$this->throwExceptionOnError();

			mysqli_stmt_bind_param($stmt, 'siddddsssssss', $item->saleNo, $item->itemIndex, $item->salePrice, $item->saleQTY, $stockQty, $item->saleDiscount, $item->saleClass, $saledetail->CRE_USR, $saledetail->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->UPD_USR, $saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->DEL_USR, $saledetail->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'));
			$this->throwExceptionOnError();

			mysqli_stmt_execute($stmt);		
			$this->throwExceptionOnError();

			$item_autoid = mysqli_stmt_insert_id($stmt);
			
			array_push($autoidlist,$item_autoid);
			
			mysqli_stmt_free_result($stmt);	
			
			mysqli_stmt_close($stmt);
			
			if(sizeof($item->itemOPT)){
				foreach($item->itemOPT as $itemOpt)
				{
					// CreateSaleList OPT
					$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->table_salelist_opt (saleNo, primary_listindex, itemIndex, salePrice, saleQTY, stockQTY, saleDiscount, saleClass, localDataIndex, name, description, CRE_USR, CRE_DTE, UPD_USR, UPD_DTE, DEL_USR, DEL_DTE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$this->throwExceptionOnError();

					mysqli_stmt_bind_param($stmt, 'siiddddsissssssss', $itemOpt->saleNo, $item_autoid, $itemOpt->itemIndex, $itemOpt->salePrice, $itemOpt->saleQTY, $stockQty, $itemOpt->saleDiscount, $itemOpt->saleClass, $itemOpt->localDataIndex, $itemOpt->name, $itemOpt->desc, $saledetail->CRE_USR, $saledetail->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->UPD_USR, $saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->DEL_USR, $saledetail->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'));
					$this->throwExceptionOnError();

					mysqli_stmt_execute($stmt);		
					$this->throwExceptionOnError();
					
					mysqli_stmt_free_result($stmt);	
					
					mysqli_stmt_close($stmt);
					
				}
			}
		}
		
		return $this->getAllOrderInfo_own();
	}
	
	/**
	 * addNewItemToBill untested
	 */
	public function addNewItemToBill($saledetail,$itemlist) {
		$stockQty = 0;
		// Update SaleDetail
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET saleType=?, customerIndex=?, saleDone=?, 
			creditCardID=?, approvalCode=?, 
			saleTotalAmount=?, saleTotalDiscount=?, 
			saleTotalBalance=?, creditCardAuthorizer=?, 
			CRE_DTE=?, CRE_USR=?, UPD_DTE=?, UPD_USR=?, DEL_DTE=?, DEL_USR=? WHERE saleNo = ?");
		/*
		, saleType, customerIndex, saleDone, creditCardID, approvalCode, saleTotalAmount, saleTotalDiscount, 
		saleTotalBalance, creditCardAuthorizer, CRE_DTE, CRE_USR, UPD_DTE, UPD_USR, DEL_DTE, DEL_USR) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
		*/
		$this->throwExceptionOnError();

		$saleIndex = 0; // $saledetail->saleIndex
		$saleDone = 0; // $saledetail->saleDone
		mysqli_stmt_bind_param($stmt, 's', 
			$saledetail->saleType, $saledetail->customerIndex, $saleDone, 
			$saledetail->creditCardID, $saledetail->approvalCode, 
			$saledetail->saleTotalAmount, $saledetail->saleTotalDiscount, 
			$saledetail->saleTotalBalance, $saledetail->creditCardAuthorizer, 
			$saledetail->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->CRE_USR, 
			$saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->UPD_USR, 
			$saledetail->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->DEL_USR,
			$saledetail->saleNo);
		
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		//$autoid_saledetail = mysqli_stmt_insert_id($stmt);

		mysqli_stmt_free_result($stmt);
		
		mysqli_stmt_close($stmt);
		
		// CreateSaleList
		$autoidlist = array();
		foreach($itemlist as $item){
			
			// CreateSaleList
			$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->table_salelist (saleNo, itemIndex, salePrice, saleQTY, stockQTY, saleDiscount, saleClass, CRE_USR, CRE_DTE, UPD_USR, UPD_DTE, DEL_USR, DEL_DTE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$this->throwExceptionOnError();

			mysqli_stmt_bind_param($stmt, 'siddddsssssss', $item->saleNo, $item->itemIndex, $item->salePrice, $item->saleQTY, $stockQty, $item->saleDiscount, $item->saleClass, $saledetail->CRE_USR, $saledetail->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->UPD_USR, $saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->DEL_USR, $saledetail->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'));
			$this->throwExceptionOnError();

			mysqli_stmt_execute($stmt);		
			$this->throwExceptionOnError();

			$item_autoid = mysqli_stmt_insert_id($stmt);
			
			array_push($autoidlist,$item_autoid);
			
			mysqli_stmt_free_result($stmt);	
			
			mysqli_stmt_close($stmt);
			
			if(sizeof($item->itemOPT)){
				foreach($item->itemOPT as $itemOpt)
				{
					// CreateSaleList OPT
					$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->table_salelist_opt (saleNo, primary_listindex, itemIndex, salePrice, saleQTY, stockQTY, saleDiscount, saleClass, localDataIndex, name, description, CRE_USR, CRE_DTE, UPD_USR, UPD_DTE, DEL_USR, DEL_DTE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$this->throwExceptionOnError();

					mysqli_stmt_bind_param($stmt, 'siiddddsissssssss', $itemOpt->saleNo, $item_autoid, $itemOpt->itemIndex, $itemOpt->salePrice, $itemOpt->saleQTY, $stockQty, $itemOpt->saleDiscount, $itemOpt->saleClass, $itemOpt->localDataIndex, $itemOpt->name, $itemOpt->desc, $saledetail->CRE_USR, $saledetail->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->UPD_USR, $saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->DEL_USR, $saledetail->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'));
					$this->throwExceptionOnError();

					mysqli_stmt_execute($stmt);		
					$this->throwExceptionOnError();
					
					mysqli_stmt_free_result($stmt);	
					
					mysqli_stmt_close($stmt);
					
				}
			}
		}
		$saleNo = $saledetail->saleNo;
		//return 1;
		return $this->getSaledetailSalelist_bySaleNo($saleNo);
	}
	
	/**
	 * updateItemInBill untested
	 */
	public function updateItemInBill($saledetail,$itemlist) {
		$saleNo = $saledetail->saleNo;
		$stockQty = 0;
		// Update SaleDetail
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET saleType=?, customerIndex=?, saleDone=?, 
			creditCardID=?, approvalCode=?, 
			saleTotalAmount=?, saleTotalDiscount=?, 
			saleTotalBalance=?, creditCardAuthorizer=?, 
			CRE_DTE=?, CRE_USR=?, UPD_DTE=?, UPD_USR=?, DEL_DTE=?, DEL_USR=? WHERE saleNo = ?");
		/*
		, saleType, customerIndex, saleDone, creditCardID, approvalCode, saleTotalAmount, saleTotalDiscount, 
		saleTotalBalance, creditCardAuthorizer, CRE_DTE, CRE_USR, UPD_DTE, UPD_USR, DEL_DTE, DEL_USR) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
		*/
		$this->throwExceptionOnError();

		$saleIndex = 0; // $saledetail->saleIndex
		$saleDone = 0; // $saledetail->saleDone
		mysqli_stmt_bind_param($stmt, 'iiissdddssssssss', 
			$saledetail->saleType, $saledetail->customerIndex, $saleDone, 
			$saledetail->creditCardID, $saledetail->approvalCode, 
			$saledetail->saleTotalAmount, $saledetail->saleTotalDiscount, 
			$saledetail->saleTotalBalance, $saledetail->creditCardAuthorizer, 
			$saledetail->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->CRE_USR, 
			$saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->UPD_USR, 
			$saledetail->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->DEL_USR,
			$saledetail->saleNo);
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		mysqli_stmt_free_result($stmt);
		mysqli_stmt_close($stmt);
		// itemList Work
		foreach($itemlist as $item){
			switch($item->revFlag){
				case -1: // (-1 : RF_SETVOID) ==> Update this list to VOID
					$saleClass = 'Vo';
					$saleQTY = 0;
					//$itemIndex = $item->itemIndex;
					$listIndex = $item->listIndex;
					$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_salelist SET saleClass=?,saleQTY=? WHERE listIndex = ? AND saleNo = ?"); // Update Item
					mysqli_stmt_bind_param($stmt, 'siis', $saleClass, $saleQTY, $listIndex, $saleNo);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_free_result($stmt);	
					mysqli_stmt_close($stmt);
					break;
				case 1: // (1 : RF_NEWINSERT) ==> INSERT new row salelist/salelist_opt
					// CreateSaleList
					$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->table_salelist (saleNo, itemIndex, salePrice, saleQTY, stockQTY, saleDiscount, saleClass, CRE_USR, CRE_DTE, UPD_USR, UPD_DTE, DEL_USR, DEL_DTE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$this->throwExceptionOnError();
					$stockQTY = $item->stockQTY; //stockQTY ?
					mysqli_stmt_bind_param($stmt, 'siddddsssssss', 
						$item->saleNo, $item->itemIndex, 
						$item->salePrice, $item->saleQTY, $stockQTY, $item->saleDiscount, $item->saleClass, 
						$saledetail->CRE_USR, $saledetail->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), 
						$saledetail->UPD_USR, $saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), 
						$saledetail->DEL_USR, $saledetail->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'));
					$this->throwExceptionOnError();	
					mysqli_stmt_execute($stmt);
					$this->throwExceptionOnError();	
					$item_autoid = mysqli_stmt_insert_id($stmt);
					mysqli_stmt_free_result($stmt);	
					mysqli_stmt_close($stmt);
					if(sizeof($item->itemOPT)){
						foreach($item->itemOPT as $itemOpt)
						{
							$stockQTY = $itemOpt->stockQTY; //stockQTY ?
							// CreateSaleList OPT
							$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->table_salelist_opt (saleNo, primary_listindex, itemIndex, salePrice, saleQTY, stockQTY, saleDiscount, saleClass, localDataIndex, name, description, CRE_USR, CRE_DTE, UPD_USR, UPD_DTE, DEL_USR, DEL_DTE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
							mysqli_stmt_bind_param($stmt, 'siiddddsissssssss', $saleNo, $item_autoid, $itemOpt->itemIndex, $itemOpt->salePrice, $itemOpt->saleQTY, $stockQTY, $itemOpt->saleDiscount, $itemOpt->saleClass, $itemOpt->localDataIndex, $itemOpt->name, $itemOpt->desc, $saledetail->CRE_USR, $saledetail->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->UPD_USR, $saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->DEL_USR, $saledetail->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'));
							$this->throwExceptionOnError();
							mysqli_stmt_execute($stmt);
							$this->throwExceptionOnError();	
							mysqli_stmt_free_result($stmt);	
							mysqli_stmt_close($stmt);
						}
					}
					break;
				case 2: // (2 : RF_UPDATE) ==> Update rows of salelist/salelist_opt
					$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_salelist SET salePrice=?, saleQTY=?, stockQTY=?, saleDiscount=?, saleClass=?, CRE_DTE=?, CRE_USR=?, UPD_DTE=?, UPD_USR=?, DEL_DTE=?, DEL_USR=? WHERE saleNo=? AND listIndex=?");
					mysqli_stmt_bind_param($stmt, 'ddddssssssssi', 
						$item->salePrice, $item->saleQTY, $item->stockQTY, $item->saleDiscount, $item->saleClass, 
						$item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'),$item->CRE_USR, 
						$item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'),$item->UPD_USR, 
						$item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'),$item->DEL_USR, 
						$saleNo, $item->listIndex);
					$this->throwExceptionOnError();
					mysqli_stmt_execute($stmt);
					$this->throwExceptionOnError();
					mysqli_stmt_free_result($stmt);	
					mysqli_stmt_close($stmt);
					if(sizeof($item->itemOPT)){
						foreach($item->itemOPT as $itemOpt)
						{
							$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_salelist_opt 
								SET salePrice=?, saleQTY=?, stockQTY=?, saleDiscount=?, 
								saleClass=?, 
								localDataIndex=?, 
								name=?, description=?, 
								CRE_DTE=?, CRE_USR=?, 
								UPD_DTE=?, UPD_USR=?, 
								DEL_DTE=?, DEL_USR=? 
								WHERE saleNo=? AND primary_listindex=? AND itemIndex=?");
							mysqli_stmt_bind_param($stmt, 'ddddsisssssssssii', 
								$itemOpt->salePrice, $itemOpt->saleQTY, $itemOpt->stockQTY, $itemOpt->saleDiscount, 
								$itemOpt->saleClass, 
								$itemOpt->localDataIndex, 
								$itemOpt->name, $itemOpt->desc, 
								$itemOpt->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'),$itemOpt->CRE_USR, 
								$itemOpt->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'),$itemOpt->UPD_USR, 
								$itemOpt->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'),$itemOpt->DEL_USR, 
								$saleNo, $itemOpt->primary_listIndex, $itemOpt->itemIndex);
							$this->throwExceptionOnError();
							mysqli_stmt_execute($stmt);
							$this->throwExceptionOnError();
							mysqli_stmt_free_result($stmt);	
							mysqli_stmt_close($stmt);
						}
					}
					break;
				default:
				case 0: // (0 : RF_NOCHANGE) ==> No Action
					break;


			}

			/*
			// Some Problem

			$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_salelist SET salePrice=?, saleQTY=?, stockQTY=?, saleDiscount=?, saleClass=?, CRE_DTE=?, CRE_USR=?, UPD_DTE=?, UPD_USR=?, DEL_DTE=?, DEL_USR=? WHERE saleNo=? AND itemIndex=?");
			mysqli_stmt_bind_param($stmt, 'ddddssssssssi', 
				$item->salePrice, $item->saleQTY, $item->stockQty, $item->saleDiscount, $item->saleClass, 
				$item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'),$item->CRE_USR, 
				$item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'),$item->UPD_USR, 
				$item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'),$item->DEL_USR, 
				$item->saleNo, $item->itemIndex);
			$this->throwExceptionOnError();
			mysqli_stmt_execute($stmt);
			$this->throwExceptionOnError();
			mysqli_stmt_free_result($stmt);	
			mysqli_stmt_close($stmt);
			
			if(sizeof($item->itemOPT)){ // Check Item OPT
				foreach($item->itemOPT as $itemOpt) // START LOOP ITEM OPT ======================
				{
					if($itemOpt->primary_listIndex == 0){ // - if salelist_opt :: listIndex or primary_listIndex != 0
						$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->table_salelist_opt 
							(salePrice,saleQTY,stockQTY,saleDiscount,saleClass,
							localDataIndex,
							name,description,
							CRE_DTE,CRE_USR,
							UPD_DTE,UPD_USR,
							DEL_DTE,DEL_USR,
							saleNo,primary_listindex,itemIndex)
							VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)");
						mysqli_stmt_bind_param($stmt, 'ddddsisssssssssii', 
							$itemOpt->salePrice, $itemOpt->saleQTY, $itemOpt->stockQty, $itemOpt->saleDiscount, $itemOpt->saleClass, 
							$itemOpt->localDataIndex, 
							$itemOpt->name, $itemOpt->desc, 
							$itemOpt->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'),$itemOpt->CRE_USR, 
							$itemOpt->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'),$itemOpt->UPD_USR, 
							$itemOpt->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'),$itemOpt->DEL_USR, 
							$itemOpt->saleNo, $item->itemIndex, $itemOpt->itemIndex);
						$this->throwExceptionOnError();
						mysqli_stmt_execute($stmt);
						$this->throwExceptionOnError();
						mysqli_stmt_free_result($stmt);	
						mysqli_stmt_close($stmt);
					} else if($itemOpt->primary_listIndex != 0){ // - if salelist_opt :: listIndex or primary_listIndex != 0
						$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_salelist_opt 
							SET salePrice=?, saleQTY=?, stockQTY=?, saleDiscount=?, 
							saleClass=?, 
							localDataIndex=?, 
							name=?, description=?, 
							CRE_DTE=?, CRE_USR=?, 
							UPD_DTE=?, UPD_USR=?, 
							DEL_DTE=?, DEL_USR=? 
							WHERE saleNo=? AND primary_listindex=? AND itemIndex=?");
						mysqli_stmt_bind_param($stmt, 'ddddsisssssssssii', 
							$itemOpt->salePrice, $itemOpt->saleQTY, $itemOpt->stockQty, $itemOpt->saleDiscount, 
							$itemOpt->saleClass, 
							$itemOpt->localDataIndex, 
							$itemOpt->name, $itemOpt->desc, 
							$itemOpt->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'),$itemOpt->CRE_USR, 
							$itemOpt->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'),$itemOpt->UPD_USR, 
							$itemOpt->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'),$itemOpt->DEL_USR, 
							$itemOpt->saleNo, $itemOpt->primary_listIndex, $itemOpt->itemIndex);
						$this->throwExceptionOnError();
						mysqli_stmt_execute($stmt);
						$this->throwExceptionOnError();
						mysqli_stmt_free_result($stmt);	
						mysqli_stmt_close($stmt);
					}
				} // END LOOP ITEM OPT ======================================================
			}

			*/
		}
		
		//return 1;
		return $this->getSaledetailSalelist_bySaleNo($saleNo);
	}
	
	/**
	 * voidBillPayment untested
	 */
	public function voidBillPayment($saledetail) {
		$saleDone = -1;
		$saleNo = $saledetail->saleNo;
		$paidDTE = $saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss');
		
		// void Order Info
		//$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_orderinfo SET paid_DTE=? WHERE saleNo=?");
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_orderinfo SET paid_DTE=? WHERE saleNo=?");
		$this->throwExceptionOnError();

		//mysqli_stmt_bind_param($stmt, 'ss', $DTE->toString('YYYY-MM-dd HH:mm:ss'), $saleNo);
		mysqli_stmt_bind_param($stmt, 'ss', $paidDTE, $saleNo);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		mysqli_stmt_free_result($stmt);
		mysqli_stmt_close($stmt);
		
		// void SaleDetail
		//$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET saleDone=-1 WHERE saleNo=?");
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET saleDone=? WHERE saleNo=?");
		$this->throwExceptionOnError();
		
		//mysqli_stmt_bind_param($stmt, 's', $saleNo);
		mysqli_stmt_bind_param($stmt, 'is', $saleDone, $saleNo);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		mysqli_stmt_free_result($stmt);
		mysqli_stmt_close($stmt);
		
		return $this->getAllOrderInfo_own();
	}

	/**
	 * voidItemInBill untested
	 */
	public function voidItemInBill($saleNo, $voidItemList) {
		$saleClass = 'Vo';
		// void SaleList
		foreach($voidItemList as $item){
			$itemIndex = $item->itemIndex;
			//$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_item SET saleClass=? WHERE itemIndex = ? AND saleNo = ?"); // Update Item
			$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_salelist SET saleClass=? WHERE itemIndex = ? AND saleNo = ?"); // Update Item // Fixbug 1.15

			mysqli_stmt_bind_param($stmt, 'sis', $saleClass, $itemIndex, $saleNo);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_free_result($stmt);	
			mysqli_stmt_close($stmt);
			/*
			if(sizeof($item->itemOPT)){ // Check Item OPT
				foreach($item->itemOPT as $itemOpt) // START LOOP ITEM OPT ======================
				{
					$itemIndex = $itemOpt->itemIndex;
					$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_item SET saleClass=? WHERE itemIndex = ? AND saleNo = ?"); // Update Item
					mysqli_stmt_bind_param($stmt, 'sis', $saleClass, $itemIndex, $saleNo);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_free_result($stmt);	
					mysqli_stmt_close($stmt);
				} // END LOOP ITEM OPT ======================================================
			}
			*/
		}
		
		// void SaleDetail
		/*
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET saleTotalAmount=? , saleTotalDiscount=? , saleTotalBalance=? WHERE saleNo=?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'idds', $saledetail->saleTotalAmount, $saledetail->saleTotalDiscount, $saledetail->saleTotalBalance, $saleNo);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		mysqli_stmt_free_result($stmt);
		mysqli_stmt_close($stmt);
		*/
		return $this->getSaledetailSalelist_bySaleNo($saleNo);
	}
	/**
	 * updateBillPayment untested
	 */
	public function updateBillPayment($saledetail, $itemlist) {
		$saleNo = $saledetail->saleNo;
		
		foreach($itemlist as $item){
			$itemStock = $this->checkItemStock($item->itemIndex); // Query Check Item Qty
			$saleQTY = $item->saleQTY; 
			$stockQty = $itemStock - $item->saleQTY; // $item->stockQTY
			$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_item SET itemStock = ? WHERE itemIndex = ?"); // Update Item
			mysqli_stmt_bind_param($stmt, 'ii', $stockQty, $item->itemIndex);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_free_result($stmt);	
			mysqli_stmt_close($stmt);
			
			$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_salelist SET stockQTY = ? WHERE itemIndex = ? AND saleNo = ?"); // Update SaleList
			mysqli_stmt_bind_param($stmt, 'iis', $stockQty, $item->itemIndex, $saleNo);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_free_result($stmt);	
			mysqli_stmt_close($stmt);
			
			if(sizeof($item->itemOPT)){ // Check Item OPT
				foreach($item->itemOPT as $itemOpt) // START LOOP ITEM OPT ======================
				{
					$stockQty = 0;
					//if($itemOpt->saleClass == "Rt"){ // Unknown
						$itemStock = $this->checkItemStock($itemOpt->itemIndex); // Query Check Item Qty
						$saleQTY = $itemOpt->saleQTY;
						$stockQty = $itemStock - $itemOpt->saleQTY; // $item->stockQTY
						$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_item SET itemStock = ? WHERE itemIndex = ?"); // Update Item
						mysqli_stmt_bind_param($stmt, 'ii', $stockQty, $itemOpt->itemIndex);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_free_result($stmt);	
						mysqli_stmt_close($stmt);
			
						$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_salelist_opt SET stockQTY = ? WHERE itemIndex = ? AND saleNo = ?"); // Update SaleList
						mysqli_stmt_bind_param($stmt, 'iis', $stockQty, $itemOpt->itemIndex, $saleNo);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_free_result($stmt);	
						mysqli_stmt_close($stmt);
					//} 
				} // END LOOP ITEM OPT ======================================================
			}
		
		}
		
		// void Order Info
		//$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_orderinfo SET paid_DTE=? WHERE saleNo=?");
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_orderinfo SET paid_DTE=? WHERE saleNo=?");
		$this->throwExceptionOnError();

		//mysqli_stmt_bind_param($stmt, 'ss', $DTE->toString('YYYY-MM-dd HH:mm:ss'), $saleNo);
		mysqli_stmt_bind_param($stmt, 'ss', $saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saleNo);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		mysqli_stmt_free_result($stmt);
		mysqli_stmt_close($stmt);
		
		// void SaleDetail
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename 
			SET saleDone=? , 
			saleTotalAmount=? , 
			saleTotalDiscount=? , 
			saleTotalBalance=? 
			WHERE saleNo=?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'iidds', $saledetail->saleDone, $saledetail->saleTotalAmount, $saledetail->saleTotalDiscount, $saledetail->saleTotalBalance, $saleNo);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		mysqli_stmt_free_result($stmt);
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

		mysqli_stmt_free_result($stmt);	
		mysqli_close($this->connection);
		
		return 1;
	}

	/**
	 * updateBillPayment_nocash
	 */
	public function updateBillPayment_nocash($saledetail, $itemlist) {
		$saleNo = $saledetail->saleNo;

		foreach($itemlist as $item){
			$itemStock = $this->checkItemStock($item->itemIndex); // Query Check Item Qty
			$saleQTY = $item->saleQTY; 
			$stockQty = $itemStock - $item->saleQTY; // $item->stockQTY
			$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_item SET itemStock = ? WHERE itemIndex = ?"); // Update Item
			mysqli_stmt_bind_param($stmt, 'ii', $stockQty, $item->itemIndex);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_free_result($stmt);	
			mysqli_stmt_close($stmt);
			
			$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_salelist SET stockQTY = ? WHERE itemIndex = ? AND saleNo = ?"); // Update SaleList
			mysqli_stmt_bind_param($stmt, 'iis', $stockQty, $item->itemIndex, $saleNo);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_free_result($stmt);	
			mysqli_stmt_close($stmt);
			
			if(sizeof($item->itemOPT)){ // Check Item OPT
				foreach($item->itemOPT as $itemOpt) // START LOOP ITEM OPT ======================
				{
					$stockQty = 0;
					//if($itemOpt->saleClass == "Rt"){ // Unknown
						$itemStock = $this->checkItemStock($itemOpt->itemIndex); // Query Check Item Qty
						$saleQTY = $itemOpt->saleQTY;
						$stockQty = $itemStock - $itemOpt->saleQTY; // $item->stockQTY
						$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_item SET itemStock = ? WHERE itemIndex = ?"); // Update Item
						mysqli_stmt_bind_param($stmt, 'ii', $stockQty, $itemOpt->itemIndex);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_free_result($stmt);	
						mysqli_stmt_close($stmt);
			
						$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_salelist_opt SET stockQTY = ? WHERE itemIndex = ? AND saleNo = ?"); // Update SaleList
						mysqli_stmt_bind_param($stmt, 'iis', $stockQty, $itemOpt->itemIndex, $saleNo);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_free_result($stmt);	
						mysqli_stmt_close($stmt);
					//} 
				} // END LOOP ITEM OPT ======================================================
			}
		
		}
		
		// void Order Info
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_orderinfo SET paid_DTE=? WHERE saleNo=?");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'ss', $saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saleNo);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		mysqli_stmt_free_result($stmt);
		mysqli_stmt_close($stmt);
		
		// void SaleDetail
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename 
			SET saleDone=? , 
			saleTotalAmount=? , 
			saleTotalDiscount=? , 
			saleTotalBalance=? 
			WHERE saleNo=?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'iidds', $saledetail->saleDone, $saledetail->saleTotalAmount, $saledetail->saleTotalDiscount, $saledetail->saleTotalBalance, $saleNo);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		mysqli_stmt_free_result($stmt);
		mysqli_stmt_close($stmt);

		return 1;
	}
	/*************************************************************************************************
	*   Reduce Function
	*
	**************************************************************************************************/
	
	/**
	 * checkItemStock
	 */
	public function checkItemStock($itemIndex) {
		$itemStock = 0;

		$stmt = mysqli_prepare($this->connection, "SELECT itemStock FROM $this->table_item WHERE itemIndex = ? LIMIT 1");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, "i", $itemIndex);
		$this->throwExceptionOnError();
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		mysqli_stmt_bind_result($stmt, $itemStock);
		$this->throwExceptionOnError();

		mysqli_stmt_fetch($stmt);
		$this->throwExceptionOnError();

		mysqli_stmt_free_result($stmt);
		mysqli_stmt_close($stmt);
		return $itemStock;
	}
	
	
	/*************************************************************************************************
	*   Addition Using
	*
	**************************************************************************************************/

	public function getAllOrderInfo_own() {
		// OrderInfo List
		$sql = "SELECT `o`.`orderIndex` AS  `orderIndex` , 
			`o`.`saleNo` AS  `saleNo` , 
			`o`.`tableNo` AS  `tableNo` , 
			`o`.`customerNum` AS  `customerNum` , 
			`o`.`order_DTE` AS  `order_DTE` , 
			`o`.`paid_DTE` AS  `paid_DTE` , 
			`o`.`UPD_USR` AS  `UPD_USR` , 
			`o`.`UPD_DTE` AS  `UPD_DTE` , 
			`o`.`DEL_USR` AS  `DEL_USR` , 
			`o`.`DEL_DTE` AS  `DEL_DTE`
			FROM `orderinfo` `o`
			WHERE `paid_DTE` IS NULL";
		$stmt = mysqli_prepare($this->connection,$sql);
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$orderinfoList = array();
		$row = new stdClass();
		mysqli_stmt_bind_result($stmt, $row->orderIndex,
			$row->saleNo,
			$row->tableNo,
			$row->customerNum,
			$row->order_DTE,
			$row->paid_DTE,
			$row->UPD_USR, 
			$row->UPD_DTE,
			$row->DEL_USR,
			$row->DEL_DTE);
		
	    while (mysqli_stmt_fetch($stmt)) {
			if(!is_null($row->order_DTE))
				$row->order_DTE = new DateTime($row->order_DTE);
			if(!is_null($row->UPD_DTE))
				$row->UPD_DTE = new DateTime($row->UPD_DTE);
			if(!is_null($row->DEL_DTE))
				$row->DEL_DTE = new DateTime($row->DEL_DTE);
			$orderinfoList[] = $row;
			$row = new stdClass();
			mysqli_stmt_bind_result($stmt, $row->orderIndex,
				$row->saleNo,
				$row->tableNo,
				$row->customerNum,
				$row->order_DTE,
				$row->paid_DTE,
				$row->UPD_USR, 
				$row->UPD_DTE,
				$row->DEL_USR,
				$row->DEL_DTE);
	    }
		
		mysqli_stmt_free_result($stmt);
		mysqli_stmt_close($stmt);
		
		return $orderinfoList;
	}
	
	
	/*************************************************************************************************
	*   Don't Know What i used now ?
	*
	**************************************************************************************************/

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
	
	/**
	 * Returns SaleDetail and SaleList get by SaleNo.
	 *
	 * Mixed Function
	 *
	 * 
	 * @return stdClass
	 */
	public function getSaledetailSalelist_bySaleNo($saleNo) {
		// SALEDETAIL
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename where saleNo='{$saleNo}' ");
		//echo("SELECT * FROM $this->tablename where saleNo='{$saleNo}' ");
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$row = new stdClass();
		mysqli_stmt_bind_result($stmt, $row->saleIndex, $row->saleNo, $row->saleType, $row->customerIndex, $row->saleDone, $row->creditCardID, $row->approvalCode, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance, $row->creditCardAuthorizer, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
		
	    if(mysqli_stmt_fetch($stmt)){
			$row->CRE_DTE = new DateTime($row->CRE_DTE);
			$row->UPD_DTE = new DateTime($row->UPD_DTE);
			$row->DEL_DTE = new DateTime($row->DEL_DTE);
			$saledetail = $row;
		}
		
		mysqli_stmt_free_result($stmt);
		mysqli_stmt_close($stmt);
		
		// SALELIST
		$sql = "SELECT  `c`.`listIndex` AS  `listIndex` , 
				`c`.`saleNo` AS  `saleNo` , 
				`c`.`itemIndex` AS  `itemIndex` , 
				`j`.`itemID` AS  `itemID` , 
				`j`.`itembarcodeID` AS  `itembarcodeID` , 
				`j`.`itemName` AS  `itemName` , 
				`c`.`salePrice` AS  `salePrice` , 
				`c`.`saleQTY` AS  `saleQTY` , 
				`c`.`stockQTY` AS  `stockQTY` , 
				`c`.`saleDiscount` AS  `saleDiscount` , 
				`c`.`saleClass` AS  `saleClass` , 
				`c`.`CRE_USR` AS  `CRE_USR` , 
				`c`.`CRE_DTE` AS `CRE_DTE` , 
				`c`.`UPD_USR` AS  `UPD_USR` , 
				`c`.`UPD_DTE` AS `UPD_DTE` , 
				`c`.`DEL_USR` AS  `DEL_USR` , 
				`c`.`DEL_DTE` AS `DEL_DTE` , 
				`j`.`itemCatagoryIndex` AS `itemCategoryIndex`, 
				`j`.`itemDetail` AS `itemDetail` ,
				`c`.`salePrice` AS `itemPrice` ,
				`c`.`saleQTY` AS `itemQTY` 
				FROM `salelist` `c` LEFT JOIN (SELECT * FROM `_item`)  `j` ON (`c`.`itemIndex` =  `j`.`itemIndex`) WHERE `c`.`saleNo` = '{$saleNo}'";
		//remark* No Calculation set query
		$stmt = mysqli_prepare($this->connection,$sql);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$itemlist = array();
		$row = new stdClass();
		mysqli_stmt_bind_result($stmt, $row->listIndex,
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
			$row->CRE_DTE,
			$row->UPD_USR,
			$row->UPD_DTE,
			$row->DEL_USR,
			$row->DEL_DTE,
			$row->itemCategoryIndex,
			$row->itemDetail,
			$row->itemPrice,
			$row->itemQTY);
		
	    while (mysqli_stmt_fetch($stmt)) {
			if(!is_null($row->CRE_DTE))
				$row->CRE_DTE = new DateTime($row->CRE_DTE);
			if(!is_null($row->UPD_DTE))
				$row->UPD_DTE = new DateTime($row->UPD_DTE);
			if(!is_null($row->DEL_DTE))
				$row->DEL_DTE = new DateTime($row->DEL_DTE);
			$row->itemOPT = array();
			$itemlist[] = $row;
			$row = new stdClass();
			mysqli_stmt_bind_result($stmt, $row->listIndex,
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
				$row->CRE_DTE,
				$row->UPD_USR,
				$row->UPD_DTE,
				$row->DEL_USR,
				$row->DEL_DTE,
				$row->itemCategoryIndex,
				$row->itemDetail,
				$row->itemPrice,
				$row->itemQTY);
	    }
		
		mysqli_stmt_free_result($stmt);
		mysqli_stmt_close($stmt);
		
		
		for($i = 0;$i<sizeof($itemlist);$i++){
			$optionPrice = 0;
			$primary_listindex = $itemlist[$i]->listIndex;
			$stmt = mysqli_prepare($this->connection,
				"SELECT  `c`.`listIndex` AS  `listIndex` , 
					`c`.`primary_listindex` AS  `primary_listindex` , 
					`c`.`saleNo` AS  `saleNo` , 
					`c`.`itemIndex` AS  `itemIndex` , 
					`j`.`itemID` AS  `itemID` , 
					`j`.`itembarcodeID` AS  `itembarcodeID` , 
					`j`.`itemName` AS  `itemName` , 
					`c`.`salePrice` AS  `salePrice` , 
					`c`.`saleQTY` AS  `saleQTY` , `c`.`stockQTY` AS  `stockQTY` , 
					`c`.`saleDiscount` AS  `saleDiscount` , 
					`c`.`saleClass` AS  `saleClass` , 
					`c`.`localDataIndex` AS  `localDataIndex` , 
					`c`.`name` AS  `name` , `c`.`description` AS  `desc` , 
					`c`.`CRE_USR` AS  `CRE_USR` , `c`.`CRE_DTE` AS `CRE_DTE` ,
					`c`.`UPD_USR` AS  `UPD_USR` , `c`.`UPD_DTE` AS `UPD_DTE` , 
					`c`.`DEL_USR` AS  `DEL_USR` , `c`.`DEL_DTE` AS `DEL_DTE` , 
					`c`.`saleQTY` AS `itemQTY` ,
					`c`.`salePrice` AS `itemPrice` 
					FROM `salelist_opt` `c` LEFT JOIN (SELECT * FROM `_item`)  `j` ON (`c`.`itemIndex` =  `j`.`itemIndex`) WHERE `c`.`saleNo` = '{$saleNo}' AND `c`.`primary_listindex` = '{$primary_listindex}' AND `c`.`DEL_USR` IS NULL");
			//remark* No Calculation set query
			mysqli_stmt_execute($stmt);
			
			$row = new stdClass();
			mysqli_stmt_bind_result($stmt, $row->listIndex,
				$row->primary_listindex,
				$row->saleNo,
				$row->itemIndex,
				$row->itemID,
				$row->itembarcodeID,
				$row->itemName,
				$row->salePrice, 
				$row->saleQTY,$row->stockQTY,
				$row->saleDiscount,
				$row->saleClass,
				$row->localDataIndex,
				$row->name,$row->desc,
				$row->CRE_USR,$row->CRE_DTE, 
				$row->UPD_USR,$row->UPD_DTE,
				$row->DEL_USR,$row->DEL_DTE,
				$row->itemQTY, 
				$row->itemPrice);
				
			while (mysqli_stmt_fetch($stmt)) {
				if(!is_null($row->CRE_DTE))
					$row->CRE_DTE = new DateTime($row->CRE_DTE);
				if(!is_null($row->UPD_DTE))
					$row->UPD_DTE = new DateTime($row->UPD_DTE);
				if(!is_null($row->DEL_DTE))
					$row->DEL_DTE = new DateTime($row->DEL_DTE);
				if($itemlist[$i]->saleClass != 'Vo'){
					$optionPrice += $row->itemPrice;
				}
				$itemlist[$i]->itemOPT[] = $row;
				
				$row = new stdClass();
				mysqli_stmt_bind_result($stmt, $row->listIndex,
					$row->primary_listindex,
					$row->saleNo,
					$row->itemIndex,
					$row->itemID,
					$row->itembarcodeID,
					$row->itemName,
					$row->salePrice, 
					$row->saleQTY,$row->stockQTY,
					$row->saleDiscount,
					$row->saleClass,
					$row->localDataIndex,
					$row->name,$row->desc,
					$row->CRE_USR,$row->CRE_DTE, 
					$row->UPD_USR,$row->UPD_DTE,
					$row->DEL_USR,$row->DEL_DTE,
					$row->itemQTY, 
					$row->itemPrice);
			}
			$itemlist[$i]->optionPrice = 0;
			$itemlist[$i]->SalePrice = 0;
			if($itemlist[$i]->saleClass != 'Vo'){
				$itemPrice = $itemlist[$i]->itemPrice;
				$itemQTY = $itemlist[$i]->itemQTY;
				$itemlist[$i]->optionPrice = $optionPrice;
				$itemlist[$i]->SalePrice = ($itemPrice + $optionPrice)*$itemQTY;
			}
		}
		
		$rows_data = new stdClass();
		$rows_data->saleDetail = $saledetail;
		$rows_data->itemList = $itemlist;
		
		return $rows_data;
		
	}

	public function addSalelistTransition_own($saledetail, $itemlist) {
		require_once 'ScustomerService.php';

		$autoidlist = array();

		foreach ($itemlist as $item) {
			//***** Query Check Item Qty
			$itemStock = 0;

			$stmt = mysqli_prepare($this->connection, "SELECT itemStock FROM $this->table_item WHERE itemIndex = ? LIMIT 1");
			$this->throwExceptionOnError();

			mysqli_stmt_bind_param($stmt, "i", $item->billItemIndex);  // $item->itemIndex
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

			/** WORKAROUND SSF-25 **/
			$saleQTY = floatval(str_replace(',', '', $item->billItemQty)); // $item->saleQTY
			$stockQty = $itemStock - $saleQTY; // $item->stockQTY

			//***** CreateSaleList
			$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->table_salelist (saleNo, itemIndex, salePrice, saleQTY, stockQTY, saleDiscount, saleClass, CRE_USR, CRE_DTE, UPD_USR, UPD_DTE, DEL_USR, DEL_DTE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$this->throwExceptionOnError();

			/** WORKAROUND ISSUE#15 sales front **/
			$billItemPrice = floatval(str_replace(',', '', $item->billItemPrice));

			$saleDiscount = 0.00; // $item->saleDiscount
			mysqli_stmt_bind_param($stmt, 'siddddsssssss', $saledetail->saleNo, $item->billItemIndex, $billItemPrice, $saleQTY, $stockQty, $saleDiscount, $item->billSaleClass, $saledetail->CRE_USR, $saledetail->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->UPD_USR, $saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->DEL_USR, $saledetail->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'));
			$this->throwExceptionOnError();

			mysqli_stmt_execute($stmt);
			$this->throwExceptionOnError();

			$item_autoid = mysqli_stmt_insert_id($stmt);

			array_push($autoidlist,$item_autoid);

			mysqli_stmt_free_result($stmt);
			mysqli_stmt_close($stmt);

			/** for debugging
			xdebug_start_trace();
			var_dump($item);
			var_dump($billItemPrice);
			gettype($billItemPrice);
			xdebug_stop_trace();
			**/

			//***** Update Item
			$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_item SET itemStock = ? WHERE itemIndex = ?");
			$this->throwExceptionOnError();

			mysqli_stmt_bind_param($stmt, 'ii', $stockQty, $item->billItemIndex);
			$this->throwExceptionOnError();

			mysqli_stmt_execute($stmt);
			$this->throwExceptionOnError();

			mysqli_stmt_free_result($stmt);
			mysqli_stmt_close($stmt);

			//*****
			// ITEM OPTION ============================ START ==============================
/**			if (sizeof($item->itemOPT)) {
				foreach($item->itemOPT as $itemOpt) {
					// DROPPED this condition
				}
			}

			//***** ITEM OPTION ============================ END ==============================
**/
		}

		//***** CreateSaleDetail
		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (saleIndex, saleNo, saleType, customerIndex, saleDone, creditCardID, approvalCode, saleTotalAmount, saleTotalDiscount, saleTotalBalance, creditCardAuthorizer, CRE_DTE, CRE_USR, UPD_DTE, UPD_USR, DEL_DTE, DEL_USR) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		$saleIndex = 0; //***** $saledetail->saleIndex

		mysqli_stmt_bind_param($stmt, 'isiiissdddsssssss', $saleIndex, $saledetail->saleNo, $saledetail->saleType, $saledetail->customerIndex, $saledetail->saleDone, $saledetail->creditCardID, $saledetail->approvalCode, $saledetail->saleTotalAmount, $saledetail->saleTotalDiscount, $saledetail->saleTotalBalance, $saledetail->creditCardAuthorizer, $saledetail->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->CRE_USR, $saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->UPD_USR, $saledetail->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->DEL_USR);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);	
		$this->throwExceptionOnError();

		//$autoid = $saledetail->saleIndex;
		$autoid_saledetail = mysqli_stmt_insert_id($stmt);

		mysqli_stmt_free_result($stmt);
		mysqli_stmt_close($stmt);

		//***** Retrieve last rows from Till Monitor
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

		//return $return_result;
*/

		/** Customer Registration **/
		 /** [TBC] Default Point Score Calculation **/
		$pointScore = $saledetail->saleTotalBalance/100;
		$customer_obj = new ScustomerService;
		$customer_obj->setCustomerPoint($saledetail->customerIndex, $pointScore);

		return $autoid_saledetail;
	}
	
	/**
	* No duplicated transaction, Prevent SSF-63 UI-Bouncing Problem
	*
	*
	*
	*/
	public function addSalelistTransition_own_distinct($saledetail, $itemlist) {
		
		// Check if same data exist
		
		$stmt = mysqli_prepare($this->connection, "SELECT saleIndex FROM $this->tablename WHERE saleNo = ? LIMIT 1");
			$this->throwExceptionOnError();

			mysqli_stmt_bind_param($stmt, "s", $saledetail->saleNo);  // $item->itemIndex
			$this->throwExceptionOnError();

			mysqli_stmt_execute($stmt);
			$this->throwExceptionOnError();

			mysqli_stmt_bind_result($stmt, $result);
			$this->throwExceptionOnError();

			mysqli_stmt_fetch($stmt);
			$this->throwExceptionOnError();

			mysqli_stmt_free_result($stmt);
			mysqli_stmt_close($stmt);
		
		if($result == 0){
			return $this->addSalelistTransition_own($saledetail, $itemlist);
		}
		else{
			return $result;
		}
	}

	public function addSalelistTransition_nocash($saledetail, $itemlist) {
		require_once 'ScustomerService.php';

		$autoidlist = array();

		foreach ($itemlist as $item) {
			//***** Query Check Item Qty
			$itemStock = 0;

			$stmt = mysqli_prepare($this->connection, "SELECT itemStock FROM $this->table_item WHERE itemIndex = ? LIMIT 1");
			$this->throwExceptionOnError();

			mysqli_stmt_bind_param($stmt, "i", $item->billItemIndex);  // $item->itemIndex
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

			$saleQTY = $item->billItemQty; // $item->saleQTY
			$stockQty = $itemStock - $item->billItemQty; // $item->stockQTY

			//***** CreateSaleList
			$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->table_salelist (saleNo, itemIndex, salePrice, saleQTY, stockQTY, saleDiscount, saleClass, CRE_USR, CRE_DTE, UPD_USR, UPD_DTE, DEL_USR, DEL_DTE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$this->throwExceptionOnError();

			/** WORKAROUND ISSUE#76 sales front **/
			$billItemPrice = floatval(str_replace(',', '', $item->billItemPrice));

			$saleDiscount = 0.00; // $item->saleDiscount
			mysqli_stmt_bind_param($stmt, 'siddddsssssss', $saledetail->saleNo, $item->billItemIndex, $billItemPrice, $item->billItemQty, $stockQty, $saleDiscount, $item->billSaleClass, $saledetail->CRE_USR, $saledetail->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->UPD_USR, $saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->DEL_USR, $saledetail->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'));
			$this->throwExceptionOnError();

			mysqli_stmt_execute($stmt);
			$this->throwExceptionOnError();

			$item_autoid = mysqli_stmt_insert_id($stmt);

			array_push($autoidlist,$item_autoid);

			mysqli_stmt_free_result($stmt);
			mysqli_stmt_close($stmt);

			//***** Update Item
			$stmt = mysqli_prepare($this->connection, "UPDATE $this->table_item SET itemStock = ? WHERE itemIndex = ?");
			$this->throwExceptionOnError();

			mysqli_stmt_bind_param($stmt, 'ii', $stockQty, $item->billItemIndex);
			$this->throwExceptionOnError();

			mysqli_stmt_execute($stmt);
			$this->throwExceptionOnError();

			mysqli_stmt_free_result($stmt);
			mysqli_stmt_close($stmt);
		}

		//***** CreateSaleDetail
		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (saleIndex, saleNo, saleType, customerIndex, saleDone, creditCardID, approvalCode, saleTotalAmount, saleTotalDiscount, saleTotalBalance, creditCardAuthorizer, CRE_DTE, CRE_USR, UPD_DTE, UPD_USR, DEL_DTE, DEL_USR) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		$saleIndex = 0; //***** $saledetail->saleIndex

		mysqli_stmt_bind_param($stmt, 'isiiissdddsssssss', $saleIndex, $saledetail->saleNo, $saledetail->saleType, $saledetail->customerIndex, $saledetail->saleDone, $saledetail->creditCardID, $saledetail->approvalCode, $saledetail->saleTotalAmount, $saledetail->saleTotalDiscount, $saledetail->saleTotalBalance, $saledetail->creditCardAuthorizer, $saledetail->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->CRE_USR, $saledetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->UPD_USR, $saledetail->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saledetail->DEL_USR);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);	
		$this->throwExceptionOnError();

		//$autoid = $saledetail->saleIndex;
		$autoid_saledetail = mysqli_stmt_insert_id($stmt);

		mysqli_stmt_free_result($stmt);
		mysqli_stmt_close($stmt);

		//***** Retrieve last rows from Till Monitor
		if ($result = mysqli_query($this->connection, "SELECT drawerBalance FROM $this->table_monitor ORDER BY actionIndex DESC LIMIT 1")) {
			if ($row = mysqli_fetch_row($result)) {
				// $row[0]
				$drawerBalance_old = $row[0];
			}
			// free result set
			mysqli_free_result($result);
		}

		mysqli_close($this->connection);

		/** Customer Registration **/
		 /** [TBC] Default Point Score Calculation **/
		$pointScore = $saledetail->saleTotalBalance/100;
		$customer_obj = new ScustomerService;
		$customer_obj->setCustomerPoint($saledetail->customerIndex, $pointScore);

		return $autoid_saledetail;
	}
	
	public function addSalelistTransition_nocash_distinct($saledetail, $itemlist) {

		// Check if same data exist
		
		$stmt = mysqli_prepare($this->connection, "SELECT saleIndex FROM $this->tablename WHERE saleNo = ? LIMIT 1");
			$this->throwExceptionOnError();

			mysqli_stmt_bind_param($stmt, "s", $saledetail->saleNo);  // $item->itemIndex
			$this->throwExceptionOnError();

			mysqli_stmt_execute($stmt);
			$this->throwExceptionOnError();

			mysqli_stmt_bind_result($stmt, $result);
			$this->throwExceptionOnError();

			mysqli_stmt_fetch($stmt);
			$this->throwExceptionOnError();

			mysqli_stmt_free_result($stmt);
			mysqli_stmt_close($stmt);
		
		if($result == 0){
			return $this->addSalelistTransition_nocash($saledetail, $itemlist);
		}
		else{
			return $result;
		}

		return $autoid_saledetail;
	}

	public function paymentAndCheckout($ccrr_obj, $saleDetail, $saleList)
	{
		if ($ccrr_obj->CHKOUT_ROLL == 1) {
			// Refund, similar to Cut Balance ////

			// retrieve last rows from Till Monitor
			if ($result = mysqli_query($this->connection, "SELECT drawerBalance FROM $this->table_monitor ORDER BY actionIndex DESC LIMIT 1")) {
				if ($row = mysqli_fetch_row($result)) {
					$drawerBalance_old = $row[0];
				}
				// free result set
				mysqli_free_result($result);
			}

			// Create the Refund transaction
			$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->table_monitor (actionIndex, drawerIndex, actionType, actionAmount, drawerBalance, CRE_DTE, CRE_USR, UPD_DTE, UPD_USR, DEL_DTE, DEL_USR) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$this->throwExceptionOnError();

			$actionIndex = 0; // Auto Gen.
			$drawerIndex = $saleDetail->drawerIndex;
			$actionType = $saleDetail->actionType . $ccrr_obj->listIndex;
			$actionAmount = $saleDetail->actionAmount;
			$drawerBalance = $drawerBalance_old - $actionAmount;

			mysqli_stmt_bind_param($stmt, 'iisddssssss', $actionIndex, $drawerIndex, $actionType, $actionAmount, $drawerBalance, $saleDetail->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saleDetail->CRE_USR, $saleDetail->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saleDetail->UPD_USR, $saleDetail->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $saleDetail->DEL_USR);
			$this->throwExceptionOnError();

			mysqli_stmt_execute($stmt);
			$this->throwExceptionOnError();

			$autoid_monitor = mysqli_stmt_insert_id($stmt);
			$ccrr_obj->CHKOUT_saleNo = 'Rf' . $autoid_monitor; // 'Rf' : $saleDetail->actionType (Refund)

			mysqli_stmt_free_result($stmt);	

			mysqli_close($this->connection);
		}
		else if ($ccrr_obj->CHKOUT_ROLL == 2) {
			// Do addSaleTransaction()
			

			// [TBC] $ccrr_obj->CHKOUT_saleNo = [TBC]
		}
		else if ($ccrr_obj->CHKOUT_ROLL == 3) {
			// Over due, do checkout and keep record only
			// No Refund
		}

		//$url = URL_TO_RECEIVING_PHP;
		$url = "http://192.168.1.212/SRPOS_CWS/controllers/grabcmd.php";

		$fields = array(
			"cardID" => $ccrr_obj->cardID,
			"CHKIN_DTE" => $ccrr_obj->CHKIN_DTE->toString('YYYY-MM-dd HH:mm:ss'),
			"CHKOUT_DTE" => $ccrr_obj->CHKOUT_DTE->toString('YYYY-MM-dd HH:mm:ss'),
			"CHKOUT_ROLL" => $ccrr_obj->CHKOUT_ROLL,
			"CHKOUT_saleNo" => $ccrr_obj->CHKOUT_saleNo,
			"CRE_DTE" => $ccrr_obj->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'),
			"CRE_USR" => $ccrr_obj->CRE_USR,
			"CWS_index" => $ccrr_obj->CWS_index,
			"DEL_DTE" => $ccrr_obj->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'),
			"DEL_USR" => $ccrr_obj->DEL_USR,
			"listIndex" => $ccrr_obj->listIndex,
			"Note" => $ccrr_obj->Note,
			"reserveDuration" => $ccrr_obj->reserveDuration,
			"saleNo" => $ccrr_obj->saleNo,
			"serviceUserID" => $ccrr_obj->serviceUserID,
			"spentDuration" => $ccrr_obj->spentDuration,
			"UPD_DTE" => $ccrr_obj->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'),
			"UPD_USR" => $ccrr_obj->UPD_USR
		);

		$postvars='';
		$sep='';
		foreach($fields as $key=>$value)
		{
				$postvars.= $sep.urlencode($key).'='.urlencode($value);
				$sep='&';
		}

		$ch = curl_init();

		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST,count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$result = curl_exec($ch);

		curl_close($ch);

/**		echo $result; // Test Result CAN NOT echo or var_dump here with Flex AMF!! **/
		//xdebug_start_trace();
			//var_dump($result);
			//xdebug_var_dump($result);
		//xdebug_stop_trace();
/** See more about this issue at https://xp-dev.com/trac/SMITDev/ticket/214#comment:2
    Miha Corlan talk about this issus  **/

		return $result;

	}
	
}

class SaleDetailList {
	var $saledetail;
	var $salelist;
}

class Salelist_st {
	var $listIndex;
	var $saleNo;
	var $itemIndex;
	var $itemID;
	var $itembarcodeID;
	var $itemName;
	var $salePrice; 
	var $saleQTY;
	var $stockQTY;
	var $saleDiscount;
	var $saleClass;
	var $itemOPT;
	var $CRE_USR;
	var $CRE_DTE;
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
