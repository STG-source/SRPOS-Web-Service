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
class ScustomerService {

	var $username = "root";
	var $password = "";
	var $server = "localhost";
	var $port = 3306;
	var $databasename = "stechschema";
	var $tablename = "_customer";

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
	public function getAll_customer() {

		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		//mysqli_stmt_bind_result($stmt, $row->customerIndex, $row->customerID, $row->fullname, $row->address, $row->province, $row->postcode, $row->phone, $row->email, $row->customerClass, $row->customerType, $row->customerAVP, $row->customerPoint, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
		
		mysqli_stmt_bind_result($stmt, $row->customerIndex, $row->customerID, $row->fullname, $row->address, $row->city, $row->province, $row->postcode, $row->phone, $row->email, $row->customerClass, $row->customerType, $row->customerAVP, $row->customerPoint,$row->citizenID,$row->passportID,$row->title,$row->cellPhone,$row->fax, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
		
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
		  
		  
	     // mysqli_stmt_bind_result($stmt, $row->customerIndex, $row->customerID, $row->fullname, $row->address, $row->province, $row->postcode, $row->phone, $row->email, $row->customerClass, $row->customerType, $row->customerAVP, $row->customerPoint, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
		  
		  mysqli_stmt_bind_result($stmt, $row->customerIndex, $row->customerID, $row->fullname, $row->address, $row->city, $row->province, $row->postcode, $row->phone, $row->email, $row->customerClass, $row->customerType, $row->customerAVP, $row->customerPoint,$row->citizenID,$row->passportID,$row->title,$row->cellPhone,$row->fax, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
		
		  
		  
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
	}
	
	/**
	* Operate
	* Flag = 1 get allSaleTransection
	* Flag = 0 get SaleTransection where saleDone = 0
	* Return
	* Customer Field
	* Sale Summary (Depend on flag value)
	* List of Customer's sale Detail data
	**/
	public function get_customerSale($search_Key,$process_Flag){
		require_once 'SaledetailService.php';
		// define Valiable
		$basicCustomerInfo = null;
		$saleSummary = null;
		$listofSaleDetail = null;

		// get Customer Data
		$searchCause = "SELECT * FROM $this->tablename WHERE 1 AND CONCAT_WS(' ', fullname, email, customerID, phone, citizenID, passportID) like '%".$search_Key."%'";	

		$stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();		
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_result($stmt, $row->customerIndex, $row->customerID,
		$row->fullname, 
		$row->address, $row->city, $row->province, $row->postcode, 
		$row->phone, $row->email, 
		$row->customerClass, $row->customerType, $row->customerAVP, $row->customerPoint, 
		$row->citizenID, $row->passportID, $row->title,
		$row->cellPhone, $row->fax,
		$row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
		
		if(mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $basicCustomerInfo = $row;
		} else {
	      $basicCustomerInfo = null;
		}
		
		// Get SaleDetail for Customer By CustomerIndex
		if($basicCustomerInfo != null){
			$SaleDetailService = new SaledetailService();
			$data_SaleDetail = $SaleDetailService->get_Summary_And_List_SaleDetail_By_CustomerIndex($basicCustomerInfo->customerIndex,$process_Flag);
		}
		
		$rows_data = new stdClass();
		$rows_data->basicCustomerInfo = $basicCustomerInfo;
		$rows_data->saleSummary = $data_SaleDetail->saleSummary;
		$rows_data->listofSaleDetail = $data_SaleDetail->listSaleDetail;
		
		return $rows_data;		
	}
	
	
	/**
	* Return
	* CustomerField + Sale Summary
	**/
	public function getAll_customerSale($index, $length) {
		
		$limit = "";

		if ($index > -1) {
			$limit .= " LIMIT {$index}, {$length} ";
		}
		
		$strSQL = "SELECT * FROM ( 
					SELECT  
					c.customerIndex, 
					c.customerID, 
					c.fullname, 
					c.phone, 
					c.email, 
					sum(saleTotalAmount) as saleTotalAmount, 
					sum(saleTotalDiscount) as saleTotalDiscount, 
					sum(saleTotalBalance) as saleTotalBalance 					
					FROM _customer c 
					INNER JOIN saledetail s on s.customerIndex = c.customerIndex 
					group by c.customerIndex,c.customerID,c.fullname, 
					c.phone, 
					c.email 
					) data ".$limit;
		
		$stmt = mysqli_prepare($this->connection, $strSQL);
		$this->throwExceptionOnError();		
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
			
		
		mysqli_stmt_bind_result($stmt, $row->customerIndex, 
										$row->customerID,
										$row->fullname, 										
										$row->phone, 
										$row->email, 
										$row->saleTotalAmount, 
										$row->saleTotalDiscount, 
										$row->saleTotalBalance);
		
		
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	  
		 mysqli_stmt_bind_result($stmt, $row->customerIndex, 
										$row->customerID,
										$row->fullname, 										
										$row->phone, 
										$row->email, 
										$row->saleTotalAmount, 
										$row->saleTotalDiscount, 
										$row->saleTotalBalance);
		
	    }
		
		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);
		
		return $rows;
	}
	
	/**
	* Return 
	* result of 
	* ScustomerService::get_customerSale(string,flag)
	* SaledetailService::getSaledetailSalelist_bySaleNo(saleNo)
	**/
	public function getAll_customerSale_1stSaleList($search_Key){
		require_once 'SaledetailService.php';
		$data_customerSale = $this->get_customerSale($search_Key,1);
		
		$SaleDetailService = new SaledetailService();		
		$SaledetailSalelist = $SaleDetailService->getSaledetailSalelist_bySaleNo($data_customerSale->listofSaleDetail[0]->saleNo);
		
		$rows_data = new stdClass();
		$rows_data->basicCustomerInfo = $data_customerSale->basicCustomerInfo;
		$rows_data->saleSummary = $data_customerSale->saleSummary;
		$rows_data->listofSaleDetail = $data_customerSale->listofSaleDetail;
		$rows_data->SaledetailSalelist = $SaledetailSalelist;
		
		return $rows_data;	
	}

	/**
	 * Returns _customer matched the search criteria (KP)
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function getSearch_customer($searchCause) {
	    $stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt, $row->customerIndex, $row->customerID,
		$row->fullname, 
		$row->address, $row->city, $row->province, $row->postcode, 
		$row->phone, $row->email, 
		$row->customerClass, $row->customerType, $row->customerAVP, $row->customerPoint, 
		$row->citizenID, $row->passportID, $row->title,
		$row->cellPhone, $row->fax,
		$row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);

	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
		  mysqli_stmt_bind_result($stmt, $row->customerIndex, $row->customerID,
		  $row->fullname, 
		  $row->address, $row->city, $row->province, $row->postcode, 
		  $row->phone, $row->email, 
		  $row->customerClass, $row->customerType, $row->customerAVP, $row->customerPoint, 
		  $row->citizenID, $row->passportID, $row->title, 
		  $row->cellPhone, $row->fax, 
		  $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
	    }

		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);

		return $rows;
	}

	/**
	 * Returns distinct customerClass from all elements (KP)
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function getDistinct_customerClass() {
		$stmt = mysqli_prepare($this->connection, "SELECT DISTINCT (customerClass) FROM $this->tablename");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->customerClass);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->customerClass);
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
	}

	/**
	 * Returns distinct customerType from all elements (KP)
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function getDistinct_customerType() {
		$stmt = mysqli_prepare($this->connection, "SELECT DISTINCT (customerType) FROM $this->tablename");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->customerType);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->customerType);
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
	public function get_customerByID($itemID) {

		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename where customerIndex=?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'i', $itemID);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_result($stmt, $row->customerIndex, $row->customerID,
		$row->fullname, 
		$row->address, $row->city, $row->province, $row->postcode, 
		$row->phone, $row->email, 
		$row->customerClass, $row->customerType, $row->customerAVP, $row->customerPoint, 
		$row->citizenID, $row->passportID, $row->title,
		$row->cellPhone, $row->fax,
		$row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
		
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
	public function create_customer($item) {

		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (customerID, fullname, address, province, postcode, phone, email, customerClass, customerType, customerAVP, customerPoint, CRE_DTE, CRE_USR, UPD_DTE, UPD_USR, DEL_DTE, DEL_USR) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'sssssssssddssssss', $item->customerID, $item->fullname, $item->address, $item->province, $item->postcode, $item->phone, $item->email, $item->customerClass, $item->customerType, $item->customerAVP, $item->customerPoint, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		$autoid = mysqli_stmt_insert_id($stmt);

		mysqli_stmt_free_result($stmt);		
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
	 */
	public function myCreate_customer($SQLInsert) {

		$stmt = mysqli_prepare($this->connection, $SQLInsert);
		$this->throwExceptionOnError();

		//mysqli_stmt_bind_param($stmt, 'sssssssssddssssss', $item->customerID, $item->fullname, $item->address, $item->province, $item->postcode, $item->phone, $item->email, $item->customerClass, $item->customerType, $item->customerAVP, $item->customerPoint, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR);
		//$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);

	}
	
	
	/**
	* Operation
	* Insert New customer Object
	* Generate CustomerID
	* Return New Customer ID 
	**/	
	public function create_newCustomer($item){
		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (customerID, fullname, address, city, province, postcode, phone, email, customerClass, customerType, customerAVP, customerPoint, citizenID, passportID, title, cellPhone, fax, CRE_DTE, CRE_USR) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'ssssssssssddsssssss', $item->customerID, $item->fullname, $item->address, $item->city, $item->province, $item->postcode, $item->phone, $item->email, $item->customerClass, $item->customerType, $item->customerAVP, $item->customerPoint, $item->citizenID ,$item->passportID,$item->title,$row->cellPhone,$item->fax, $item->CRE_DTE->format('Y-m-d H:i:s'), $item->CRE_USR);
		
		
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
	public function update_customer($item) {
	
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET customerID=?, fullname=?, address=?, province=?, postcode=?, phone=?, email=?, customerClass=?, customerType=?, customerAVP=?, customerPoint=?, CRE_DTE=?, CRE_USR=?, UPD_DTE=?, UPD_USR=?, DEL_DTE=?, DEL_USR=? WHERE customerIndex=?");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'sssssssssddssssssi', $item->customerID, $item->fullname, $item->address, $item->province, $item->postcode, $item->phone, $item->email, $item->customerClass, $item->customerType, $item->customerAVP, $item->customerPoint, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->customerIndex);
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
	public function myUpdate_customer($item) {
	
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET customerID=?, fullname=?, address=?, province=?, postcode=?, phone=?, email=?, customerClass=?, customerType=?, customerAVP=?, customerPoint=?, CRE_DTE=?, CRE_USR=?, UPD_DTE=?, UPD_USR=?, DEL_DTE=?, DEL_USR=? WHERE customerIndex=?");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'sssssssssddssssssi', $item->customerID, $item->fullname, $item->address, $item->province, $item->postcode, $item->phone, $item->email, $item->customerClass, $item->customerType, $item->customerAVP, $item->customerPoint, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->customerIndex);		
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
	public function delete_customer($itemID) {
				
		$stmt = mysqli_prepare($this->connection, "DELETE FROM $this->tablename WHERE customerIndex = ?");
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
	public function get_customer_paged($startIndex, $numItems) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename LIMIT ?, ?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ii', $startIndex, $numItems);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->customerIndex, $row->customerID, $row->fullname, $row->address, $row->province, $row->postcode, $row->phone, $row->email, $row->customerClass, $row->customerType, $row->customerAVP, $row->customerPoint, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->customerIndex, $row->customerID, $row->fullname, $row->address, $row->province, $row->postcode, $row->phone, $row->email, $row->customerClass, $row->customerType, $row->customerAVP, $row->customerPoint, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);
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


	public function setCustomerPoint($customerIndex, $pointScore) {
		$customerRow = $this->get_customerByID($customerIndex);
		$customerRow->customerPoint += $pointScore;

		// Manually update customer point score
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET customerPoint = ? WHERE customerIndex = ?");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'ii', $customerRow->customerPoint, $customerIndex);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		mysqli_stmt_free_result($stmt);
		mysqli_stmt_close($stmt);

		return $customerRow;
	}

}

?>
