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
class UserinfoService {

	var $username = "root";
	var $password = "";
	var $server = "localhost";
	var $port = "83306";
	var $databasename = "zkeco_db";
	var $tablename = "userinfo";

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
	public function getAllUserinfo() {

		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->change_operator, $row->change_time, $row->create_operator, $row->create_time, $row->delete_operator, $row->delete_time, $row->status, $row->userid, $row->badgenumber, $row->defaultdeptid, $row->name, $row->lastname, $row->Password, $row->Card, $row->card_number, $row->site_code, $row->card_number_type, $row->Privilege, $row->AccGroup, $row->TimeZones, $row->Gender, $row->Birthday, $row->street, $row->zip, $row->ophone, $row->FPHONE, $row->pager, $row->minzu, $row->title, $row->SSN, $row->identitycard, $row->UTime, $row->Hiredday, $row->VERIFICATIONMETHOD, $row->State, $row->City, $row->Education, $row->SECURITYFLAGS, $row->ATT, $row->OverTime, $row->Holiday, $row->INLATE, $row->OutEarly, $row->Lunchduration, $row->MVerifyPass, $row->photo, $row->SEP, $row->OffDuty, $row->DelTag, $row->AutoSchPlan, $row->MinAutoSchInterval, $row->RegisterOT, $row->morecard_group_id, $row->set_valid_time, $row->acc_startdate, $row->acc_enddate, $row->acc_super_auth, $row->ele_super_auth, $row->birthplace, $row->Political, $row->contry, $row->hiretype, $row->email, $row->firedate, $row->isatt, $row->homeaddress, $row->emptype, $row->bankcode1, $row->bankcode2, $row->isblacklist, $row->delayed_door_open, $row->extend_time, $row->Iuser1, $row->Iuser2, $row->Iuser3, $row->Iuser4, $row->Iuser5, $row->Cuser1, $row->Cuser2, $row->Cuser3, $row->Cuser4, $row->Cuser5, $row->Duser1, $row->Duser2, $row->Duser3, $row->Duser4, $row->Duser5, $row->selfpassword);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->change_time = new DateTime($row->change_time);
	      $row->create_time = new DateTime($row->create_time);
	      $row->delete_time = new DateTime($row->delete_time);
	      $row->Birthday = new DateTime($row->Birthday);
	      $row->UTime = new DateTime($row->UTime);
	      $row->Hiredday = new DateTime($row->Hiredday);
	      $row->acc_startdate = new DateTime($row->acc_startdate);
	      $row->acc_enddate = new DateTime($row->acc_enddate);
	      $row->firedate = new DateTime($row->firedate);
	      $row->Duser1 = new DateTime($row->Duser1);
	      $row->Duser2 = new DateTime($row->Duser2);
	      $row->Duser3 = new DateTime($row->Duser3);
	      $row->Duser4 = new DateTime($row->Duser4);
	      $row->Duser5 = new DateTime($row->Duser5);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->change_operator, $row->change_time, $row->create_operator, $row->create_time, $row->delete_operator, $row->delete_time, $row->status, $row->userid, $row->badgenumber, $row->defaultdeptid, $row->name, $row->lastname, $row->Password, $row->Card, $row->card_number, $row->site_code, $row->card_number_type, $row->Privilege, $row->AccGroup, $row->TimeZones, $row->Gender, $row->Birthday, $row->street, $row->zip, $row->ophone, $row->FPHONE, $row->pager, $row->minzu, $row->title, $row->SSN, $row->identitycard, $row->UTime, $row->Hiredday, $row->VERIFICATIONMETHOD, $row->State, $row->City, $row->Education, $row->SECURITYFLAGS, $row->ATT, $row->OverTime, $row->Holiday, $row->INLATE, $row->OutEarly, $row->Lunchduration, $row->MVerifyPass, $row->photo, $row->SEP, $row->OffDuty, $row->DelTag, $row->AutoSchPlan, $row->MinAutoSchInterval, $row->RegisterOT, $row->morecard_group_id, $row->set_valid_time, $row->acc_startdate, $row->acc_enddate, $row->acc_super_auth, $row->ele_super_auth, $row->birthplace, $row->Political, $row->contry, $row->hiretype, $row->email, $row->firedate, $row->isatt, $row->homeaddress, $row->emptype, $row->bankcode1, $row->bankcode2, $row->isblacklist, $row->delayed_door_open, $row->extend_time, $row->Iuser1, $row->Iuser2, $row->Iuser3, $row->Iuser4, $row->Iuser5, $row->Cuser1, $row->Cuser2, $row->Cuser3, $row->Cuser4, $row->Cuser5, $row->Duser1, $row->Duser2, $row->Duser3, $row->Duser4, $row->Duser5, $row->selfpassword);
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
	public function getUserinfoByID($itemID) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename where userid=?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'i', $itemID);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_result($stmt, $row->change_operator, $row->change_time, $row->create_operator, $row->create_time, $row->delete_operator, $row->delete_time, $row->status, $row->userid, $row->badgenumber, $row->defaultdeptid, $row->name, $row->lastname, $row->Password, $row->Card, $row->card_number, $row->site_code, $row->card_number_type, $row->Privilege, $row->AccGroup, $row->TimeZones, $row->Gender, $row->Birthday, $row->street, $row->zip, $row->ophone, $row->FPHONE, $row->pager, $row->minzu, $row->title, $row->SSN, $row->identitycard, $row->UTime, $row->Hiredday, $row->VERIFICATIONMETHOD, $row->State, $row->City, $row->Education, $row->SECURITYFLAGS, $row->ATT, $row->OverTime, $row->Holiday, $row->INLATE, $row->OutEarly, $row->Lunchduration, $row->MVerifyPass, $row->photo, $row->SEP, $row->OffDuty, $row->DelTag, $row->AutoSchPlan, $row->MinAutoSchInterval, $row->RegisterOT, $row->morecard_group_id, $row->set_valid_time, $row->acc_startdate, $row->acc_enddate, $row->acc_super_auth, $row->ele_super_auth, $row->birthplace, $row->Political, $row->contry, $row->hiretype, $row->email, $row->firedate, $row->isatt, $row->homeaddress, $row->emptype, $row->bankcode1, $row->bankcode2, $row->isblacklist, $row->delayed_door_open, $row->extend_time, $row->Iuser1, $row->Iuser2, $row->Iuser3, $row->Iuser4, $row->Iuser5, $row->Cuser1, $row->Cuser2, $row->Cuser3, $row->Cuser4, $row->Cuser5, $row->Duser1, $row->Duser2, $row->Duser3, $row->Duser4, $row->Duser5, $row->selfpassword);
		
		if(mysqli_stmt_fetch($stmt)) {
	      $row->change_time = new DateTime($row->change_time);
	      $row->create_time = new DateTime($row->create_time);
	      $row->delete_time = new DateTime($row->delete_time);
	      $row->Birthday = new DateTime($row->Birthday);
	      $row->UTime = new DateTime($row->UTime);
	      $row->Hiredday = new DateTime($row->Hiredday);
	      $row->acc_startdate = new DateTime($row->acc_startdate);
	      $row->acc_enddate = new DateTime($row->acc_enddate);
	      $row->firedate = new DateTime($row->firedate);
	      $row->Duser1 = new DateTime($row->Duser1);
	      $row->Duser2 = new DateTime($row->Duser2);
	      $row->Duser3 = new DateTime($row->Duser3);
	      $row->Duser4 = new DateTime($row->Duser4);
	      $row->Duser5 = new DateTime($row->Duser5);
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
	public function createUserinfo($item) {

		$stmt = mysqli_prepare($this->connection, "INSERT INTO $this->tablename (change_operator, change_time, create_operator, create_time, delete_operator, delete_time, status, badgenumber, defaultdeptid, name, lastname, Password, Card, card_number, site_code, card_number_type, Privilege, AccGroup, TimeZones, Gender, Birthday, street, zip, ophone, FPHONE, pager, minzu, title, SSN, identitycard, UTime, Hiredday, VERIFICATIONMETHOD, State, City, Education, SECURITYFLAGS, ATT, OverTime, Holiday, INLATE, OutEarly, Lunchduration, MVerifyPass, photo, SEP, OffDuty, DelTag, AutoSchPlan, MinAutoSchInterval, RegisterOT, morecard_group_id, set_valid_time, acc_startdate, acc_enddate, acc_super_auth, ele_super_auth, birthplace, Political, contry, hiretype, email, firedate, isatt, homeaddress, emptype, bankcode1, bankcode2, isblacklist, delayed_door_open, extend_time, Iuser1, Iuser2, Iuser3, Iuser4, Iuser5, Cuser1, Cuser2, Cuser3, Cuser4, Cuser5, Duser1, Duser2, Duser3, Duser4, Duser5, selfpassword) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->throwExceptionOnError();

		mysqli_stmt_bind_param($stmt, 'ssssssisissssssiiissssssssssssssisssiiiiiiissiiiiiiiissiisssissisissiiiiiiiisssssssssss', $item->change_operator, $item->change_time->toString('YYYY-MM-dd HH:mm:ss'), $item->create_operator, $item->create_time->toString('YYYY-MM-dd HH:mm:ss'), $item->delete_operator, $item->delete_time->toString('YYYY-MM-dd HH:mm:ss'), $item->status, $item->badgenumber, $item->defaultdeptid, $item->name, $item->lastname, $item->Password, $item->Card, $item->card_number, $item->site_code, $item->card_number_type, $item->Privilege, $item->AccGroup, $item->TimeZones, $item->Gender, $item->Birthday->toString('YYYY-MM-dd HH:mm:ss'), $item->street, $item->zip, $item->ophone, $item->FPHONE, $item->pager, $item->minzu, $item->title, $item->SSN, $item->identitycard, $item->UTime->toString('YYYY-MM-dd HH:mm:ss'), $item->Hiredday->toString('YYYY-MM-dd HH:mm:ss'), $item->VERIFICATIONMETHOD, $item->State, $item->City, $item->Education, $item->SECURITYFLAGS, $item->ATT, $item->OverTime, $item->Holiday, $item->INLATE, $item->OutEarly, $item->Lunchduration, $item->MVerifyPass, $item->photo, $item->SEP, $item->OffDuty, $item->DelTag, $item->AutoSchPlan, $item->MinAutoSchInterval, $item->RegisterOT, $item->morecard_group_id, $item->set_valid_time, $item->acc_startdate->toString('YYYY-MM-dd HH:mm:ss'), $item->acc_enddate->toString('YYYY-MM-dd HH:mm:ss'), $item->acc_super_auth, $item->ele_super_auth, $item->birthplace, $item->Political, $item->contry, $item->hiretype, $item->email, $item->firedate->toString('YYYY-MM-dd HH:mm:ss'), $item->isatt, $item->homeaddress, $item->emptype, $item->bankcode1, $item->bankcode2, $item->isblacklist, $item->delayed_door_open, $item->extend_time, $item->Iuser1, $item->Iuser2, $item->Iuser3, $item->Iuser4, $item->Iuser5, $item->Cuser1, $item->Cuser2, $item->Cuser3, $item->Cuser4, $item->Cuser5, $item->Duser1->toString('YYYY-MM-dd HH:mm:ss'), $item->Duser2->toString('YYYY-MM-dd HH:mm:ss'), $item->Duser3->toString('YYYY-MM-dd HH:mm:ss'), $item->Duser4->toString('YYYY-MM-dd HH:mm:ss'), $item->Duser5->toString('YYYY-MM-dd HH:mm:ss'), $item->selfpassword);
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
	public function updateUserinfo($item) {
	
		$stmt = mysqli_prepare($this->connection, "UPDATE $this->tablename SET change_operator=?, change_time=?, create_operator=?, create_time=?, delete_operator=?, delete_time=?, status=?, badgenumber=?, defaultdeptid=?, name=?, lastname=?, Password=?, Card=?, card_number=?, site_code=?, card_number_type=?, Privilege=?, AccGroup=?, TimeZones=?, Gender=?, Birthday=?, street=?, zip=?, ophone=?, FPHONE=?, pager=?, minzu=?, title=?, SSN=?, identitycard=?, UTime=?, Hiredday=?, VERIFICATIONMETHOD=?, State=?, City=?, Education=?, SECURITYFLAGS=?, ATT=?, OverTime=?, Holiday=?, INLATE=?, OutEarly=?, Lunchduration=?, MVerifyPass=?, photo=?, SEP=?, OffDuty=?, DelTag=?, AutoSchPlan=?, MinAutoSchInterval=?, RegisterOT=?, morecard_group_id=?, set_valid_time=?, acc_startdate=?, acc_enddate=?, acc_super_auth=?, ele_super_auth=?, birthplace=?, Political=?, contry=?, hiretype=?, email=?, firedate=?, isatt=?, homeaddress=?, emptype=?, bankcode1=?, bankcode2=?, isblacklist=?, delayed_door_open=?, extend_time=?, Iuser1=?, Iuser2=?, Iuser3=?, Iuser4=?, Iuser5=?, Cuser1=?, Cuser2=?, Cuser3=?, Cuser4=?, Cuser5=?, Duser1=?, Duser2=?, Duser3=?, Duser4=?, Duser5=?, selfpassword=? WHERE userid=?");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ssssssisissssssiiissssssssssssssisssiiiiiiissiiiiiiiissiisssissisissiiiiiiiisssssssssssi', $item->change_operator, $item->change_time->toString('YYYY-MM-dd HH:mm:ss'), $item->create_operator, $item->create_time->toString('YYYY-MM-dd HH:mm:ss'), $item->delete_operator, $item->delete_time->toString('YYYY-MM-dd HH:mm:ss'), $item->status, $item->badgenumber, $item->defaultdeptid, $item->name, $item->lastname, $item->Password, $item->Card, $item->card_number, $item->site_code, $item->card_number_type, $item->Privilege, $item->AccGroup, $item->TimeZones, $item->Gender, $item->Birthday->toString('YYYY-MM-dd HH:mm:ss'), $item->street, $item->zip, $item->ophone, $item->FPHONE, $item->pager, $item->minzu, $item->title, $item->SSN, $item->identitycard, $item->UTime->toString('YYYY-MM-dd HH:mm:ss'), $item->Hiredday->toString('YYYY-MM-dd HH:mm:ss'), $item->VERIFICATIONMETHOD, $item->State, $item->City, $item->Education, $item->SECURITYFLAGS, $item->ATT, $item->OverTime, $item->Holiday, $item->INLATE, $item->OutEarly, $item->Lunchduration, $item->MVerifyPass, $item->photo, $item->SEP, $item->OffDuty, $item->DelTag, $item->AutoSchPlan, $item->MinAutoSchInterval, $item->RegisterOT, $item->morecard_group_id, $item->set_valid_time, $item->acc_startdate->toString('YYYY-MM-dd HH:mm:ss'), $item->acc_enddate->toString('YYYY-MM-dd HH:mm:ss'), $item->acc_super_auth, $item->ele_super_auth, $item->birthplace, $item->Political, $item->contry, $item->hiretype, $item->email, $item->firedate->toString('YYYY-MM-dd HH:mm:ss'), $item->isatt, $item->homeaddress, $item->emptype, $item->bankcode1, $item->bankcode2, $item->isblacklist, $item->delayed_door_open, $item->extend_time, $item->Iuser1, $item->Iuser2, $item->Iuser3, $item->Iuser4, $item->Iuser5, $item->Cuser1, $item->Cuser2, $item->Cuser3, $item->Cuser4, $item->Cuser5, $item->Duser1->toString('YYYY-MM-dd HH:mm:ss'), $item->Duser2->toString('YYYY-MM-dd HH:mm:ss'), $item->Duser3->toString('YYYY-MM-dd HH:mm:ss'), $item->Duser4->toString('YYYY-MM-dd HH:mm:ss'), $item->Duser5->toString('YYYY-MM-dd HH:mm:ss'), $item->selfpassword, $item->userid);		
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
	public function deleteUserinfo($itemID) {
				
		$stmt = mysqli_prepare($this->connection, "DELETE FROM $this->tablename WHERE userid = ?");
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
	public function getUserinfo_paged($startIndex, $numItems) {
		
		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename LIMIT ?, ?");
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_param($stmt, 'ii', $startIndex, $numItems);
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->change_operator, $row->change_time, $row->create_operator, $row->create_time, $row->delete_operator, $row->delete_time, $row->status, $row->userid, $row->badgenumber, $row->defaultdeptid, $row->name, $row->lastname, $row->Password, $row->Card, $row->card_number, $row->site_code, $row->card_number_type, $row->Privilege, $row->AccGroup, $row->TimeZones, $row->Gender, $row->Birthday, $row->street, $row->zip, $row->ophone, $row->FPHONE, $row->pager, $row->minzu, $row->title, $row->SSN, $row->identitycard, $row->UTime, $row->Hiredday, $row->VERIFICATIONMETHOD, $row->State, $row->City, $row->Education, $row->SECURITYFLAGS, $row->ATT, $row->OverTime, $row->Holiday, $row->INLATE, $row->OutEarly, $row->Lunchduration, $row->MVerifyPass, $row->photo, $row->SEP, $row->OffDuty, $row->DelTag, $row->AutoSchPlan, $row->MinAutoSchInterval, $row->RegisterOT, $row->morecard_group_id, $row->set_valid_time, $row->acc_startdate, $row->acc_enddate, $row->acc_super_auth, $row->ele_super_auth, $row->birthplace, $row->Political, $row->contry, $row->hiretype, $row->email, $row->firedate, $row->isatt, $row->homeaddress, $row->emptype, $row->bankcode1, $row->bankcode2, $row->isblacklist, $row->delayed_door_open, $row->extend_time, $row->Iuser1, $row->Iuser2, $row->Iuser3, $row->Iuser4, $row->Iuser5, $row->Cuser1, $row->Cuser2, $row->Cuser3, $row->Cuser4, $row->Cuser5, $row->Duser1, $row->Duser2, $row->Duser3, $row->Duser4, $row->Duser5, $row->selfpassword);
		
	    while (mysqli_stmt_fetch($stmt)) {
	      $row->change_time = new DateTime($row->change_time);
	      $row->create_time = new DateTime($row->create_time);
	      $row->delete_time = new DateTime($row->delete_time);
	      $row->Birthday = new DateTime($row->Birthday);
	      $row->UTime = new DateTime($row->UTime);
	      $row->Hiredday = new DateTime($row->Hiredday);
	      $row->acc_startdate = new DateTime($row->acc_startdate);
	      $row->acc_enddate = new DateTime($row->acc_enddate);
	      $row->firedate = new DateTime($row->firedate);
	      $row->Duser1 = new DateTime($row->Duser1);
	      $row->Duser2 = new DateTime($row->Duser2);
	      $row->Duser3 = new DateTime($row->Duser3);
	      $row->Duser4 = new DateTime($row->Duser4);
	      $row->Duser5 = new DateTime($row->Duser5);
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->change_operator, $row->change_time, $row->create_operator, $row->create_time, $row->delete_operator, $row->delete_time, $row->status, $row->userid, $row->badgenumber, $row->defaultdeptid, $row->name, $row->lastname, $row->Password, $row->Card, $row->card_number, $row->site_code, $row->card_number_type, $row->Privilege, $row->AccGroup, $row->TimeZones, $row->Gender, $row->Birthday, $row->street, $row->zip, $row->ophone, $row->FPHONE, $row->pager, $row->minzu, $row->title, $row->SSN, $row->identitycard, $row->UTime, $row->Hiredday, $row->VERIFICATIONMETHOD, $row->State, $row->City, $row->Education, $row->SECURITYFLAGS, $row->ATT, $row->OverTime, $row->Holiday, $row->INLATE, $row->OutEarly, $row->Lunchduration, $row->MVerifyPass, $row->photo, $row->SEP, $row->OffDuty, $row->DelTag, $row->AutoSchPlan, $row->MinAutoSchInterval, $row->RegisterOT, $row->morecard_group_id, $row->set_valid_time, $row->acc_startdate, $row->acc_enddate, $row->acc_super_auth, $row->ele_super_auth, $row->birthplace, $row->Political, $row->contry, $row->hiretype, $row->email, $row->firedate, $row->isatt, $row->homeaddress, $row->emptype, $row->bankcode1, $row->bankcode2, $row->isblacklist, $row->delayed_door_open, $row->extend_time, $row->Iuser1, $row->Iuser2, $row->Iuser3, $row->Iuser4, $row->Iuser5, $row->Cuser1, $row->Cuser2, $row->Cuser3, $row->Cuser4, $row->Cuser5, $row->Duser1, $row->Duser2, $row->Duser3, $row->Duser4, $row->Duser5, $row->selfpassword);
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
	public function getUserAccessLevel_byCardID($cardID) {
		$sql_query_field = "SELECT j.userid as userid, v.acclevelset_id as acclevelset_id, v.id as set_id, j.badgenumber as badgenumber, j.status as status, j.defaultdeptid as defaultdeptid, j.name as name, j.lastname as lastname, j.identitycard as identitycard, j.Gender as Gender, j.hiretype as hiretype, j.card_number_type as card_number_type, j.emptype as emptype, j.site_code as site_code, j.Card as Card, j.card_number as card_number, j.FPHONE as FPHONE, j.Password as Password, j.ophone as ophone, j.Birthday as Birthday, j.email as email, j.OverTime as OverTime, j.Hiredday as Hiredday, j.Privilege as Privilege, j.homeaddress as homeaddress,  j.selfpassword as selfpassword, j.acc_super_auth as acc_super_auth, j.ele_super_auth as ele_super_auth, j.set_valid_time as set_valid_time, j.acc_startdate as acc_startdate, j.acc_enddate as acc_enddate, j.morecard_group_id as morecard_group_id from zkeco_db.userinfo j join zkeco_db.acc_levelset_emp v";
		
		/**
		* [TBC] Remain Fields of userinfo table
		* 
		* AccGroup, TimeZones, street, zip, pager, minzu, title, SSN, UTime, 
		* VERIFICATIONMETHOD, State, City, Education, SECURITYFLAGS, ATT, Holiday, INLATE, OutEarly, Lunchduration, MVerifyPass, photo, SEP, OffDuty, DelTag, AutoSchPlan, MinAutoSchInterval, RegisterOT, birthplace, Political, contry, firedate, isatt,
		**/
		
		$sql_where = "where j.userid = v.employee_id";
		$sql_order = "order by j.userid";
		
		$sql_query_field .= " {$sql_where} ";
		//if ($cardID != null)||($cardID != "")
		if ($cardID != null)
			$sql_query_field .= " AND j.Card = {$cardID} ";
		$sql_query_field .= $sql_order;
		
		$stmt = mysqli_prepare($this->connection, $sql_query_field);
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->userid, $row->acclevelset_id, $row->set_id, $row->badgenumber, $row->status, $row->defaultdeptid, $row->name, $row->lastname, $row->identitycard, $row->Gender, $row->hiretype, $row->card_number_type, $row->emptype, $row->site_code, $row->Card, $row->card_number, $row->FPHONE, $row->Password, $row->ophone, $row->Birthday, $row->email, $row->OverTime, $row->Hiredday, $row->Privilege, $row->homeaddress,  $row->selfpassword, $row->acc_super_auth, $row->ele_super_auth, $row->set_valid_time, $row->acc_startdate, $row->acc_enddate, $row->morecard_group_id);
		
		while (mysqli_stmt_fetch($stmt)) {
			$rows[] = $row;
			$row = new stdClass();
			mysqli_stmt_bind_result($stmt, $row->userid, $row->acclevelset_id, $row->set_id, $row->badgenumber, $row->status, $row->defaultdeptid, $row->name, $row->lastname, $row->identitycard, $row->Gender, $row->hiretype, $row->card_number_type, $row->emptype, $row->site_code, $row->Card, $row->card_number, $row->FPHONE, $row->Password, $row->ophone, $row->Birthday, $row->email, $row->OverTime, $row->Hiredday, $row->Privilege, $row->homeaddress,  $row->selfpassword, $row->acc_super_auth, $row->ele_super_auth, $row->set_valid_time, $row->acc_startdate, $row->acc_enddate, $row->morecard_group_id);
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
