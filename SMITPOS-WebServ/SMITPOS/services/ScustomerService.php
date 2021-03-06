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
	var $table_saledetail_view = "saledetailview";

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
		$customerDetail = null;

		// get Customer Data
		$searchCause = "SELECT * FROM $this->tablename WHERE 1 AND CONCAT_WS(' ', fullname, email, customerID, phone, citizenID, passportID) like '%".$search_Key."%'";	

		$stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();		

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		/* store result */
    	mysqli_stmt_store_result($stmt);

		$num_rows = mysqli_stmt_num_rows($stmt);

		if($num_rows == 0){
			$customerDetail = null;
		}elseif($num_rows == 1){
			mysqli_stmt_bind_result($stmt, $row->customerIndex, $row->customerID,
			$row->fullname,
			$row->address, $row->city, $row->province, $row->postcode,
			$row->phone, $row->email,
			$row->customerClass, $row->customerType, $row->customerAVP, $row->customerPoint,
			$row->citizenID, $row->passportID, $row->title,
			$row->cellPhone, $row->fax,
			$row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);

			if(mysqli_stmt_fetch($stmt)){
				$rows[] = $row; // Set Array
				$customerDetail = $rows;
			}
		}else{
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

			$customerDetail = $rows;
		}

		$rows_data = new stdClass();
		$rows_data->customerDetail = $customerDetail;
		$rows_data->saleSummary = null;
		$rows_data->itemlistSaleDetail = null;

		// Get SaleDetail for Customer By CustomerIndex
		if($customerDetail != null && $num_rows == 1){
			$SaleDetailService = new SaledetailService();
			$data_SaleDetail = $SaleDetailService->get_Summary_And_List_SaleDetail_By_CustomerIndex($customerDetail[0]->customerIndex,$process_Flag);
			$rows_data->saleSummary = $data_SaleDetail->saleSummary;
			$rows_data->itemlistSaleDetail = $data_SaleDetail->listSaleDetail;
		}

		return $rows_data;
	}

	/**
	* Got idea from get_customerSale() with change $search_Key to $itemID (customerIndex)
	*
	* Operate
	* Flag = 1 get allSaleTransection
	* Flag = 0 get SaleTransection where saleDone = 0
	* Return
	* Customer Field
	* Sale Summary (Depend on flag value)
	* List of Customer's sale Detail data
	**/
	public function get_customerSaleByID($itemID,$process_Flag){
		require_once 'SaledetailService.php';
		// define Valiable
		$customerDetail = null;

		// get Customer Data
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename where customerIndex=?");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'i', $itemID);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		/* store result */
		mysqli_stmt_store_result($stmt);

		$num_rows = mysqli_stmt_num_rows($stmt);

		if($num_rows == 0){
			$customerDetail = null;
		}elseif($num_rows == 1){
			mysqli_stmt_bind_result($stmt, $row->customerIndex, $row->customerID,
			$row->fullname,
			$row->address, $row->city, $row->province, $row->postcode,
			$row->phone, $row->email,
			$row->customerClass, $row->customerType, $row->customerAVP, $row->customerPoint,
			$row->citizenID, $row->passportID, $row->title,
			$row->cellPhone, $row->fax,
			$row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR);

			if(mysqli_stmt_fetch($stmt)){
				$rows[] = $row; // Set Array
				$customerDetail = $rows;
			}
		}else{
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

			$customerDetail = $rows;
		}

		$rows_data = new stdClass();
		$rows_data->customerDetail = $customerDetail;
		$rows_data->saleSummary = null;
		$rows_data->itemlistSaleDetail = null;

		// Get SaleDetail for Customer By CustomerIndex
		if($customerDetail != null && $num_rows == 1){
			$SaleDetailService = new SaledetailService();
			$data_SaleDetail = $SaleDetailService->get_Summary_And_List_SaleDetail_By_CustomerIndex($customerDetail[0]->customerIndex,$process_Flag);
			$rows_data->saleSummary = $data_SaleDetail->saleSummary;		
			$rows_data->itemlistSaleDetail = $data_SaleDetail->listSaleDetail;
		}

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

		$strSQL = "SELECT 
					cus.customerIndex, 
					cus.customerID, 
					cus.fullname, 
					cus.address, 
					cus.city, 
					cus.province, 
					cus.postcode, 
					cus.phone, 
					cus.email, 
					cus.customerClass, 
					cus.customerType, 
					cus.customerAVP, 
					cus.customerPoint, 
					cus.citizenID, 
					cus.passportID, 
					cus.title, 
					cus.cellPhone, 
					cus.fax, 
					cus.CRE_USR,
					cus.CRE_DTE, 
					cus.UPD_USR, 
					cus.UPD_DTE,
					cus.DEL_USR,
					cus.DEL_DTE,
					ifnull(a.saleTotalBalance,0) as grandTotalBalance,
					ifnull(b.saleTotalBalance,0) as paidTotal,
					ifnull(c.saleTotalBalance,0) as remainTotal
					 FROM _customer cus
					 LEFT OUTER JOIN
					 (					
						SELECT 
						sum(saleTotalBalance) as saleTotalBalance,
						customerIndex 
						FROM saledetail  
						WHERE saleDone <> -1
						GROUP BY customerIndex
					)  a  ON cus.customerIndex  = a.customerIndex 
					LEFT OUTER JOIN
					(
						SELECT 
						sum(saleTotalBalance) as saleTotalBalance,
						customerIndex 
						FROM saledetail  
						WHERE saleDone <> -1 AND saleDone <> 0 
						GROUP BY customerIndex
					)  b  ON b.customerIndex  = a.customerIndex 
					LEFT OUTER JOIN
					(					
						SELECT 
						sum(saleTotalBalance) as saleTotalBalance,
						customerIndex 
						FROM saledetail  
						WHERE saleDone = 0 
						GROUP BY customerIndex
					)  c  ON  c.customerIndex  = a.customerIndex
					WHERE DEL_USR IS NULL
					".$limit;

		$stmt = mysqli_prepare($this->connection, $strSQL);
		$this->throwExceptionOnError();		

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt, $row->customerIndex, 
										$row->customerID, 
										$row->fullname, 
										$row->address, 
										$row->city, 
										$row->province, 
										$row->postcode, 
										$row->phone, 
										$row->email, 
										$row->customerClass, 
										$row->customerType, 
										$row->customerAVP, 
										$row->customerPoint, 
										$row->citizenID, 
										$row->passportID, 
										$row->title, 
										$row->cellPhone, 
										$row->fax,	
										$row->CRE_USR, 
										$row->CRE_DTE,										
										$row->UPD_USR, 
										$row->UPD_DTE,										
										$row->DEL_USR, 
										$row->DEL_DTE,
										$row->grandTotalBalance, 
										$row->paidTotal, 
										$row->remainTotal);

	    while (mysqli_stmt_fetch($stmt)) {
		  $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();

		mysqli_stmt_bind_result($stmt, $row->customerIndex, 
										$row->customerID, 
										$row->fullname, 
										$row->address, 
										$row->city, 
										$row->province, 
										$row->postcode, 
										$row->phone, 
										$row->email, 
										$row->customerClass, 
										$row->customerType, 
										$row->customerAVP, 
										$row->customerPoint, 
										$row->citizenID, 
										$row->passportID, 
										$row->title, 
										$row->cellPhone, 
										$row->fax,	
										$row->CRE_USR, 
										$row->CRE_DTE,										
										$row->UPD_USR, 
										$row->UPD_DTE,										
										$row->DEL_USR, 
										$row->DEL_DTE,
										$row->grandTotalBalance, 
										$row->paidTotal, 
										$row->remainTotal);
		
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

		$rows_data = new stdClass();
		$rows_data->customerDetail = $data_customerSale->customerDetail;
		$rows_data->saleSummary = $data_customerSale->saleSummary;
		$rows_data->itemlistSaleDetail = $data_customerSale->itemlistSaleDetail;
		$rows_data->SaledetailSalelist = null;

		if ($data_customerSale->itemlistSaleDetail != null){		
			$SaleDetailService = new SaledetailService();		
			$SaledetailSalelist = $SaleDetailService->getSaledetailSalelist_bySaleNo($data_customerSale->itemlistSaleDetail[0]->saleNo);
			$rows_data->SaledetailSalelist = $SaledetailSalelist;
		}

		return $rows_data;
	}

	/**
	* Got idea from getAll_customerSale_1stSaleList
	*
	* Return
	* result of
	* ScustomerService::get_customerSaleByID($itemID,flag)
	* SaledetailService::getSaledetailSalelist_bySaleNo(saleNo)
	**/
	public function getAll_customerSale_1stSaleListByID($itemID){
		require_once 'SaledetailService.php';
		$data_customerSale = $this->get_customerSaleByID($itemID,1);

		$rows_data = new stdClass();
		$rows_data->customerDetail = $data_customerSale->customerDetail;
		$rows_data->saleSummary = $data_customerSale->saleSummary;
		$rows_data->itemlistSaleDetail = $data_customerSale->itemlistSaleDetail;
		$rows_data->SaledetailSalelist = null;

		if ($data_customerSale->itemlistSaleDetail != null){
			$SaleDetailService = new SaledetailService();
			$SaledetailSalelist = $SaleDetailService->getSaledetailSalelist_bySaleNo($data_customerSale->itemlistSaleDetail[0]->saleNo);
			$rows_data->SaledetailSalelist = $SaledetailSalelist;
		}

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
	public function get_customerByCustomerID($CustomerID) {

		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename where customerID=?");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 's', $CustomerID);		
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
	 * Returns the item corresponding to the value specified for the customer name
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 *
	 * @return stdClass
	 */
	public function get_customerNameBySaleNo($SaleNo) {
		$stmt = mysqli_prepare($this->connection, "SELECT customerID , fullname FROM $this->table_saledetail_view where saleNo=?");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 's', $SaleNo);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		mysqli_stmt_bind_result($stmt,$row->customerID,$row->fullname);

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

		// Generate CustomerID
		$strSQL = "SELECT max(customerIndex) + 1 as max_index FROM _customer";

		$stmt = mysqli_prepare($this->connection, $strSQL);
		$this->throwExceptionOnError();	

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		mysqli_stmt_bind_result($stmt, $row->max_index);

		$strCustomerID = "";
		if(mysqli_stmt_fetch($stmt)) {
			if (strlen ($row->max_index) == 1){
				$strCustomerID = "CU0000000".$row->max_index;
			}elseif(strlen ($row->max_index) == 2){
				$strCustomerID = "CU000000".$row->max_index;
			}elseif(strlen ($row->max_index) == 3){
				$strCustomerID = "CU00000".$row->max_index;
			}elseif(strlen ($row->max_index) == 4){
				$strCustomerID = "CU0000".$row->max_index;
			}elseif(strlen ($row->max_index) == 5){
				$strCustomerID = "CU000".$row->max_index;
			}elseif(strlen ($row->max_index) == 6){
				$strCustomerID = "CU00".$row->max_index;
			}elseif(strlen ($row->max_index) == 7){
				$strCustomerID = "CU0".$row->max_index;
			}elseif(strlen ($row->max_index) == 8){
				$strCustomerID = "CU".$row->max_index;
			}
		}

		mysqli_stmt_free_result($stmt);

		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (customerID, fullname, address, city, province, postcode, phone, email, customerClass, customerType, customerAVP, customerPoint, citizenID, passportID, title, cellPhone, fax, CRE_DTE, CRE_USR, UPD_DTE ,DEL_DTE ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

//		mysqli_stmt_bind_param($stmt, 'ssssssssssddsssssssss', $strCustomerID, $item->fullname, $item->address, $item->city, $item->province, $item->postcode, $item->phone, $item->email, $item->customerClass, $item->customerType, $item->customerAVP, $item->customerPoint, $item->citizenID ,$item->passportID,$item->title,$row->cellPhone,$item->fax, $item->CRE_DTE->format('Y-m-d H:i:s'), $item->CRE_USR, $item->CRE_DTE->format('Y-m-d H:i:s'), $item->CRE_DTE->format('Y-m-d H:i:s'));

		mysqli_stmt_bind_param($stmt, 'ssssssssssddsssssssss', $strCustomerID, $item->fullname, $item->address, $item->city, $item->province, $item->postcode, $item->phone, $item->email, $item->customerClass, $item->customerType, $item->customerAVP, $item->customerPoint, $item->citizenID ,$item->passportID,$item->title,$row->cellPhone,$item->fax, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'));

		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		//$autoid = mysqli_stmt_insert_id($stmt);

		//mysqli_stmt_free_result($stmt);		
		//mysqli_close($this->connection);

		return $strCustomerID;
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
	
	
	public function get_customerIDByCitizenID($CitizenID){
		
		$customerID = null;
		
		// get Customer Data
		$searchCause = "SELECT customerID FROM $this->tablename WHERE citizenID = '".$CitizenID."'";	

		$stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();		
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		/* store result */
    	mysqli_stmt_store_result($stmt);
	
		$num_rows = mysqli_stmt_num_rows($stmt);
		
		//echo $num_rows;
		
		if($num_rows == 0){
			$customerID = null;
		}elseif($num_rows == 1){
			mysqli_stmt_bind_result($stmt,$customerID);
			$this->throwExceptionOnError();
			
			mysqli_stmt_fetch($stmt);
			$this->throwExceptionOnError();
			
		}
				
		return $customerID;		
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

	
	public function myUp2($item) {
	
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET UPD_DTE=? WHERE customerIndex=?");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'si', $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->customerIndex);		
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);
	}
}

?>
