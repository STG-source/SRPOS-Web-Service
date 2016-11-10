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
class SaledetailviewService {

	var $username = "root";
	var $password = "";
	var $server = "localhost";
	var $port = 3306;
	var $databasename = "stechschema";
	var $tablename = "saledetailview";
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
	public function getAllSaledetailview() {

		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->saleIndex, $row->saleNo, $row->saleType, $row->customerIndex, $row->saleDone, $row->creditCardID, $row->approvalCode, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance, $row->creditCardAuthorizer, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->customerID, $row->fullname);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->saleIndex, $row->saleNo, $row->saleType, $row->customerIndex, $row->saleDone, $row->creditCardID, $row->approvalCode, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance, $row->creditCardAuthorizer, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->customerID, $row->fullname);
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
	public function getSaledetailviewByID($itemID) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename where saleIndex=?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'i', $itemID);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_result($stmt, $row->saleIndex, $row->saleNo, $row->saleType, $row->customerIndex, $row->saleDone, $row->creditCardID, $row->approvalCode, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance, $row->creditCardAuthorizer, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->customerID, $row->fullname);
		
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
	 * Returns the item corresponding to the value specified for the saleNo.
	 *
	 * Add authorization or any logical checks for secure access to your data
	 *
	 *
	 * @return stdClass
	 */
	public function getSaledetailviewBySaleNo($saleNo) {
		require_once 'ScustomerService.php';

		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename where saleNo=?");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 's', $saleNo);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		mysqli_stmt_bind_result($stmt, $row->saleIndex, $row->saleNo, $row->saleType, $row->customerIndex, $row->saleDone, $row->creditCardID, $row->approvalCode, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance, $row->creditCardAuthorizer, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->customerID, $row->fullname);

		if(mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);

		// Get SaleDetail for Customer By CustomerIndex
		if($row != null){
			$ScustomerService = new ScustomerService();
			$data_CustomerInfo = $ScustomerService->get_customerByID($row->customerIndex,0);
			$row->phone = $data_CustomerInfo->phone;
		}

	      return $row;
		} else {
	      return null;
		}
	}

	/**
	* get SaleDetail by date from to
	* Return Sale Detail
	**/
	public function getSale_bySaleNo($dateBegin, $dateEnd, $index, $length){
		$strSQL = "SELECT  
		s.saleIndex, 
		s.saleNo, 
		s.customerIndex, 
		s.saleType, 		
		s.saleDone, 		
		s.saleTotalAmount, 
		s.saleTotalDiscount, 
		s.saleTotalBalance, 
		s.CRE_DTE, 
		s.CRE_USR, 		
		u.userIndex as userIndex, 
		u.userID as userID, 
		u.fullname as userName 
		FROM saledetailview s 
		inner join _myuser u on u.userID = s.CRE_USR ";	
		
		$where = "WHERE (CONVERT_TZ(s.CRE_DTE, '+00:00', '+07:00') BETWEEN ? AND ?) ";

		if ($index > -1) {
			$where .= " LIMIT {$index}, {$length} ";
		}

		$strSQL .= $where;

		$stmt = mysqli_prepare($this->connection, $strSQL);
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'ss',
				$dateBegin,
				$dateEnd);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt, $row->saleIndex, 
										$row->saleNo, 
										$row->customerIndex,
										$row->saleType, 										 
										$row->saleDone, 
										$row->saleTotalAmount, 
										$row->saleTotalDiscount, 
										$row->saleTotalBalance, 
										$row->CRE_DTE, 
										$row->CRE_USR, 
										$row->userIndex, 
										$row->userID, 
										$row->userName);

	    while (mysqli_stmt_fetch($stmt)) {
		  $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
		  mysqli_stmt_bind_result($stmt, $row->saleIndex, 
										$row->saleNo, 
										$row->customerIndex,
										$row->saleType, 										 
										$row->saleDone, 
										$row->saleTotalAmount, 
										$row->saleTotalDiscount, 
										$row->saleTotalBalance, 
										$row->CRE_DTE, 
										$row->CRE_USR, 
										$row->userIndex, 
										$row->userID, 
										$row->userName);
	    }

		mysqli_stmt_free_result($stmt);
		mysqli_close($this->connection);

		return $rows;
		
		
	}
	
	/**
	* Query Sum of SaleDetail by from date to date and group by date
	**/
	
	public function getSale_byDay($dateBegin, $dateEnd, $index, $length){
		$strSQL = " SELECT a.count_sale_No,
					ifnull(a.saleTotalAmount,0) as saleTotalAmount , 
					ifnull(a.saleTotalDiscount,0) as saleTotalDiscount, 
					ifnull(a.saleTotalBalance,0) as saleTotalBalance, 
					ifnull(b.saleTotalBalance,0) as money, 
					ifnull(c.saleTotalBalance,0) as credit_done, 
					ifnull(d.saleTotalBalance,0) as credit_wait,
					a.CRE_DTE as CRE_DTE
					FROM (
					
					SELECT count( s.saleNo ) AS count_sale_No, sum( s.saleTotalAmount ) AS saleTotalAmount, sum( s.saleTotalDiscount ) AS saleTotalDiscount, sum( s.saleTotalBalance ) AS saleTotalBalance, date( convert_tz( s.CRE_DTE, '+00:00', '+07:00' ) ) as CRE_DTE
					FROM saledetailview s
					GROUP BY date( convert_tz( s.CRE_DTE, '+00:00', '+07:00' ) )
					) a 
					LEFT OUTER JOIN (
					
					SELECT sum( s.saleTotalBalance ) AS saleTotalBalance, date( convert_tz( s.CRE_DTE, '+00:00', '+07:00' ) ) as CRE_DTE
					FROM saledetailview s
					WHERE s.saleType =0
					GROUP BY date( convert_tz( s.CRE_DTE, '+00:00', '+07:00' ) )					
					) b ON b. CRE_DTE  = a. CRE_DTE
					
					LEFT OUTER JOIN (
					
					SELECT sum( s.saleTotalBalance ) AS saleTotalBalance, date( convert_tz( s.CRE_DTE, '+00:00', '+07:00' ) ) as CRE_DTE
					FROM saledetailview s
					WHERE s.saleType = 3 and saleDone <> 0
					GROUP BY date( convert_tz( s.CRE_DTE, '+00:00', '+07:00' ) )					
					) c ON c. CRE_DTE  = a. CRE_DTE
					
					LEFT OUTER JOIN (
					
					SELECT sum( s.saleTotalBalance ) AS saleTotalBalance, date( convert_tz( s.CRE_DTE, '+00:00', '+07:00' ) ) as CRE_DTE
					FROM saledetailview s
					WHERE s.saleType = 3 and saleDone = 0
					GROUP BY date( convert_tz( s.CRE_DTE, '+00:00', '+07:00' ) )
					) d ON d. CRE_DTE  = a. CRE_DTE ";					
		
		
		$where = " WHERE (CONVERT_TZ(a. CRE_DTE, '+00:00', '+07:00') BETWEEN ? AND ?) ";

		if ($index > -1) {
			$where .= " LIMIT {$index}, {$length} ";
		}

		$strSQL .= $where;
		

		$stmt = mysqli_prepare($this->connection, $strSQL);
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'ss',	$dateBegin,	$dateEnd);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt, $row->count_sale_No,
										$row->saleTotalAmount , 
										$row->saleTotalDiscount, 
										$row->saleTotalBalance, 
										$row->money, 
										$row->credit_done, 
										$row->credit_wait,
										$row->CRE_DTE);

	    while (mysqli_stmt_fetch($stmt)) {
		  $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
		 mysqli_stmt_bind_result($stmt, $row->count_sale_No,
										$row->saleTotalAmount , 
										$row->saleTotalDiscount, 
										$row->saleTotalBalance, 
										$row->money, 
										$row->credit_done, 
										$row->credit_wait,
										$row->CRE_DTE);
	    }

		mysqli_stmt_free_result($stmt);
		mysqli_close($this->connection);

		return $rows;
		
		
	}
	
	/**
	* Query Sum of SaleDetail by fromdate to date and Group by Year by Month
	**/
	public function getSale_byMonth($dateBegin, $dateEnd, $index, $length){
		$strSQL = " SELECT 
					a.count_sale_No,
					ifnull(a.saleTotalAmount,0) as saleTotalAmount , 
					ifnull(a.saleTotalDiscount,0) as saleTotalDiscount, 
					ifnull(a.saleTotalBalance,0) as saleTotalBalance, 
					ifnull(b.saleTotalBalance,0) as money, 
					ifnull(c.saleTotalBalance,0) as credit_done, 
					ifnull(d.saleTotalBalance,0) as credit_wait,
					a.CRE_MONTH,
					a.CRE_YEAR
					FROM 
					(
					
						SELECT count( s.saleNo ) AS count_sale_No, 
						sum( s.saleTotalAmount ) AS saleTotalAmount, 
						sum( s.saleTotalDiscount ) AS saleTotalDiscount, 
						sum( s.saleTotalBalance ) AS saleTotalBalance, 
						month( CONVERT_TZ( s.CRE_DTE, '+00:00', '+07:00' ) ) AS CRE_MONTH, 
						year( CONVERT_TZ( s.CRE_DTE, '+00:00', '+07:00' ) ) AS CRE_YEAR
						
						FROM saledetailview s
						WHERE (CONVERT_TZ(s. CRE_DTE, '+00:00', '+07:00') BETWEEN ? AND ?)
						GROUP BY month( CONVERT_TZ( s.CRE_DTE, '+00:00', '+07:00' ) ) , 
						year( CONVERT_TZ( s.CRE_DTE, '+00:00', '+07:00' ) )
					
					) a
					
					LEFT OUTER JOIN (
					
						SELECT sum( s.saleTotalBalance ) AS saleTotalBalance, 
						month( CONVERT_TZ( s.CRE_DTE, '+00:00', '+07:00' ) ) AS CRE_MONTH, 
						year( CONVERT_TZ( s.CRE_DTE, '+00:00', '+07:00' ) ) AS CRE_YEAR
						FROM saledetailview s
						WHERE s.saleType =0
						and  (CONVERT_TZ(s. CRE_DTE, '+00:00', '+07:00') BETWEEN ? AND ?)
						GROUP BY  
						month( CONVERT_TZ( s.CRE_DTE, '+00:00', '+07:00' ) ) , 
						year( CONVERT_TZ( s.CRE_DTE, '+00:00', '+07:00' ) )
					
					) b ON b. CRE_MONTH  = a. CRE_MONTH and b.CRE_YEAR = a.CRE_YEAR 
					
					LEFT OUTER JOIN (
					
						SELECT sum( s.saleTotalBalance ) AS saleTotalBalance, 
						month( CONVERT_TZ( s.CRE_DTE, '+00:00', '+07:00' ) ) AS CRE_MONTH, 
						year( CONVERT_TZ( s.CRE_DTE, '+00:00', '+07:00' ) ) AS CRE_YEAR
						FROM saledetailview s
						WHERE s.saleType = 3 and saleDone <> 0
						and (CONVERT_TZ(s. CRE_DTE, '+00:00', '+07:00') BETWEEN ? AND ?)
						GROUP BY  
						month( CONVERT_TZ( s.CRE_DTE, '+00:00', '+07:00' ) ) , 
						year( CONVERT_TZ( s.CRE_DTE, '+00:00', '+07:00' ) )
					
					) c ON c. CRE_MONTH  = a. CRE_MONTH and c.CRE_YEAR = a.CRE_YEAR
					
					LEFT OUTER JOIN (
					
						SELECT sum( s.saleTotalBalance ) AS saleTotalBalance, 
						month( CONVERT_TZ( s.CRE_DTE, '+00:00', '+07:00' ) ) AS CRE_MONTH, 
						year( CONVERT_TZ( s.CRE_DTE, '+00:00', '+07:00' ) ) AS CRE_YEAR
						FROM saledetailview s
						WHERE s.saleType = 3 and saleDone = 0
						and (CONVERT_TZ(s. CRE_DTE, '+00:00', '+07:00') BETWEEN ? AND ?)
						GROUP BY  
						month( CONVERT_TZ( s.CRE_DTE, '+00:00', '+07:00' ) ) , 
						year( CONVERT_TZ( s.CRE_DTE, '+00:00', '+07:00' ) )
					
					) d ON d. CRE_MONTH  = a. CRE_MONTH and d.CRE_YEAR = a.CRE_YEAR
					
					ORDER BY a.CRE_YEAR, a. CRE_MONTH ";					
		
		if ($index > -1) {
			$strSQL .= " LIMIT {$index}, {$length} ";
		}		
		

		$stmt = mysqli_prepare($this->connection, $strSQL);
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'ssssssss',$dateBegin,$dateEnd,$dateBegin,$dateEnd,$dateBegin,$dateEnd,$dateBegin,$dateEnd);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt, $row->count_sale_No,
										$row->saleTotalAmount , 
										$row->saleTotalDiscount, 
										$row->saleTotalBalance, 
										$row->money, 
										$row->credit_done, 
										$row->credit_wait,
										$row->CRE_MONTH,
										$row->CRE_YEAR);

	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
		 mysqli_stmt_bind_result($stmt, $row->count_sale_No,
										$row->saleTotalAmount , 
										$row->saleTotalDiscount, 
										$row->saleTotalBalance, 
										$row->money, 
										$row->credit_done, 
										$row->credit_wait,
										$row->CRE_MONTH,
										$row->CRE_YEAR);
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
	public function createSaledetailview($item) {

		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (saleIndex, saleNo, saleType, customerIndex, saleDone, creditCardID, approvalCode, saleTotalAmount, saleTotalDiscount, saleTotalBalance, creditCardAuthorizer, CRE_DTE, CRE_USR, UPD_DTE, UPD_USR, DEL_DTE, DEL_USR, customerID, fullname) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'isiiissdddsssssssss', $item->saleIndex, $item->saleNo, $item->saleType, $item->customerIndex, $item->saleDone, $item->creditCardID, $item->approvalCode, $item->saleTotalAmount, $item->saleTotalDiscount, $item->saleTotalBalance, $item->creditCardAuthorizer, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->customerID, $item->fullname);
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
	public function updateSaledetailview($item) {
	
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET saleIndex=?, saleNo=?, saleType=?, customerIndex=?, saleDone=?, creditCardID=?, approvalCode=?, saleTotalAmount=?, saleTotalDiscount=?, saleTotalBalance=?, creditCardAuthorizer=?, CRE_DTE=?, CRE_USR=?, UPD_DTE=?, UPD_USR=?, DEL_DTE=?, DEL_USR=?, customerID=?, fullname=? WHERE saleIndex=?");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'isiiissdddsssssssssi', $item->saleIndex, $item->saleNo, $item->saleType, $item->customerIndex, $item->saleDone, $item->creditCardID, $item->approvalCode, $item->saleTotalAmount, $item->saleTotalDiscount, $item->saleTotalBalance, $item->creditCardAuthorizer, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->customerID, $item->fullname, $item->saleIndex);		
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
	public function deleteSaledetailview($itemID) {
				
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
	public function getSaledetailview_paged($startIndex, $numItems) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename LIMIT ?, ?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ii', $startIndex, $numItems);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->saleIndex, $row->saleNo, $row->saleType, $row->customerIndex, $row->saleDone, $row->creditCardID, $row->approvalCode, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance, $row->creditCardAuthorizer, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->customerID, $row->fullname);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->saleIndex, $row->saleNo, $row->saleType, $row->customerIndex, $row->saleDone, $row->creditCardID, $row->approvalCode, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance, $row->creditCardAuthorizer, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->customerID, $row->fullname);
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
	 * Returns saledetailview matched the search criteria (KP)
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function getSearch_saledetailview($searchCause) {
		 
	    $stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();
				
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->saleIndex, $row->saleNo, $row->saleType, $row->customerIndex, $row->saleDone, $row->creditCardID, $row->approvalCode, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance, $row->creditCardAuthorizer, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->customerID, $row->fullname);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->saleIndex, $row->saleNo, $row->saleType, $row->customerIndex, $row->saleDone, $row->creditCardID, $row->approvalCode, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance, $row->creditCardAuthorizer, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->customerID, $row->fullname);
	    }
		
		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);
		
		return $rows;
	}
	
	/**
	 * Returns saledetailview by day matched the search criteria (KP)
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function getSearch_saledetailviewByDay($searchCause, $index = -1, $length = 0)
	{
		$limit = "";

		if ($index > -1) {
			$limit .= " LIMIT {$index}, {$length} ";
		}

		$searchCause .= $limit;
	    $stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();
				
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->CRE_DTE, $row->billCount, $row->sumTotalAmount, $row->sumTotalDiscount, $row->sumTotalBalance);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->CRE_DTE, $row->billCount, $row->sumTotalAmount, $row->sumTotalDiscount, $row->sumTotalBalance);
	    }
		
		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);
		
		return $rows;
	}

	public function getSearch_saledetailviewByDay_Count($searchCause)
	{
		$saleByDay = $this->getSearch_saledetailviewByDay($searchCause);
		return count($saleByDay);
	}

	public function getSearch_saledetailviewByDay_Area($searchCause, $index, $length)
	{
		$saleByDay = $this->getSearch_saledetailviewByDay($searchCause, $index, $length);
		return $saleByDay;
	}

	/**
	 * Returns saledetailview by XXX matched the search criteria (KP)
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function getSearch_saledetailviewByXXX($searchCause, $index = -1, $length = 0)
	{
		$limit = "";

		if ($index > -1) {
			$limit .= " LIMIT {$index}, {$length} ";
		}

		$searchCause .= $limit;
	    $stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();
				
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->CRE_YEAR, $row->CRE_XXX, $row->billCount, $row->sumTotalAmount, $row->sumTotalDiscount, $row->sumTotalBalance);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->CRE_YEAR, $row->CRE_XXX, $row->billCount, $row->sumTotalAmount, $row->sumTotalDiscount, $row->sumTotalBalance);
	    }
		
		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);
		
		return $rows;
	}

	public function getSearch_saledetailviewByXXX_Count($searchCause)
	{
		$saleDetailByXXX = $this->getSearch_saledetailviewByXXX($searchCause);
		return count($saleDetailByXXX);
	}

	public function getSearch_saledetailviewByXXX_Area($searchCause, $index, $length)
	{
		$saleDetailByXXX = $this->getSearch_saledetailviewByXXX($searchCause, $index, $length);
		return $saleDetailByXXX;
	}

	/**
	 * Returns max bill number from saledetailview table (KP)
	 *   revised  up by Joe 
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
	
	/**
	 * Returns saledetailview by day matched the search criteria (KP)
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function getSearch_saledetailviewForChart($searchCause) {
		 
	    $stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();
				
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->CRE_DTE1, $row->billCount, $row->sumTotalAmount, $row->sumTotalDiscount, $row->sumTotalBalance);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->CRE_DTE1, $row->billCount, $row->sumTotalAmount, $row->sumTotalDiscount, $row->sumTotalBalance);
	    }
		
		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);
		
		return $rows;
	}

	public function getSearch_soldItem($searchCause, $index = -1, $length = 0)
	{
		$limit = "";

		if ($index > -1) {
			$limit .= " LIMIT {$index}, {$length} ";
		}

		$searchCause .= $limit;
	    $stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itemName, $row->itemDesc, $row->sumSoldQTY,$row->itemPrice,$row->TotalPrice);

	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itemName, $row->itemDesc, $row->sumSoldQTY,$row->itemPrice,$row->TotalPrice);
	    }

		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);

		return $rows;
	}

	public function getSearch_soldItem_Count($searchCause)
	{
		$soldItem = $this->getSearch_soldItem($searchCause);
		return count($soldItem);
	}

	public function getSearch_soldItem_Area($searchCause, $index, $length)
	{
		$soldItem = $this->getSearch_soldItem($searchCause, $index, $length);
		return count($soldItem);
	}

	public function getBalanceMovement($fromDate, $endDate, $index = -1, $length = 0) 
	{
		$sql = "SELECT `j`.`actionIndex` as `actionIndex`"
		.", `j`.`drawerIndex` as `drawerIndex`"
		.", `j`.`actionType` as `actionType`"
		.", `j`.`actionAmount` as `actionAmount`"
		.", `j`.`drawerBalance` as `drawerBalance`"
		.", if(isnull(`j`.`UPD_USR`),`j`.`CRE_DTE`,`j`.`UPD_DTE`) AS `CRE_DTE`"
		.", if(isnull(`j`.`UPD_USR`),`j`.`CRE_USR`,`j`.`UPD_USR`) AS `CRE_USR`"
		.", `s`.`userIndex` as `userIndex`"
		.", `s`.`fullname` as `fullname`"
		.", `s`.`myusername` as `myusername`"
		." FROM (_till_monitor `j` JOIN _myuser `s`) ";

		$where = "WHERE ((CONVERT_TZ(`j`.`CRE_DTE`, '+00:00', '+07:00') BETWEEN ? AND ?) OR (CONVERT_TZ(`j`.`UPD_DTE`, '+00:00', '+07:00') BETWEEN ? AND ?)) AND (`j`.`CRE_USR` = `s`.`userID`) ";

		if ($index > -1) {
			$where .= " LIMIT {$index}, {$length} ";
		}

		$sql .= $where;

		$stmt = mysqli_prepare($this->connection, $sql);
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'ssss',
				$fromDate,
				$endDate,
				$fromDate,
				$endDate);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt, $row->actionIndex, $row->drawerIndex, $row->actionType, $row->actionAmount, $row->drawerBalance, $row->CRE_DTE, $row->CRE_USR, $row->userIndex, $row->fullname, $row->myusername);

	    while (mysqli_stmt_fetch($stmt)) {
		  $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
		  mysqli_stmt_bind_result($stmt, $row->actionIndex, $row->drawerIndex, $row->actionType, $row->actionAmount, $row->drawerBalance, $row->CRE_DTE, $row->CRE_USR, $row->userIndex, $row->fullname, $row->myusername);
	    }

		mysqli_stmt_free_result($stmt);
		mysqli_close($this->connection);

		return $rows;
	}

	public function getBalanceMovement_Count($fromDate, $endDate) {
/***	$balance_rows = array();  **/
		$balance_rows = $this->getBalanceMovement($fromDate, $endDate);

		return count($balance_rows);
	}

	public function getBalanceMovement_Area($fromDate, $endDate, $index, $length) {
		$balance_rows = $this->getBalanceMovement($fromDate, $endDate, $index, $length);

		return $balance_rows;
	}

	public function getSearch_ItemCosts($searchCause, $index = -1, $length = 0)
	{
		$limit = "";

		if ($index > -1) {
			$limit .= " LIMIT {$index}, {$length} ";
		}

		$searchCause .= $limit;
	    $stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt, $row->saleNo, $row->CRE_DTE, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance,$row->fullname,$row->itemLatestCost);

	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt,$row->saleNo, $row->CRE_DTE, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance,$row->fullname,$row->itemLatestCost);
	    }

		mysqli_stmt_free_result($stmt);
		mysqli_close($this->connection);

		return $rows;
	}

	public function getSearch_ItemCosts_Count($searchCause)
	{
		$itemCost_list = $this->getSearch_ItemCosts($searchCause);
		return count($itemCost_list);
	}

	public function getSearch_ItemCosts_Area($searchCause, $index, $length)
	{
		$itemCost_list = $this->getSearch_ItemCosts($searchCause, $index, $length);
		return $itemCost_list;
	}

	public function getSearch_ItemProfit($searchCause, $index = -1, $length = 0)
	{
		$limit = "";

		if ($index > -1) {
			$limit .= " LIMIT {$index}, {$length} ";
		}

		$searchCause .= $limit;

	    $stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt, $row->saleNo, $row->itemID, $row->itemName, $row->saleQTY, $row->salePrice, $row->itemLatestCost, $row->fullname);

	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();

	      mysqli_stmt_bind_result($stmt, $row->saleNo, $row->itemID, $row->itemName, $row->saleQTY, $row->salePrice, $row->itemLatestCost, $row->fullname);
	    }

		mysqli_stmt_free_result($stmt);
		mysqli_close($this->connection);

		return $rows;
	}

	public function getSearch_ItemProfit_Count($searchCause)
	{
		$itemProfit_list = $this->getSearch_ItemProfit($searchCause);
		return count($itemProfit_list);
	}

	public function getSearch_ItemProfit_Area($searchCause, $index, $length)
	{
		$itemProfit_list = $this->getSearch_ItemProfit($searchCause, $index, $length);
		return $itemProfit_list;
	}

	// [TBC] Need to fixed this function make mysqli_stmt_bind_result() can bind result object with Dynamically Variable
	public function getSearch_saledetailByBill($searchCause, $index = -1, $length = 0)
	{
		$limit = "";

		if ($index > -1) {
			$limit .= " LIMIT {$index}, {$length} ";
		}

		$searchCause .= $limit;

	    $stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt, $row->saleNo, $row->CRE_DTE, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance, $row->fullname, $row->saleType, $row->saleDone);

	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->saleNo, $row->CRE_DTE, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance, $row->fullname, $row->saleType, $row->saleDone);
	    }

		mysqli_stmt_free_result($stmt);
		mysqli_close($this->connection);

		return $rows;
	}

	// [TBC] Need to fixed this function make mysqli_stmt_bind_result() can bind result object with Dynamically Variable
	// this Function is for workaround for only get saleNoNewBill and saleNoOldBill for VOID Bill Feature
	// this function will be remove when getSearch_saleDetailByBill() can bind result variable Dynamically
	public function getSearch_saledetailBillStatus($searchCause, $index = -1, $length = 0)
	{
		$limit = "";

		if ($index > -1) {
			$limit .= " LIMIT {$index}, {$length} ";
		}

		$searchCause .= $limit;

	    $stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt
		, $row->saleNo
		, $row->CRE_DTE
		, $row->saleTotalAmount
		, $row->saleTotalDiscount
		, $row->saleTotalBalance
		, $row->fullname
		, $row->saleType
		, $row->saleDone
		, $row->saleNoNewBill
		, $row->saleNoOldBill);

	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt
			, $row->saleNo
			, $row->CRE_DTE
			, $row->saleTotalAmount
			, $row->saleTotalDiscount
			, $row->saleTotalBalance
			, $row->fullname
			, $row->saleType
			, $row->saleDone
			, $row->saleNoNewBill
			, $row->saleNoOldBill
			);
	    }

		mysqli_stmt_free_result($stmt);
		mysqli_close($this->connection);

		return $rows;
	}

	public function getSearch_saledetailByBill_Count($searchCause) {
		$bill_list = $this->getSearch_saledetailByBill($searchCause);
		return count($bill_list);
	}

	public function getSearch_saledetailByBill_Area($searchCause, $index, $length) {
		$bill_list = $this->getSearch_saledetailByBill($searchCause, $index, $length);
		return $bill_list;
	}

}


/** Test Stub **/
/** Test Url:
   http://localhost/smitpos/services/saledetailviewservice.php?XDEBUG_SESSION_START=test

   Ref:
       http://webcheatsheet.com/php/debug_php_with_xdebug.php
**/
/**
echo("<p>Begin Test</p>");

/**
 $obj = new SaledetailviewService;
 $from = new DateTime();  // Today
 $to = new DateTime();  // Today

 $rowZa = array();
$rowZa = $obj->getBalanceMovement($from->date, $to->date);
// $rowZa = $obj->getBalanceMovement('2012-01-01 00:00:00', $to->date);
 echo("<p>pre Ending</p>");

 
$index = 50;
$length = 75;
 
$sql = "SELECT `j`.`actionIndex` as `actionIndex`, `j`.`drawerIndex` as `drawerIndex`, `j`.`actionType` as `actionType`, `j`.`actionAmount` as `actionAmount`, `j`.`drawerBalance` as `drawerBalance`, `j`.`CRE_DTE` as `CRE_DTE`, `j`.`CRE_USR` as `CRE_USR`, `s`.`userIndex` as `userIndex`, `s`.`fullname` as `fullname`, `s`.`myusername` as `myusername` FROM (_till_monitor `j` JOIN _myuser `s`) ";

$where = "WHERE (CONVERT_TZ(`j`.`CRE_DTE`, '+00:00', '+07:00') BETWEEN '2012-01-01 00:00:00' AND '2014-01-01 00:00:00') AND (`j`.`CRE_USR` = `s`.`userID`) AND (`s`.`DEL_USR` IS NULL) ";

if ($index != -1) {
	$where .= " LIMIT {$index}, {$length} ";
}

$sql .= $where;
echo $sql;

echo("<p>End!!</p>");
/*************/

?>
