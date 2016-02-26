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
class SccrrbaseService {

	var $username = "root";
	var $password = "";
	var $server = "localhost";
	var $port = "3306";
	var $databasename = "srpos_cws";
	var $tablename = "_ccrr_base";

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

	/**
	 * Returns all the rows from the table.
	 *
	 * Add authroization or any logical checks for secure access to your data 
	 *
	 * @return array
	 */
	public function getAll_ccrr_base() {

		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->listIndex, $row->saleNo, $row->CWS_index, $row->serviceUserID, $row->cardID, $row->reserveDuration, $row->CHKIN_DTE, $row->CHKOUT_DTE, $row->CHKOUT_ROLL, $row->CHKOUT_saleNo, $row->spentDuration, $row->CRE_USR, $row->CRE_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE, $row->Note);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CHKIN_DTE = new DateTime($row->CHKIN_DTE);
	      $row->CHKOUT_DTE = new DateTime($row->CHKOUT_DTE);
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->listIndex, $row->saleNo, $row->CWS_index, $row->serviceUserID, $row->cardID, $row->reserveDuration, $row->CHKIN_DTE, $row->CHKOUT_DTE, $row->CHKOUT_ROLL, $row->CHKOUT_saleNo, $row->spentDuration, $row->CRE_USR, $row->CRE_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE, $row->Note);
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
	public function get_ccrr_baseByID($itemID) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename where listIndex=?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'i', $itemID);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_result($stmt, $row->listIndex, $row->saleNo, $row->CWS_index, $row->serviceUserID, $row->cardID, $row->reserveDuration, $row->CHKIN_DTE, $row->CHKOUT_DTE, $row->CHKOUT_ROLL, $row->CHKOUT_saleNo, $row->spentDuration, $row->CRE_USR, $row->CRE_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE, $row->Note);
		
		if(mysqli_stmt_fetch($stmt)) {
	      $row->CHKIN_DTE = new DateTime($row->CHKIN_DTE);
	      $row->CHKOUT_DTE = new DateTime($row->CHKOUT_DTE);
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      return $row;
		} else {
	      return null;
		}
	}
	
	
	/**
	 * Returns Code Value.
	 * 1 :: Create New Record
	 * 2 :: Update Old Record
	 * 3 :: Update Last Record of SaleNo
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * Add at 05/09/2015
	 */
	public function createOrUpdate($item){
		//check transection SaleNo ,count row of SaleNo
		$reSult_Code = 0;
		$count_SaleNo = $this->count_SaleNo($item->saleNo,0);
		
		if($count_SaleNo == 0){
			$this->create_ccrr_base_own($item);
			$reSult_Code = 1; // Create New Record
		}else{
			if($count_SaleNo == 1){
				$reSult_Code = 2; // Update Old Recode
			}else{
				$reSult_Code = 3; // Update Last Record 
			}
			// get Max ListIndex for Updaet Last Transection
			$item->listIndex = $this->get_Max_listIndex($item->saleNo);
			$this->update_ccrr_base($item); 
		}
		
		return $reSult_Code;
	}

	/**
	 * Returns the item corresponding to the value specified for the primary key.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function create_ccrr_base_own($item) {

		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (saleNo, CWS_index, serviceUserID, cardID, reserveDuration, CHKIN_DTE, CHKOUT_DTE, CHKOUT_ROLL, CHKOUT_saleNo, spentDuration, CRE_USR, CRE_DTE, UPD_USR, UPD_DTE, DEL_USR, DEL_DTE, Note) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'sississisisssssss', $item->saleNo, $item->CWS_index, $item->serviceUserID, $item->cardID, $item->reserveDuration, 
		$item->CHKIN_DTE->toString('YYYY-MM-dd HH:mm:ss'), 
		$item->CHKOUT_DTE->toString('YYYY-MM-dd HH:mm:ss'), 
		$item->CHKOUT_ROLL, $item->CHKOUT_saleNo, $item->spentDuration, $item->CRE_USR, 
		$item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, 
		$item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, 
		$item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->Note);
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
	public function update_ccrr_base($item) {
	
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET saleNo=?, CWS_index=?, serviceUserID=?, cardID=?, reserveDuration=?, CHKIN_DTE=?, CHKOUT_DTE=?, CHKOUT_ROLL=?, CHKOUT_saleNo=?, spentDuration=?, CRE_USR=?, CRE_DTE=?, UPD_USR=?, UPD_DTE=?, DEL_USR=?, DEL_DTE=?, Note=? WHERE listIndex=?");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'sississisisssssssi', $item->saleNo, $item->CWS_index, $item->serviceUserID, $item->cardID, $item->reserveDuration, $item->CHKIN_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CHKOUT_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CHKOUT_ROLL, $item->CHKOUT_saleNo, $item->spentDuration, $item->CRE_USR, $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->Note, $item->listIndex);		
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
	public function delete_ccrr_base($itemID) {
				
		$stmt = mysqli_prepare($this->connection, "DELETE FROM $this->tablename WHERE listIndex = ?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'i', $itemID);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);
	}
	
	
	
	
	/**
	* Param 1 :: Sale No
	* Param 2 :: CHECK_ROLL
	 * Returns the number of SaleNo in the table.
	 *
	 *
	 * Add at 05/09/2015
	 */
	public function count_SaleNo($SaleNo, $chkout_roll) {
		$stmt = mysqli_prepare($this->connection, "SELECT COUNT(*) AS COUNT FROM $this->tablename WHERE saleNo = ? AND CHKOUT_ROLL = ?");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'si', $SaleNo, $chkout_roll);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_result($stmt, $rec_count);
		$this->throwExceptionOnError();
		
		mysqli_stmt_fetch($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_free_result($stmt);
		//mysqli_close($this->connection);
		
		return $rec_count;
	}
	
	
	/**
	 * Returns Max listIndex number of SaleNo in the table.
	 *
	 * 
	 * Add at 05/09/2015
	 */
	public function get_Max_listIndex($SaleNo) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT MAX(listIndex) AS MAX_Index FROM _ccrr_base WHERE saleNo = ? AND CHKOUT_ROLL = 0");
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
		//mysqli_close($this->connection);
		
		return $rec_count;
		
		
	}
	
	/**
	 * Return 0:: No Good
	 * Return 1 :: OK
	 *
	 *
	 * 
	 */
	public function checkOutAfterPayDone($ccrr_obj, $saleDetail, $saleList)
	{
		$result = 0;
		require_once("../SMITPOS/services/SaledetailService.php");
		//require_once("http://192.168.1.210/SMITPOS/services/SaledetailService.php");

		$count_SaleNo = $this->count_SaleNo($ccrr_obj->saleNo,2); // check ว่ามีรายการที่ต้องอัพเดทไหม
		if($count_SaleNo > 1 ){
			// $saleDetail and $saleList is not null, update value
			$cls_SaledetailService = new SaledetailService();
			$cls_SaledetailService->addSalelistTransition($saleDetail,$saleList);

			// disable wifi
			$this->fncDisableWifi($ccrr_obj->saleNo);

		}

		// update ccrrBase object
		$result_AddUpdate = $this->createOrUpdate($ccrr_obj);
		if($result_AddUpdate != 3){
			$result = 1;
		}

		// disable wifi [TBC -- For Temporary Test]
		$this->fncDisableWifi($ccrr_obj->saleNo);

		return $result;

	}

	/**
	 * Disable Wifi by saleNo
	 *
	 * 
	 */
	private function fncDisableWifi($saleNo){

		//$url = URL_TO_RECEIVING_PHP;
		$url = "http://192.168.1.200/srpos_radius/controllers/grabcmd.php";
		//$url = "http://localhost/srpos_radius/controllers/grabcmd.php";

		$fields = array(
			"wifiUser" => "",
			"expiration" => "DEAD"
		);

		$fields["wifiUser"] = $saleNo;

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
	public function get_ccrr_base_paged($startIndex, $numItems) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename LIMIT ?, ?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ii', $startIndex, $numItems);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->listIndex, $row->saleNo, $row->CWS_index, $row->serviceUserID, $row->cardID, $row->reserveDuration, $row->CHKIN_DTE, $row->CHKOUT_DTE, $row->CHKOUT_ROLL, $row->CHKOUT_saleNo, $row->spentDuration, $row->CRE_USR, $row->CRE_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE, $row->Note);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CHKIN_DTE = new DateTime($row->CHKIN_DTE);
	      $row->CHKOUT_DTE = new DateTime($row->CHKOUT_DTE);
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->listIndex, $row->saleNo, $row->CWS_index, $row->serviceUserID, $row->cardID, $row->reserveDuration, $row->CHKIN_DTE, $row->CHKOUT_DTE, $row->CHKOUT_ROLL, $row->CHKOUT_saleNo, $row->spentDuration, $row->CRE_USR, $row->CRE_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE,$row->Note);
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
	
	
	public function get_still_checkIn_user($searchKey) {
		$cardID = $searchKey;
		$sql_query_field = "SELECT * FROM  `_ccrr_base` WHERE  `cardID` =  '{$cardID}' AND  `CHKOUT_ROLL` =0 AND `spentDuration` =0";

		$stmt = mysqli_prepare($this->connection, $sql_query_field);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->listIndex, $row->saleNo, $row->CWS_index, $row->serviceUserID, $row->cardID, $row->reserveDuration, $row->CHKIN_DTE, $row->CHKOUT_DTE, $row->CHKOUT_ROLL, $row->CHKOUT_saleNo, $row->spentDuration, $row->CRE_USR, $row->CRE_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE, $row->Note);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->CHKIN_DTE = new DateTime($row->CHKIN_DTE);
	      $row->CHKOUT_DTE = new DateTime($row->CHKOUT_DTE);
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->listIndex, $row->saleNo, $row->CWS_index, $row->serviceUserID, $row->cardID, $row->reserveDuration, $row->CHKIN_DTE, $row->CHKOUT_DTE, $row->CHKOUT_ROLL, $row->CHKOUT_saleNo, $row->spentDuration, $row->CRE_USR, $row->CRE_DTE, $row->UPD_USR, $row->UPD_DTE, $row->DEL_USR, $row->DEL_DTE,$row->Note);
	    }
		
		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);
		
		return $rows;
	}
	
	
}

?>
