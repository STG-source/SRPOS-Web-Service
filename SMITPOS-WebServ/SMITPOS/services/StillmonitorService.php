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
class StillmonitorService {

	var $username = "root";
	var $password = "";
	var $server = "localhost";
	var $port = "3306";
	var $databasename = "stechschema";
	var $tablename = "_till_monitor";

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
	public function getAll_till_monitor() {

		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->actionIndex, $row->drawerIndex, $row->actionType, $row->actionAmount, $row->drawerBalance, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->actionIndex, $row->drawerIndex, $row->actionType, $row->actionAmount, $row->drawerBalance, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
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
	public function get_till_monitorByID($itemID) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename where actionIndex=?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'i', $itemID);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_result($stmt, $row->actionIndex, $row->drawerIndex, $row->actionType, $row->actionAmount, $row->drawerBalance, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
		
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
	public function create_till_monitor($item) {

		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (actionIndex, drawerIndex, actionType, actionAmount, drawerBalance, CRE_DTE, CRE_USR, UPD_DTE, UPD_USR, DEL_DTE, DEL_USR) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'iisddssssss', $item->actionIndex, $item->drawerIndex, $item->actionType, $item->actionAmount, $item->drawerBalance, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		$autoid = $item->actionIndex;

		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);

		return $autoid;
	}


	public function create_till_monitor_own($item) {

		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (actionIndex, drawerIndex, actionType, actionAmount, drawerBalance, CRE_DTE, CRE_USR, UPD_DTE, UPD_USR, DEL_DTE, DEL_USR) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		/*
		
		//For testing data & php code
		{
		actionIndex:0,
		drawerIndex:1,
		actionType:"jj",
		actionAmount:20,
		drawerBalance:500,
		CRE_DTE:"",
		CRE_USR:"dporn",
		DEL_DTE:"",
		DEL_USR:"dporn",
		UPD_DTE:"",
		UPD_USR:""
		}	
		mysqli_stmt_bind_param($stmt, 'iisddssssss', $item->actionIndex, $item->drawerIndex, $item->actionType, $item->actionAmount, $item->drawerBalance, $item->CRE_DTE, $item->CRE_USR, $item->UPD_DTE, $item->UPD_USR, $item->DEL_DTE, $item->DEL_USR);		
		*/
		
		mysqli_stmt_bind_param($stmt, 'iisddssssss', $item->actionIndex, $item->drawerIndex, $item->actionType, $item->actionAmount, $item->drawerBalance, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		$autoid = $item->actionIndex;

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
	public function update_till_monitor($item) {
	
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET drawerIndex=?, actionType=?, actionAmount=?, drawerBalance=?, CRE_DTE=?, CRE_USR=?, UPD_DTE=?, UPD_USR=?, DEL_DTE=?, DEL_USR=? WHERE actionIndex=?");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'isddssssssi', $item->drawerIndex, $item->actionType, $item->actionAmount, $item->drawerBalance, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->actionIndex);		
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
	public function delete_till_monitor($itemID) {
				
		$stmt = mysqli_prepare($this->connection, "DELETE FROM $this->tablename WHERE actionIndex = ?");
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
	public function get_till_monitor_paged($startIndex, $numItems) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename LIMIT ?, ?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ii', $startIndex, $numItems);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->actionIndex, $row->drawerIndex, $row->actionType, $row->actionAmount, $row->drawerBalance, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->actionIndex, $row->drawerIndex, $row->actionType, $row->actionAmount, $row->drawerBalance, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
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
	*  
	*/
	public function getCurrentBalance($searchCause) {
		$stmt = mysqli_prepare($this->connection, $searchCause);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->drawerBalance);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->drawerBalance);
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
	}

	public function getCutBalance($searchCause) {
		$stmt = mysqli_prepare($this->connection, $searchCause);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->Today,$row->cutCount,$row->cutBalance);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->Today,$row->cutCount,$row->cutBalance);
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
	}

	public function getSellBalance($searchCause) {
		$stmt = mysqli_prepare($this->connection, $searchCause);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->Today, $row->TotalSell,$row->FirstBill,$row->LastBill);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->Today, $row->TotalSell,$row->FirstBill,$row->LastBill);
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
	}

	/// searchCause is "where cause" in SQL
	///
	/// saleTypeCollection is Array of SaleType Object  => {saleType , saleDone}
	///
	/// saleType 0 => TakeHome , 1 => Delivery , 2 => Dine-In , 10 => Normal , 20 => Credit, 30 => Online
	///
	/// saleDone -1 => Void Bill , 0 => Credit , 1 => Done (Money) ,
	/// 2 => Done (Credit Card) , 3 => Done (Cheque) , 4 => Done (Net Bank)
	/// 41 => (Advance Credit) , 42 => (Wait Credit)
	///
	public function getSellBalanceSaleTypeCollection($searchCause , array $saleTypeCollection)
	{
		/* TBC */
		// Query all Data
		$stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt
		,$row->BillNo
		,$row->SaleType
		,$row->SaleDone
		,$row->ActionAmount
		,$row->DrawerBalance
		,$row->CreateDate
		,$row->CreateUser
		,$row->UpdateDate
		,$row->UpdateUser
		);

	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt
			,$row->BillNo
			,$row->SaleType
			,$row->SaleDone
			,$row->ActionAmount
			,$row->DrawerBalance
			,$row->CreateDate
			,$row->CreateUser
			,$row->UpdateDate
			,$row->UpdateUser
		  );
	    }

		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);

		unset($row);

		// Create Group of Data into associative Array with index SaleType and SaleDone as Index

		//$result => obj.SaleType , obj.saleDone , obj.actionType
		if(isset($rows) && is_array($rows) && (count($rows) > 0))
		{
			$result = array();
			$rows_length = count($rows);
			$hasSaleType = false;
			$temp_index = null;
			for ($i=0; $i < $rows_length; $i++) {
				$hasSaleType = false;
				for ($j=0; $j < count($result); $j++) {
					if($result[$j]->SaleType == $rows[$i]->SaleType)
					{
						$hasSaleType = true;
						$result[$j]->hasSaleType = true;
						$temp_index = $j;
					}
				}

				if(!$hasSaleType)
				{
					$row = new stdClass();
					$row->SaleType = $rows[$i]->SaleType;
					$row->SaleDone = $rows[$i]->SaleDone;
					$row->ActionData = array();
					array_push($row->ActionData,$rows[$i]);
					array_push($result,$row);
				} // End Init Data
				else
				{
					array_push($result[$temp_index]->ActionData,$rows[$i]);
				}

			}
		}



	    return $result;
	}

	public function getUplimit($searchCause) {
		$stmt = mysqli_prepare($this->connection, $searchCause);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->Today, $row->TotalUplimit,$row->uplimitBill);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->Today, $row->TotalUplimit,$row->uplimitBill);
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
	}

	public function getSendBalance($searchCause) {
		$stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt, $row->Today, $row->sendBalance,$row->SendCount);

	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->Today, $row->sendBalance,$row->SendCount);
	    }

		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);

	    return $rows;
	}

	public function getKeepBalance($searchCause) {
		$stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt, $row->actionIndex, $row->actionType,$row->actionAmount,$row->CRE_DTE,$row->CRE_USR,$row->drawerBalance);

	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt,  $row->actionIndex, $row->actionType,$row->actionAmount,$row->CRE_DTE,$row->CRE_USR,$row->drawerBalance);
	    }

		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);

	    return $rows;
	}
}
?>
