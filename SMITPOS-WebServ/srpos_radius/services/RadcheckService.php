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
class RadcheckService {

	var $username = "root";
	var $password = "";
	var $server = "localhost";
	var $port = "3306";
	var $databasename = "radius";
	var $tablename = "radcheck";

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


	private function ReConnect(){
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
	public function getAllRadcheck() {

		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->id, $row->username, $row->attribute, $row->op, $row->value);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->id, $row->username, $row->attribute, $row->op, $row->value);
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
	public function getRadcheckByID($itemID) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename where id=?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'i', $itemID);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_result($stmt, $row->id, $row->username, $row->attribute, $row->op, $row->value);
		
		if(mysqli_stmt_fetch($stmt)) {
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
	public function getRadcheckBySaleNo($saleNo) {
		$this->ReConnect();
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename WHERE username=?");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 's', $saleNo);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->id, $row->username, $row->attribute, $row->op, $row->value);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->id, $row->username, $row->attribute, $row->op, $row->value);
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
		
	}
	
	
	/*
	* Return Code Number of Result
	* 1 :: Create New Record
	* 2 :: Update Old Record
	* 3 :: Update Last Record of SaleNo
	* Add at 05/09/2015
	*/
	public function createOrUpdate($item){
		//check transection SaleNo ,count row of SaleNo
		$Result = 0;
		$c_num = $this->count_SaleNo($item->userName);
		$c_set = $c_num / 3;
		if($c_set == 0){
			// Create Record 1 :: User-Password
			$this->ReConnect();
			$record_1 = new stdClass();
			$record_1->id = 0;	
			$record_1->username = $item->userName;
			$record_1->attribute = "User-Password";
			$record_1->op = ":=";
			$record_1->value = $item->userPassWord;
			$this->createRadcheck($record_1);
			// Create Record 2 :: Max-All-Session
			$this->ReConnect();
			$record_2 = new stdClass();
			$record_2->id = 0;	
			$record_2->username = $item->userName;
			$record_2->attribute = "Max-All-Session";
			$record_2->op = ":=";
			$record_2->value = $item->session;
			$this->createRadcheck($record_2);
			// Create Record 3 :: Expiration
			$this->ReConnect();
			$record_3 = new stdClass();
			$record_3->id = 0;	
			$record_3->username = $item->userName;
			$record_3->attribute = "Expiration";
			$record_3->op = ":=";
			$record_3->value = $item->expireDate;
			$this->createRadcheck($record_3);

			$Result = 1;
			
		}else{

			if($c_set == 1){
				$Result = 2;
			}else{
				$Result = 3;
			}

			$max_ID = $this->get_Max_listIndex($item->userName);

			// Create Record 1 :: User-Password
			$this->ReConnect();
			$record_1 = new stdClass();
			$record_1->id = $max_ID - 2;	
			$record_1->username = $item->userName;
			$record_1->attribute = "User-Password";
			$record_1->op = ":=";
			$record_1->value = $item->userPassWord;
			$this->updateRadcheck($record_1);
			// Create Record 2 :: Max-All-Session
			$this->ReConnect();
			$record_2 = new stdClass();
			$record_2->id = $max_ID - 1;	
			$record_2->username = $item->userName;
			$record_2->attribute = "Max-All-Session";
			$record_2->op = ":=";
			$record_2->value = $item->session;
			$this->updateRadcheck($record_2);
			// Create Record 3 :: Expiration
			$this->ReConnect();
			$record_3 = new stdClass();
			$record_3->id = $max_ID;
			$record_3->username = $item->userName;
			$record_3->attribute = "Expiration";
			$record_3->op = ":=";
			$record_3->value = $item->expireDate;
			$this->updateRadcheck($record_3);

		}

		return $Result;

		
	}
	
	/**
	 * Returns the number of SaleNo in the table.
	 *
	 *
	 * Add at 05/09/2015
	 */
	public function count_SaleNo($SaleNo) {
		$this->ReConnect();
		$stmt = mysqli_prepare($this->connection, "SELECT COUNT(*) AS COUNT FROM $this->tablename WHERE username = ? ");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 's', $SaleNo);
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
	 * Returns Max listIndex number of SaleNo in the table.
	 *
	 * 
	 * Add at 05/09/2015
	 */
	public function get_Max_listIndex($SaleNo) {
		$this->ReConnect();
		$stmt = mysqli_prepare($this->connection, "SELECT IFNULL(MAX(id),0) AS MAX_Index FROM radcheck WHERE username = ? ");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 's', $SaleNo);		
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
	 * Returns the item corresponding to the value specified for the primary key.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function createRadcheck($item) {

		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (username, attribute, op, value) VALUES (?, ?, ?, ?)");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'ssss', $item->username, $item->attribute, $item->op, $item->value);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		$autoid = mysqli_stmt_insert_id($stmt);

		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);

		return $autoid;
	}
	
	public function createRadcheck_own($item) {
		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (username, attribute, op, value) VALUES (?, ?, ?, ?)");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'ssss', $item->username, $item->attribute, $item->op, $item->value);
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
	public function updateRadcheck($item) {
		$this->ReConnect();
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET username=?, attribute=?, op=?, value=? WHERE id=?");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ssssi', $item->username, $item->attribute, $item->op, $item->value, $item->id);		
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
	public function deleteRadcheck($itemID) {
				
		$stmt = mysqli_prepare($this->connection, "DELETE FROM $this->tablename WHERE id = ?");
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
	public function getRadcheck_paged($startIndex, $numItems) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename LIMIT ?, ?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ii', $startIndex, $numItems);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->id, $row->username, $row->attribute, $row->op, $row->value);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->id, $row->username, $row->attribute, $row->op, $row->value);
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
