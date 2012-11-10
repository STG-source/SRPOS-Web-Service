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
class OrderinfoService {

	var $username = "root";
	var $password = "";
	var $server = "localhost";
	var $port = "3306";
	var $databasename = "stechschema";
	var $tablename = "orderinfo";

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
	public function getAllOrderinfo() {

		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->orderIndex, $row->saleNo, $row->tableNo, $row->customerNum, $row->order_DTE, $row->paid_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->order_DTE = new DateTime($row->order_DTE);
	      $row->paid_DTE = new DateTime($row->paid_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->orderIndex, $row->saleNo, $row->tableNo, $row->customerNum, $row->order_DTE, $row->paid_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE);
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
	public function getOrderinfoByID($itemID) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename where orderIndex=?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'i', $itemID);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_result($stmt, $row->orderIndex, $row->saleNo, $row->tableNo, $row->customerNum, $row->order_DTE, $row->paid_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE);
		
		if(mysqli_stmt_fetch($stmt)) {
	      $row->order_DTE = new DateTime($row->order_DTE);
	      $row->paid_DTE = new DateTime($row->paid_DTE);
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
	public function createOrderinfo($item) {

		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (saleNo, tableNo, customerNum, order_DTE, paid_DTE, UPD_USR, UPD_DTE, DEL_USR, DEL_DTE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'ssissssss', $item->saleNo, $item->tableNo, $item->customerNum, $item->order_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->paid_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'));
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
	public function updateOrderinfo($item) {
	
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET saleNo=?, tableNo=?, customerNum=?, order_DTE=?, paid_DTE=?, UPD_USR=?, UPD_DTE=?, DEL_USR=?, DEL_DTE=? WHERE orderIndex=?");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ssissssssi', $item->saleNo, $item->tableNo, $item->customerNum, $item->order_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->paid_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->orderIndex);		
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
	public function deleteOrderinfo($itemID) {
				
		$stmt = mysqli_prepare($this->connection, "DELETE FROM $this->tablename WHERE orderIndex = ?");
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
	public function getOrderinfo_paged($startIndex, $numItems) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename LIMIT ?, ?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ii', $startIndex, $numItems);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->orderIndex, $row->saleNo, $row->tableNo, $row->customerNum, $row->order_DTE, $row->paid_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->order_DTE = new DateTime($row->order_DTE);
	      $row->paid_DTE = new DateTime($row->paid_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->orderIndex, $row->saleNo, $row->tableNo, $row->customerNum, $row->order_DTE, $row->paid_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE);
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
	
	
	/**********************************
	*
	* Modify Up Area
	*
	***********************************/
	public function createOrderinfo_own($item) {

		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (saleNo, tableNo, customerNum, order_DTE, paid_DTE, UPD_USR, UPD_DTE, DEL_USR, DEL_DTE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		if ($item->paid_DTE == null) {
			mysqli_stmt_bind_param($stmt, 'ssissssss', $item->saleNo, $item->tableNo, $item->customerNum, $item->order_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->paid_DTE, $item->UPD_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'));
		}
		else {
			mysqli_stmt_bind_param($stmt, 'ssissssss', $item->saleNo, $item->tableNo, $item->customerNum, $item->order_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->paid_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'));
		}
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		$autoid = mysqli_stmt_insert_id($stmt);

		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);

		return $autoid;
	}
	
	
	public function getAllOrderinfo_own($holdFlag) {

		if ($holdFlag == 1) {
			$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename WHERE paid_DTE IS null");
		}
		else {
			$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename");
		}
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->orderIndex, $row->saleNo, $row->tableNo, $row->customerNum, $row->order_DTE, $row->paid_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->order_DTE = new DateTime($row->order_DTE);
		  if ($row->paid_DTE != null)
				$row->paid_DTE = new DateTime($row->paid_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->orderIndex, $row->saleNo, $row->tableNo, $row->customerNum, $row->order_DTE, $row->paid_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE);
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
	}


	public function getOrderinfo_BySaleNo($target, $boxNo) {
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename WHERE saleNo = '{$target}' AND tableNo = '{$boxNo}' ");
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt, $row->orderIndex, $row->saleNo, $row->tableNo, $row->customerNum, $row->order_DTE, $row->paid_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE);

	    while (mysqli_stmt_fetch($stmt)) {
	      $row->order_DTE = new DateTime($row->order_DTE);
		  if ($row->paid_DTE != null)
				$row->paid_DTE = new DateTime($row->paid_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->orderIndex, $row->saleNo, $row->tableNo, $row->customerNum, $row->order_DTE, $row->paid_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE);
	    }

		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);

	    return $rows;
	}


	public function updateOrderinfo_own($item) {
	
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET saleNo=?, tableNo=?, customerNum=?, order_DTE=?, paid_DTE=?, UPD_USR=?, UPD_DTE=?, DEL_USR=?, DEL_DTE=? WHERE orderIndex=?");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ssissssssi', $item->saleNo, $item->tableNo, $item->customerNum, $item->order_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->paid_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->orderIndex);		
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);
	}

}

?>
