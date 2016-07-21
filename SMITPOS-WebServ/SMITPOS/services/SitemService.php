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
class SitemService {

	var $username = "root";
	var $password = "";
	var $server = "127.0.0.1"; // "localhost";
	var $port = "3306";
	var $databasename = "stechschema";
	var $tablename = "_item";

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
	public function getAll_item() {

		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemDetail, $row->itemPrice, $row->itemLatestCost, $row->itemStock, $row->itemProPoint, $row->itemProStart, $row->itemProEnd, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->itemSizeIndex, $row->itemLocationIndex);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->itemProStart = new DateTime($row->itemProStart);
	      $row->itemProEnd = new DateTime($row->itemProEnd);
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemDetail, $row->itemPrice, $row->itemLatestCost, $row->itemStock, $row->itemProPoint, $row->itemProStart, $row->itemProEnd, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->itemSizeIndex, $row->itemLocationIndex);
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
	public function get_itemByID($itemID) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename where itemIndex=?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'i', $itemID);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemDetail, $row->itemPrice, $row->itemLatestCost, $row->itemStock, $row->itemProPoint, $row->itemProStart, $row->itemProEnd, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->itemSizeIndex, $row->itemLocationIndex);
		
		if(mysqli_stmt_fetch($stmt)) {
	      $row->itemProStart = new DateTime($row->itemProStart);
	      $row->itemProEnd = new DateTime($row->itemProEnd);
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      return $row;
		} else {
	      return null;
		}
	}


	public function getSKU_item($refItem) {

		$stmt = mysqli_prepare($this->connection, "SELECT * FROM `_itemsku` WHERE `_itemsku`.`referenceUnitIndex` = $refItem->itemUnitIndex AND `itemID` LIKE '%$refItem->itemID%'");
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemDetail, $row->SKUPrice, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->itemSizeIndex, $row->unit, $row->unitCategoryIndex, $row->referenceUnitIndex, $row->type, $row->ratio, $row->precision);

	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
		  mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemDetail, $row->SKUPrice, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->itemSizeIndex, $row->unit, $row->unitCategoryIndex, $row->referenceUnitIndex, $row->type, $row->ratio, $row->precision);
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
	public function create_item($item) {

		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (itemID, itembarcodeID, itemName, itemDetail, itemPrice, itemLatestCost, itemStock, itemProPoint, itemProStart, itemProEnd, CRE_DTE, CRE_USR, UPD_DTE, UPD_USR, DEL_DTE, DEL_USR, itemCatagoryIndex, itemUnitIndex, itemSizeIndex, itemLocationIndex) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'ssssddiissssssssiiii', $item->itemID, $item->itembarcodeID, $item->itemName, $item->itemDetail, $item->itemPrice, $item->itemLatestCost, $item->itemStock, $item->itemProPoint, $item->itemProStart->toString('YYYY-MM-dd HH:mm:ss'), $item->itemProEnd->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->itemCatagoryIndex, $item->itemUnitIndex, $item->itemSizeIndex, $item->itemLocationIndex);
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
	public function update_item($item) {
	
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET itemID=?, itembarcodeID=?, itemName=?, itemDetail=?, itemPrice=?, itemLatestCost=?, itemStock=?, itemProPoint=?, itemProStart=?, itemProEnd=?, CRE_DTE=?, CRE_USR=?, UPD_DTE=?, UPD_USR=?, DEL_DTE=?, DEL_USR=?, itemCatagoryIndex=?, itemUnitIndex=?, itemSizeIndex=?, itemLocationIndex=? WHERE itemIndex=?");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ssssddiissssssssiiiii', $item->itemID, $item->itembarcodeID, $item->itemName, $item->itemDetail, $item->itemPrice, $item->itemLatestCost, $item->itemStock, $item->itemProPoint, $item->itemProStart->toString('YYYY-MM-dd HH:mm:ss'), $item->itemProEnd->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->itemCatagoryIndex, $item->itemUnitIndex, $item->itemSizeIndex, $item->itemLocationIndex, $item->itemIndex);		
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
	public function delete_item($itemID) {
				
		$stmt = mysqli_prepare($this->connection, "DELETE FROM $this->tablename WHERE itemIndex = ?");
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
	public function get_item_paged($startIndex, $numItems) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename LIMIT ?, ?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ii', $startIndex, $numItems);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemDetail, $row->itemPrice, $row->itemLatestCost, $row->itemStock, $row->itemProPoint, $row->itemProStart, $row->itemProEnd, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->itemSizeIndex, $row->itemLocationIndex);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->itemProStart = new DateTime($row->itemProStart);
	      $row->itemProEnd = new DateTime($row->itemProEnd);
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemDetail, $row->itemPrice, $row->itemLatestCost, $row->itemStock, $row->itemProPoint, $row->itemProStart, $row->itemProEnd, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->itemSizeIndex, $row->itemLocationIndex);
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
	 * Returns _item matched the search criteria (KP)
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function getSearch_item($searchCause) {
		 
	    $stmt = mysqli_prepare($this->connection, $searchCause);
		$this->throwExceptionOnError();
		
		//mysqli_stmt_bind_param($stmt,  , $searchCause);
		//$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemDetail, $row->itemPrice, $row->itemLatestCost, $row->itemStock, $row->itemProPoint, $row->itemProStart, $row->itemProEnd, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->itemSizeIndex, $row->itemLocationIndex);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->itemProStart = new DateTime($row->itemProStart);
	      $row->itemProEnd = new DateTime($row->itemProEnd);
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemDetail, $row->itemPrice, $row->itemLatestCost, $row->itemStock, $row->itemProPoint, $row->itemProStart, $row->itemProEnd, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->itemSizeIndex, $row->itemLocationIndex);
	    }
		
		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);
		
		return $rows;
	}

	
	/**
	 * Returns distinct itemType from all elements (KP)
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function getDistinct_itemType() {
		$stmt = mysqli_prepare($this->connection, "SELECT DISTINCT (itemType) FROM $this->tablename");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->itemType);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->itemType);
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
	}

	
	/**
	 * Returns distinct itemType from all elements (KP)
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function getDistinct_itemUnit() {
		$stmt = mysqli_prepare($this->connection, "SELECT DISTINCT (itemUnit) FROM $this->tablename");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->itemUnit);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->itemUnit);
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
	public function myCreate_item($SQLInsert) {

		$stmt = mysqli_prepare($this->connection, $SQLInsert);
		$this->throwExceptionOnError();

		//mysqli_stmt_bind_param($stmt, 'sssssssddisissssssss', $item->itemID, $item->itembarcodeID, $item->itemName, $item->itemDetail, $item->itemSize, $item->itemType, $item->itemUnit, $item->itemPrice, $item->itemLatestCost, $item->itemStock, $item->itemLocation, $item->itemProPoint, $item->itemProStart->toString('YYYY-MM-dd HH:mm:ss'), $item->itemProEnd->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR);
		//$this->throwExceptionOnError();

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
	public function myUpdate_item($item) {
	
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET itemID=?, itembarcodeID=?, itemName=?, itemDetail=?, itemPrice=?, itemLatestCost=?, itemStock=?, itemProPoint=?, itemProStart=?, itemProEnd=?, CRE_DTE=?, CRE_USR=?, UPD_DTE=?, UPD_USR=?, DEL_DTE=?, DEL_USR=?, itemCatagoryIndex=?, itemUnitIndex=?, itemSizeIndex=?, itemLocationIndex=? WHERE itemIndex=?");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ssssddiissssssssiiiii', $item->itemID, $item->itembarcodeID, $item->itemName, $item->itemDetail, $item->itemPrice, $item->itemLatestCost, $item->itemStock, $item->itemProPoint, $item->itemProStart->toString('YYYY-MM-dd HH:mm:ss'), $item->itemProEnd->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->itemCatagoryIndex, $item->itemUnitIndex, $item->itemSizeIndex, $item->itemLocationIndex, $item->itemIndex);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);
	}

	
	/**
	 * Updates the item Quantity in the table.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * @param stdClass $item
	 * @return void
	 */
	public function update_itemQtyStock($item) {

		$stmt = mysqli_prepare($this->connection, 
		"UPDATE $this->tablename 
		SET itemStock=?, 
		UPD_DTE=?,
		UPD_USR=?
		WHERE itemID=?");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'isss', 
		$item->itemStock, 
		$item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'),
		$item->UPD_USR, 
		$item->itemID);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		mysqli_stmt_free_result($stmt);
		mysqli_close($this->connection);
	}
	
	
	public function myUpdateStock($qty, $itemID) {
				
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET itemStock = itemStock + ? WHERE itemIndex = ?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ii', $qty, $itemID);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);
	}
	
	
	/**
	 * Returns the item corresponding to the value specified for the primary key.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function create_item_own($item) {

		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (itemID, itembarcodeID, itemName, itemDetail, itemPrice, itemLatestCost, itemStock, itemProPoint, itemProStart, itemProEnd, CRE_DTE, CRE_USR, UPD_DTE, UPD_USR, DEL_DTE, DEL_USR, itemCatagoryIndex, itemUnitIndex, itemSizeIndex, itemLocationIndex) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'ssssddiissssssssiiii', $item->itemID, $item->itembarcodeID, $item->itemName, $item->itemDetail, $item->itemPrice, $item->itemLatestCost, $item->itemStock, $item->itemProPoint, $item->itemProStart->toString('YYYY-MM-dd HH:mm:ss'), $item->itemProEnd->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->CRE_USR, $item->UPD_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->UPD_USR, $item->DEL_DTE->toString('YYYY-MM-dd HH:mm:ss'), $item->DEL_USR, $item->itemCatagoryIndex, $item->itemUnitIndex, $item->itemSizeIndex, $item->itemLocationIndex);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);		
		$this->throwExceptionOnError();

		$autoid = mysqli_stmt_insert_id($stmt);

		mysqli_stmt_free_result($stmt);		
		mysqli_close($this->connection);

		return $autoid;
	}

	public function countBySearch($itemsID, $keyword) {
		$sql = "SELECT COUNT(*) AS COUNT FROM $this->tablename ";
		
		$where = " WHERE DEL_USR IS NULL ";
		
		/** -1: to query all items, 0: for default ID; */
		if ($itemsID != -1){
			if ($where == ""){
				$where .= " WHERE ";	
			} else {
				$where .= " AND ";	
			}
			
			$where .= " itemIndex={$itemsID} ";
		}
		
		if ($keyword != ""){
			if ($where == ""){
				$where .= " WHERE ";	
			} else {
				$where .= " AND ";	
			}
			
			$where .= " itemID LIKE '%{$keyword}%' ";
		}
		
		$sql .= $where;
		
		$stmt = mysqli_prepare($this->connection, $sql);
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
	
	public function get_itemsByitemID($itemsID, $startIndex, $numItems, $keyword){
		$sql = "SELECT * FROM $this->tablename ";
		
		$where = " WHERE DEL_USR IS NULL ";
		
		/** -1: to query all items, 0: for default ID; */
		if ($itemsID != -1){
			if ($where == ""){
				$where .= " WHERE ";	
			} else {
				$where .= " AND ";	
			}
			
			$where .= " itemIndex={$itemsID} ";
		}
		
		if ($keyword != ""){
			if ($where == ""){
				$where .= " WHERE ";	
			} else {
				$where .= " AND ";	
			}
			
			$where .= " itemID LIKE '%{$keyword}%' ";
		}
		
		$sql .= $where . " LIMIT {$startIndex},{$numItems}";
		
		$stmt = mysqli_prepare($this->connection, $sql);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemDetail, $row->itemPrice, $row->itemLatestCost, $row->itemStock, $row->itemProPoint, $row->itemProStart, $row->itemProEnd, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->itemSizeIndex, $row->itemLocationIndex);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->itemProStart = new DateTime($row->itemProStart);
	      $row->itemProEnd = new DateTime($row->itemProEnd);
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemDetail, $row->itemPrice, $row->itemLatestCost, $row->itemStock, $row->itemProPoint, $row->itemProStart, $row->itemProEnd, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->itemSizeIndex, $row->itemLocationIndex);
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
	}

	public function countByCategoryId($catagoryID, $keyword) {
		$sql = "SELECT COUNT(*) AS COUNT FROM $this->tablename ";
		
		$where = " WHERE DEL_USR IS NULL ";
		
		/** -1: to query all items, 0: for default ID; */
		if ($catagoryID != -1){
			if ($where == ""){
				$where .= " WHERE ";	
			} else {
				$where .= " AND ";	
			}
			
			$where .= " itemCatagoryIndex={$catagoryID} ";
		}
		
		if ($keyword != ""){
			if ($where == ""){
				$where .= " WHERE ";	
			} else {
				$where .= " AND ";	
			}
			
			$where .= " itemName LIKE '%{$keyword}%' ";
		}
		
		$sql .= $where;
		
		$stmt = mysqli_prepare($this->connection, $sql);
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
	
	public function get_itemsByCatagoryID($catagoryID, $startIndex, $numItems, $keyword){
		$sql = "SELECT * FROM $this->tablename ";
		
		$where = " WHERE DEL_USR IS NULL ";
		
		/** -1: to query all items, 0: for default ID; */
		if ($catagoryID != -1){
			if ($where == ""){
				$where .= " WHERE ";	
			} else {
				$where .= " AND ";	
			}
			
			$where .= " itemCatagoryIndex={$catagoryID} ";
		}
		
		if ($keyword != ""){
			if ($where == ""){
				$where .= " WHERE ";	
			} else {
				$where .= " AND ";	
			}
			
			$where .= " itemName LIKE '%{$keyword}%' ";
		}
		
		$sql .= $where . " LIMIT {$startIndex},{$numItems}";
		
		$stmt = mysqli_prepare($this->connection, $sql);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemDetail, $row->itemPrice, $row->itemLatestCost, $row->itemStock, $row->itemProPoint, $row->itemProStart, $row->itemProEnd, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->itemSizeIndex, $row->itemLocationIndex);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->itemProStart = new DateTime($row->itemProStart);
	      $row->itemProEnd = new DateTime($row->itemProEnd);
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemDetail, $row->itemPrice, $row->itemLatestCost, $row->itemStock, $row->itemProPoint, $row->itemProStart, $row->itemProEnd, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->itemSizeIndex, $row->itemLocationIndex);
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
	}

	public function countByUnitId($unitID, $keyword) {
		$sql = "SELECT COUNT(*) AS COUNT FROM $this->tablename ";

		$where = " WHERE DEL_USR IS NULL ";

		/** -1: to query all items, 0: for default ID; */
		if ($unitID != -1){
			if ($where == ""){
				$where .= " WHERE ";
			} else {
				$where .= " AND ";
			}

			$where .= " itemUnitIndex={$unitID} ";
		}

		if ($keyword != ""){
			if ($where == ""){
				$where .= " WHERE ";
			} else {
				$where .= " AND ";
			}

			$where .= " itemName LIKE '%{$keyword}%' ";
		}

		$sql .= $where;

		$stmt = mysqli_prepare($this->connection, $sql);
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

	public function get_itemsByUnitID($unitID, $startIndex, $numItems, $keyword){
		$sql = "SELECT * FROM $this->tablename ";

		$where = " WHERE DEL_USR IS NULL ";

		/** -1: to query all items, 0: for default ID; */
		if ($unitID != -1){
			if ($where == ""){
				$where .= " WHERE ";
			} else {
				$where .= " AND ";
			}

			$where .= " itemUnitIndex={$unitID} ";
		}

		if ($keyword != ""){
			if ($where == ""){
				$where .= " WHERE ";
			} else {
				$where .= " AND ";
			}

			$where .= " itemName LIKE '%{$keyword}%' ";
		}

		$sql .= $where . " LIMIT {$startIndex},{$numItems}";

		$stmt = mysqli_prepare($this->connection, $sql);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemDetail, $row->itemPrice, $row->itemLatestCost, $row->itemStock, $row->itemProPoint, $row->itemProStart, $row->itemProEnd, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->itemSizeIndex, $row->itemLocationIndex);

	    while (mysqli_stmt_fetch($stmt)) {
	      $row->itemProStart = new DateTime($row->itemProStart);
	      $row->itemProEnd = new DateTime($row->itemProEnd);
	      $row->CRE_DTE = new DateTime($row->CRE_DTE);
	      $row->UPD_DTE = new DateTime($row->UPD_DTE);
	      $row->DEL_DTE = new DateTime($row->DEL_DTE);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemDetail, $row->itemPrice, $row->itemLatestCost, $row->itemStock, $row->itemProPoint, $row->itemProStart, $row->itemProEnd, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->itemSizeIndex, $row->itemLocationIndex);
	    }

		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);

	    return $rows;
	}

	public function countBySizeId($sizeID, $keyword) {
		$sql = "SELECT COUNT(*) AS COUNT FROM $this->tablename ";

		$where = " WHERE DEL_USR IS NULL ";

		/** -1: to query all items, 0: for default ID; */
		if ($sizeID != -1){
			if ($where == ""){
				$where .= " WHERE ";
			} else {
				$where .= " AND ";
			}

			$where .= " itemSizeIndex={$sizeID} ";
		}

		if ($keyword != ""){
			if ($where == ""){
				$where .= " WHERE ";
			} else {
				$where .= " AND ";
			}

			$where .= " itemName LIKE '%{$keyword}%' ";
		}

		$sql .= $where;

		$stmt = mysqli_prepare($this->connection, $sql);
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

	public function get_itemsBySizeID($sizeID, $startIndex, $numItems, $keyword){
		$sql = "SELECT * FROM $this->tablename ";

		$where = " WHERE DEL_USR IS NULL ";

		/** -1: to query all items, 0: for default ID; */
		if ($sizeID != -1){
			if ($where == ""){
				$where .= " WHERE ";
			} else {
				$where .= " AND ";
			}

			$where .= " itemSizeIndex={$sizeID} ";
		}

		if ($keyword != ""){
			if ($where == ""){
				$where .= " WHERE ";
			} else {
				$where .= " AND ";
			}

			$where .= " itemName LIKE '%{$keyword}%' ";
		}

		$sql .= $where . " LIMIT {$startIndex},{$numItems}";

		$stmt = mysqli_prepare($this->connection, $sql);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemDetail, $row->itemPrice, $row->itemLatestCost, $row->itemStock, $row->itemProPoint, $row->itemProStart, $row->itemProEnd, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->itemSizeIndex, $row->itemLocationIndex);

		while (mysqli_stmt_fetch($stmt)) {
			$row->itemProStart = new DateTime($row->itemProStart);
			$row->itemProEnd = new DateTime($row->itemProEnd);
			$row->CRE_DTE = new DateTime($row->CRE_DTE);
			$row->UPD_DTE = new DateTime($row->UPD_DTE);
			$row->DEL_DTE = new DateTime($row->DEL_DTE);
			$rows[] = $row;
			$row = new stdClass();
			mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itembarcodeID, $row->itemName, $row->itemDetail, $row->itemPrice, $row->itemLatestCost, $row->itemStock, $row->itemProPoint, $row->itemProStart, $row->itemProEnd, $row->CRE_DTE, $row->CRE_USR, $row->UPD_DTE, $row->UPD_USR, $row->DEL_DTE, $row->DEL_USR, $row->itemCatagoryIndex, $row->itemUnitIndex, $row->itemSizeIndex, $row->itemLocationIndex);
		}

		mysqli_stmt_free_result($stmt);
		mysqli_close($this->connection);

		return $rows;
	}

	public function get_StockReportRangeDate($beforeDate,$afterDate) {
		// stmt = statement
		$stmt = mysqli_prepare($this->connection,"
		SELECT 
		`tb_i`.`itemIndex`,
		`tb_i`.`itemID`,
		`tb_i`.`itemName`,
		IFNULL(`tb_startQTY`.`startStock`,0) as 'startStock',
		IFNULL(`tb_in_sum`.`sum_inQTY`,0) as 'sum_inQTY',
		IFNULL(`tb_mov_sum`.`sum_moveQTY`,0) as 'sum_moveQTY',
		IFNULL(`tb_sl_sum`.`sum_saleQTY`,0) as 'sum_saleQTY',
		IFNULL(`tb_move`.`stockQTY`,0) as 'remainQTY'
		FROM  
		`_item` AS tb_i
		LEFT JOIN ( SELECT `in_in`.`itemIndex`, SUM(`in_in`.`inQTY`) as 'sum_inQTY'
			FROM `inventoryin` as in_in
						WHERE DATE(`in_in`.`CRE_DTE`) BETWEEN DATE('$beforeDate') AND DATE('$afterDate')
						GROUP BY `in_in`.`itemIndex`
						) AS tb_in_sum ON `tb_in_sum`.`itemIndex` = `tb_i`.`itemIndex`
		LEFT JOIN ( SELECT `sl`.`itemIndex`, SUM(`sl`.`saleQTY`) as 'sum_saleQTY'
			FROM `salelist` as sl
						WHERE DATE(`sl`.`CRE_DTE`) BETWEEN DATE('$beforeDate') AND DATE('$afterDate')
						GROUP BY `sl`.`itemIndex`
			UNION ALL SELECT `sl_o`.`itemIndex`, SUM(`sl_o`.`saleQTY`) as 'sum_saleQTY'
			FROM `salelist_opt` as sl_o
						WHERE DATE(`sl_o`.`CRE_DTE`) BETWEEN DATE('$beforeDate') AND DATE('$afterDate')
				GROUP BY `sl_o`.`itemIndex`
				) AS tb_sl_sum ON `tb_sl_sum`.`itemIndex` = `tb_i`.`itemIndex`
		LEFT JOIN ( SELECT `in_mov`.`itemIndex`, SUM(`in_mov`.`moveQTY`) as 'sum_moveQTY'
			FROM `inventorymove` as in_mov
						WHERE DATE(`in_mov`.`CRE_DTE`) BETWEEN DATE('$beforeDate') AND DATE('$afterDate')
						GROUP BY `in_mov`.`itemIndex`
						) AS tb_mov_sum ON `tb_mov_sum`.`itemIndex` = `tb_i`.`itemIndex`
		LEFT JOIN (SELECT `itemIndex` as `iIndex`,`stockQTY`
			FROM `itemmovementview` as `i_movement`
			INNER JOIN
					(
					SELECT MAX(CRE_DTE) as MAXDate , `imo`.`itemIndex` as sIndex
					FROM `itemmovementview` as `imo`
					WHERE DATE(CRE_DTE) BETWEEN DATE('$beforeDate') AND DATE('$afterDate')
					GROUP BY `imo`.`itemIndex`
					) AS  `tb_movement_y`
					ON  `i_movement`. `itemIndex` =  `tb_movement_y`.`sIndex`
					AND `i_movement`.`CRE_DTE` = `tb_movement_y`.`MAXDate`
					ORDER BY `i_movement`.`itemIndex`) AS `tb_move` ON `tb_move`.`iIndex` = `tb_i`.`itemIndex`

		LEFT JOIN (
		SELECT  
		`itemIndex` , `actionType`,
		IF(actionType LIKE 'IN%','สถานะเข้า','สถานะออก') as 'status',
		IF(actionType LIKE 'IN%',`stockQTY` - `QTY`,`stockQTY` + `QTY`) as 'startStock'
		FROM `itemmovementview` as `i_movement`
		INNER JOIN
				(
				SELECT MIN(CRE_DTE) as MINDate , `imo`.`itemIndex` as sIndex
				FROM `itemmovementview` as `imo`
		WHERE DATE(CRE_DTE) BETWEEN DATE('$beforeDate') AND DATE('$afterDate')
				GROUP BY `imo`.`itemIndex`
				) AS  `tb_movement_y`
				ON  `i_movement`. `itemIndex` =  `tb_movement_y`.`sIndex`
				AND `i_movement`.`CRE_DTE` = `tb_movement_y`.`MINDate`
		ORDER BY `i_movement`.`itemIndex`) as `tb_startQTY` ON `tb_startQTY`.`itemIndex` = `tb_i`.`itemIndex`
		");
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		// Empty array
		$rows = array();

		// Bind Data
		mysqli_stmt_bind_result($stmt,
		$row->itemIndex,
		$row->itemID,
		$row->itemName,
		$row->startQTY,
		$row->sum_inQTY,
		$row->sum_moveQTY,
		$row->sum_saleQTY,
		$row->remainQTY
		);

		// Retrive Data
		while(mysqli_stmt_fetch($stmt)){
			$rows[] = $row;
			$row = new stdClass(); /* Empty object of Dynamic Class*/
			mysqli_stmt_bind_result($stmt,
			$row->itemIndex,
			$row->itemID,
			$row->itemName,
			$row->startQTY,
			$row->sum_inQTY,
			$row->sum_moveQTY,
			$row->sum_saleQTY,
			$row->remainQTY
		);
		}

		mysqli_stmt_free_result($stmt);
		mysqli_close($this->connection);
		return $rows;
	}
	
	/**
	this function is for query stock summary with year and month
	*/
	public function get_StockReportTragetDate($year,$month) {
		// stmt = statement
		$stmt = mysqli_prepare($this->connection,"
		SELECT
		`tb_i`.`itemIndex`,
		`tb_i`.`itemID`,
		`tb_i`.`itemName`,
		IFNULL(`tb_startQTY`.`startQTY`,0) as 'startQTY',
		IFNULL(`tb_in_sum`.`sum_inQTY`,0) as 'sum_inQTY',
		IFNULL(`tb_sl_sum`.`sum_saleQTY`,0) as 'sum_saleQTY',
		IFNULL(`tb_move`.`stockQTY`,0) as 'remainQTY'
		FROM
		`_item` AS tb_i
		LEFT JOIN (SELECT `in_in`.`itemIndex`, SUM(`in_in`.`inQTY`) as 'sum_inQTY'
			FROM `inventoryin` as in_in
				WHERE YEAR(`in_in`.`CRE_DTE` ) = $year AND
				MONTH(`in_in`.`CRE_DTE` ) = $month
			GROUP BY `in_in`.`itemIndex`
			) AS tb_in_sum ON `tb_in_sum`.`itemIndex` = `tb_i`.`itemIndex`
		LEFT JOIN (SELECT `sl`.`itemIndex`, SUM(`sl`.`saleQTY`) as 'sum_saleQTY'
			FROM `salelist` as sl
				WHERE YEAR(`sl`.`CRE_DTE` ) = $year AND
				MONTH(`sl`.`CRE_DTE` )  = $month
				GROUP BY `sl`.`itemIndex`
				) AS tb_sl_sum ON `tb_sl_sum`.`itemIndex` = `tb_i`.`itemIndex`
		LEFT JOIN ( SELECT `in_mov`.`itemIndex`, SUM(`in_mov`.`moveQTY`) as 'sum_moveQTY'
			FROM `inventorymove` as in_mov
				WHERE YEAR(`in_mov`.`CRE_DTE` ) = $year AND
				MONTH(`in_mov`.`CRE_DTE` ) = $month
				GROUP BY `in_mov`.`itemIndex`
				) AS tb_mov_sum ON `tb_mov_sum`.`itemIndex` = `tb_i`.`itemIndex`
		LEFT JOIN (SELECT `itemIndex` as `iIndex`,`stockQTY`
			FROM `itemmovementview` as `i_movement`
			INNER JOIN
					(
					SELECT MAX(CRE_DTE) as MAXDate , `imo`.`itemIndex` as sIndex
					FROM `itemmovementview` as `imo`
					WHERE YEAR(CRE_DTE) = $year
					AND MONTH(CRE_DTE) = $month
					GROUP BY `imo`.`itemIndex`
					) AS  `tb_movement_y`
					ON  `i_movement`. `itemIndex` =  `tb_movement_y`.`sIndex`
					AND `i_movement`.`CRE_DTE` = `tb_movement_y`.`MAXDate`
					ORDER BY `i_movement`.`itemIndex`) AS `tb_move` ON `tb_move`.`iIndex` = `tb_i`.`itemIndex`
		LEFT JOIN(
		SELECT
		`itemIndex` , `actionType`,
		IF(actionType LIKE 'IN%','สถานะเข้า','สถานะออก') as 'status',
		IF(actionType LIKE 'IN%',`stockQTY` - `QTY`,`stockQTY` + `QTY`) as 'startQTY'
		FROM `itemmovementview` as `i_movement`
			INNER JOIN
			(
			SELECT MIN(CRE_DTE) as MINDate , `imo`.`itemIndex` as sIndex
			FROM `itemmovementview` as `imo`
		WHERE YEAR(CRE_DTE) = $year
			AND MONTH(CRE_DTE) = $month
			GROUP BY `imo`.`itemIndex`
			) AS  `tb_movement_y`
			ON  `i_movement`. `itemIndex` =  `tb_movement_y`.`sIndex`
			AND `i_movement`.`CRE_DTE` = `tb_movement_y`.`MINDate`
		ORDER BY `i_movement`.`itemIndex`) as `tb_startQTY` ON `tb_startQTY`.`itemIndex` = `tb_i`.`itemIndex`
		");
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		// Empty array
		$rows = array();

		// Bind Data
		mysqli_stmt_bind_result($stmt,
		$row->itemIndex,
		$row->itemID,
		$row->itemName,
		$row->startQTY,
		$row->sum_inQTY,
		$row->sum_saleQTY,
		$row->remainQTY
		);

		// Retrive Data
		while(mysqli_stmt_fetch($stmt)){
			$rows[] = $row;
			$row = new stdClass(); /* Empty object of Dynamic Class*/
			mysqli_stmt_bind_result($stmt,
			$row->itemIndex,
			$row->itemID,
			$row->itemName,
			$row->startQTY,
			$row->sum_inQTY,
			$row->sum_saleQTY,
			$row->remainQTY
		);
		}

		mysqli_stmt_free_result($stmt);
		mysqli_close($this->connection);
		return $rows;
	}

	public function get_flavorReportUsedRangeDate($beforeDate,$afterDate){
		$stmt = mysqli_prepare($this->connection,
		"	SELECT (@row_number:=@row_number + 1) as `rowNumber`
			,`s_o`.`name` as `flavorName`
			, sum(`s_o`.`saleQTY`) as `total_used`
			,`s_o`.`saleClass`
			,`s_o`.`itemIndex`
			FROM `salelist_opt` as `s_o`
			cross join (select @row_number:=0) as s
			where DATE(`s_o`.`CRE_DTE`) between date('$beforeDate') AND date('$afterDate')
			and `saleClass` = 'Fl'
			group by `flavorName`
			order by `rowNumber`
			;"
		);
		$this->throwExceptionOnError();

		// Execute SQL stmt
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		// Empty array
		$rows = array();

		// Bind Data
		mysqli_stmt_bind_result($stmt
			, $row->rowNumber
			, $row->flavorName
			, $row->total_used
			, $row->saleClass
			, $row->itemIndex
		);

		// Retrive Data
		while(mysqli_stmt_fetch($stmt)){
			$rows[] = $row;
			$row = new stdClass(); // Empty object of Dynamic class

			mysqli_stmt_bind_result($stmt
				, $row->rowNumber
				, $row->flavorName
				, $row->total_used
				, $row->saleClass
				, $row->itemIndex
			);
		}

		mysqli_stmt_free_result($stmt);
		mysqli_close($this->connection);
		return $rows;
	}
}

?>
