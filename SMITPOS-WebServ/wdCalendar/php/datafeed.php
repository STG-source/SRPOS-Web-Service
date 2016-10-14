<?php
require_once '../../zendframework/library/Zend/Date/DateObject.php';
include_once("dbconfig.php");
include_once("functions.php");
include_once("../../SMITPOS/services/ScustomerService.php");
include_once("../../SMITPOS/services/SccrrbaseService.php");

function addCalendar($st, $et, $sub, $ade){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "insert into `jqcalendar` (`subject`, `starttime`, `endtime`, `isalldayevent`) values ('"
      .mysql_real_escape_string($sub)."', '"
      .php2MySqlTime(js2PhpTime($st))."', '"
      .php2MySqlTime(js2PhpTime($et))."', '"
      .mysql_real_escape_string($ade)."' )";
    //echo($sql);
		if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'add success';
      $ret['Data'] = mysql_insert_id();
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}


function addDetailedCalendar($st, $et, $sub, $ade, $dscr, $loc, $color, $tz){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "insert into `jqcalendar` (`subject`, `starttime`, `endtime`, `isalldayevent`, `description`, `location`, `color`) values ('"
      .mysql_real_escape_string($sub)."', '"
      .php2MySqlTime(js2PhpTime($st))."', '"
      .php2MySqlTime(js2PhpTime($et))."', '"
      .mysql_real_escape_string($ade)."', '"
      .mysql_real_escape_string($dscr)."', '"
      .mysql_real_escape_string($loc)."', '"
      .mysql_real_escape_string($color)."' )";
    //echo($sql);
		if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'add success';
      $ret['Data'] = mysql_insert_id();
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

function listCalendarByRange($sd, $ed){
  $ret = array();
  $ret['events'] = array();
  $ret["issort"] =true;
  $ret["start"] = php2JsTime($sd);
  $ret["end"] = php2JsTime($ed);
  $ret['error'] = null;
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "select * from `jqcalendar` where `starttime` between '"
      .php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."' ORDER BY starttime ASC";
    $handle = mysql_query($sql);
    //echo $sql;
    while ($row = mysql_fetch_object($handle)) {
      //$ret['events'][] = $row;
      //$attends = $row->AttendeeNames;
      //if($row->OtherAttendee){
      //  $attends .= $row->OtherAttendee;
      //}
      //echo $row->StartTime;
      $ret['events'][] = array(
        $row->Id,
        $row->Subject,
        php2JsTime(mySql2PhpTime($row->StartTime)),
        php2JsTime(mySql2PhpTime($row->EndTime)),
        $row->IsAllDayEvent,
        ($row->IsAllDayEvent!=1 && date("Y-m-d",mySql2PhpTime($row->EndTime))>date("Y-m-d",mySql2PhpTime($row->StartTime))?1:0), //more than one day event
        //$row->InstanceType,
        0,//Recurring event,
        $row->Color,
        1,//editable
        $row->Location, 
        ''//$attends
      );
    }
	}catch(Exception $e){
     $ret['error'] = $e->getMessage();
  }
  return $ret;
}

function listCalendar($day, $type){
  $phpTime = js2PhpTime($day);
  //echo $phpTime . "+" . $type;
  switch($type){
    case "month":
      $st = mktime(0, 0, 0, date("m", $phpTime), 1, date("Y", $phpTime));
      $et = mktime(0, 0, -1, date("m", $phpTime)+1, 1, date("Y", $phpTime));
      break;
    case "week":
      //suppose first day of a week is monday 
      $monday  =  date("d", $phpTime) - date('N', $phpTime) + 1;
      //echo date('N', $phpTime);
      $st = mktime(0,0,0,date("m", $phpTime), $monday, date("Y", $phpTime));
      $et = mktime(0,0,-1,date("m", $phpTime), $monday+7, date("Y", $phpTime));
      break;
    case "day":
      $st = mktime(0, 0, 0, date("m", $phpTime), date("d", $phpTime), date("Y", $phpTime));
      $et = mktime(0, 0, -1, date("m", $phpTime), date("d", $phpTime)+1, date("Y", $phpTime));
      break;
  }
  //echo $st . "--" . $et;
  return listCalendarByRange($st, $et);
}

function updateCalendar($id, $st, $et){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "update `jqcalendar` set"
      . " `starttime`='" . php2MySqlTime(js2PhpTime($st)) . "', "
      . " `endtime`='" . php2MySqlTime(js2PhpTime($et)) . "' "
      . "where `id`=" . $id;
    //echo $sql;
		if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

function updateDetailedCalendar($id, $st, $et, $sub, $ade, $dscr, $loc, $color, $tz){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "update `jqcalendar` set"
      . " `starttime`='" . php2MySqlTime(js2PhpTime($st)) . "', "
      . " `endtime`='" . php2MySqlTime(js2PhpTime($et)) . "', "
      . " `subject`='" . mysql_real_escape_string($sub) . "', "
      . " `isalldayevent`='" . mysql_real_escape_string($ade) . "', "
      . " `description`='" . mysql_real_escape_string($dscr) . "', "
      . " `location`='" . mysql_real_escape_string($loc) . "', "
      . " `color`='" . mysql_real_escape_string($color) . "' "
      . "where `id`=" . $id;
    //echo $sql;
		if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
	  $ret['Data'] = $id;
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

function removeCalendar($id){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "delete from `jqcalendar` where `id`=" . $id;
		if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

/****** Save Customer ********/
function fncSaveCustomer(){
	$objCustomer = new ScustomerService();
	// structure Customer
	$customer_ID = $objCustomer->create_customer($Item);
	return $customer_ID;
}

header('Content-type:text/javascript;charset=UTF-8');
$method = $_GET["method"];
switch ($method) {
    case "add":
        $ret = addCalendar($_POST["CalendarStartTime"], $_POST["CalendarEndTime"], $_POST["CalendarTitle"], $_POST["IsAllDayEvent"]);
        break;
    case "list":
        $ret = listCalendar($_POST["showdate"], $_POST["viewtype"]);
        break;
    case "update":
        $ret = updateCalendar($_POST["calendarId"], $_POST["CalendarStartTime"], $_POST["CalendarEndTime"]);
        break; 
    case "remove":
        $ret = removeCalendar( $_POST["calendarId"]);
        break;
    case "adddetails":
        $st = $_POST["stpartdate"] . " " . $_POST["stparttime"];
		//echo $_POST["stpartdate"];
        $et = $_POST["etpartdate"] . " " . $_POST["etparttime"];
        if(isset($_GET["id"])){
			// Edit
            $ret = updateDetailedCalendar($_GET["id"], $st, $et, 
                $_POST["Subject"], isset($_POST["IsAllDayEvent"])?1:0, $_POST["Description"], 
                $_POST["Location"], $_POST["colorvalue"], $_POST["timezone"]);
				
				$Calendar_ID = $_GET["id"];
        }else{
			// Add New Calendar
			$Calendar_ID = null;
            $ret = addDetailedCalendar($st, $et,                    
                $_POST["Subject"], isset($_POST["IsAllDayEvent"])?1:0, $_POST["Description"], 
                $_POST["Location"], $_POST["colorvalue"], $_POST["timezone"]);
				
				if($ret['IsSuccess'] == true){
					// get ID Calendar
					$Calendar_ID = $ret['Data'];
				}
				
        }   
		
		/// Check CitizenID
		if(isset($_POST["CitizenID"])){
			// Check Customer 
			$objCustomer = new ScustomerService();
			$Customer_ID = $objCustomer->get_customerIDByCitizenID($_POST["CitizenID"]);
			if($Customer_ID  == null){
				// create New Customer
				$item = new stdClass();	
				$item->fullname = $_POST["Name"]; 
				$item->address = ""; 
				$item->city = "";
				$item->province = "";
				$item->postcode = "";
				$item->phone = $_POST["Telephone"];
				$item->email = $_POST["Email"];
				$item->customerClass = "";
				$item->customerType = ""; 
				$item->customerAVP = "";
				$item->customerPoint = ""; 
				$item->citizenID  = $_POST["CitizenID"];
				$item->passportID = "";
				$item->title = "";
				$item->cellPhone = "";
				$item->fax = "";
				$mydate=getdate(date("U"));
				$item->CRE_DTE = new Zend_Date($mydate['month'].' '.$mydate['mday'].', '.$mydate['year'], 'MM.dd.yyyy'); 
				$item->CRE_USR = ""; 
				$item->UPD_DTE = new Zend_Date($mydate['month'].' '.$mydate['mday'].', '.$mydate['year'], 'MM.dd.yyyy'); 
				$item->DEL_DTE = new Zend_Date($mydate['month'].' '.$mydate['mday'].', '.$mydate['year'], 'MM.dd.yyyy');
			
				$Customer_ID = $objCustomer->create_newCustomer($item);
			}
				
			// Save _ccrr_Base
			
			if($Customer_ID <> null and $Calendar_ID <> null){

					// get list index ของ ccrr_Base
					//คำนวนเวลาเริ่มต้น สิ้นสุด เป็น วินาที ลง reserveDuration
					$_cls_CCRR_obj = new SccrrbaseService();
					$listIndex = $_cls_CCRR_obj->fncGetListIndexBy_CustomerID_CalendarID($Customer_ID,$Calendar_ID);
					
					
					$row = new stdClass();		
					$row->listIndex = $listIndex;
					$row->saleNo = ""; // รหัสการขาย
					$row->CWS_index = "";
					$row->serviceUserID = "";
					$row->cardID = ""; // เลขบัตร ผ่านประตู 
					$row->reserveDuration = 3; // คำนวน ตามเวลาเริ่มต้น สิ้นสุด เป็นวินาที
					$row->CHKIN_DTE = new Zend_Date($st, 'MM.dd.yyyy HH:mm:ss');
					$row->CHKOUT_DTE =new Zend_Date($et, 'MM.dd.yyyy HH:mm:ss');
					$row->CHKOUT_ROLL = 0;
					$row->CHKOUT_saleNo = 0;
					$row->spentDuration = 0;
					$row->CRE_USR = "";
					$mydate=getdate(date("U"));
					$row->CRE_DTE =new Zend_Date($mydate['month'].' '.$mydate['mday'].', '.$mydate['year'], 'MM.dd.yyyy');
					$row->UPD_USR = "";
					$row->UPD_DTE =new Zend_Date($mydate['month'].' '.$mydate['mday'].', '.$mydate['year'], 'MM.dd.yyyy');
					$row->DEL_USR = "";
					$row->DEL_DTE =new Zend_Date($mydate['month'].' '.$mydate['mday'].', '.$mydate['year'], 'MM.dd.yyyy');
					$row->Note = "";
					$row->customerID = $Customer_ID;
					$row->calendarID = $Calendar_ID;
				
					if($listIndex == ""){
						// Create _CCRR_BASE Record
						$_cls_CCRR_obj->create_ccrr_base_own($row);
					}else{
						// Update _CCRR_BASE Record
						$_cls_CCRR_obj->update_ccrr_base($row);	
					}
					
					
			}
			
			
		}
		
		     
        break; 


}
echo json_encode($ret); 



?>