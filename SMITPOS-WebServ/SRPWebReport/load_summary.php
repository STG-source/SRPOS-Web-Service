<?php
	error_reporting(E_ALL & ~E_NOTICE);
	header('content-type: application/json; charset=utf-8');
	include("cfg.inc.php");
	
// Input Result
if(isset($_POST['startDate']) && isset($_POST['endDate'])){
	$dateForm = $_POST['startDate'];
	$dateTo = $_POST['endDate'];
	/*
	// for test
	$dateForm = '2014-05-18';
	$dateTo = '2014-06-25';
	*/
	$connection = mysqli_connect(
		$CFG['DBhost'],
		$CFG['DBusername'],
		$CFG['DBpassword'],
		$CFG['DBname'],
		$CFG['DBport']
	);
	
	mysqli_query($connection, "SET NAMES 'utf8'");

	$dateForm = mysqli_real_escape_string($connection, $dateForm);
	$dateTo = mysqli_real_escape_string($connection, $dateTo);
	$maxDate = new DateTime($dateTo);
	
	// Select SaleDetail and SaleList
	$sqlQueryDate = "`s`.`CRE_DTE`";
	$sqlQueryDate2 = "`sl`.`CRE_DTE`";
	if($sqlFixTimezone){
		$sqlQueryDate = "CONVERT_TZ( ".$sqlQueryDate." , CONCAT(IF(TIMEDIFF(NOW(), UTC_TIMESTAMP) >= 0,'+',''),TIME_FORMAT(TIMEDIFF(NOW(), UTC_TIMESTAMP),'%H:%i')),'".$sqlFixTimezone."')";
		$sqlQueryDate2 = "CONVERT_TZ( ".$sqlQueryDate2." , CONCAT(IF(TIMEDIFF(NOW(), UTC_TIMESTAMP) >= 0,'+',''),TIME_FORMAT(TIMEDIFF(NOW(), UTC_TIMESTAMP),'%H:%i')),'".$sqlFixTimezone."')";
	}
	if($sqlFixTime_Add){
		$sqlQueryDate = "DATE_ADD( ".$sqlQueryDate." ,INTERVAL ".$sqlFixTime_Add.")";
		$sqlQueryDate2 = "DATE_ADD( ".$sqlQueryDate2." ,INTERVAL ".$sqlFixTime_Add.")";
	}
	if($sqlFixTime_Sub){
		$sqlQueryDate = "DATE_SUB( ".$sqlQueryDate." ,INTERVAL ".$sqlFixTime_Sub.")";
		$sqlQueryDate2 = "DATE_SUB( ".$sqlQueryDate2." ,INTERVAL ".$sqlFixTime_Sub.")";
	}
	$sqlQuery = "SELECT " . 
" YEARWEEK(DATE_SUB( ".$sqlQueryDate." ,INTERVAL ".$sqlSubDate."),1) AS `YearWeek`, " . 
" DATE_FORMAT(DATE_SUB( ".$sqlQueryDate." ,INTERVAL ".$sqlSubDate."),'%w') AS `DayOfWeek`, " . 
" DATE(DATE_SUB( ".$sqlQueryDate." ,INTERVAL ".$sqlSubDate.")) AS `DTE`, " . 
" SUM(`s`.`saleTotalAmount`) AS `saleTotalAmount`, " . 
" SUM(`s`.`saleTotalDiscount`) AS `saleTotalDiscount`, " . 
" SUM(`s`.`saleTotalBalance`) AS `saleTotalBalance`, " . 
" COUNT(DISTINCT(`s`.`saleIndex`)) AS `totalBill`, " . 
" `sl`.`totalSaleQTY` AS `totalSaleQTY` " . 
" FROM `saledetail` `s` " . 
" LEFT JOIN (SELECT DATE(DATE_SUB( ".$sqlQueryDate2." ,INTERVAL ".$sqlSubDate.")) AS `DTE`, SUM(`sl`.`saleQTY`) AS `totalSaleQTY` FROM `salelist` `sl` WHERE DATE_SUB( ".$sqlQueryDate2." ,INTERVAL ".$sqlSubDate.") BETWEEN '".$dateForm."' AND DATE_ADD('".$dateTo."',INTERVAL 1 DAY) GROUP BY DATE( DATE_SUB( ".$sqlQueryDate2." ,INTERVAL ".$sqlSubDate.") )) `sl` " . 
" ON `sl`.`DTE` = DATE( DATE_SUB( ".$sqlQueryDate." ,INTERVAL ".$sqlSubDate.") ) " . 
" WHERE DATE_SUB( ".$sqlQueryDate." ,INTERVAL ".$sqlSubDate.") BETWEEN '".$dateForm."' AND DATE_ADD('".$dateTo."',INTERVAL 1 DAY) " . 
" GROUP BY DATE_FORMAT( DATE_SUB( ".$sqlQueryDate." ,INTERVAL ".$sqlSubDate.") ,'%w'),YEARWEEK( DATE_SUB( ".$sqlQueryDate." ,INTERVAL ".$sqlSubDate.") ,1) " . 
" ORDER BY DATE(`s`.`CRE_DTE`) ASC";
	$stmt = mysqli_prepare($connection, $sqlQuery);		
	mysqli_stmt_execute($stmt);
	$rows = array();
	$row = new stdClass();
	mysqli_stmt_bind_result($stmt, $row->YearWeek, $row->DayOfWeek, $row->DTE, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance, $row->totalBill, $row->saleTotalQTY);
	
	while (mysqli_stmt_fetch($stmt)) {
		$rows[] = $row;
		$row = new stdClass();
		mysqli_stmt_bind_result($stmt, $row->YearWeek, $row->DayOfWeek, $row->DTE, $row->saleTotalAmount, $row->saleTotalDiscount, $row->saleTotalBalance, $row->totalBill, $row->saleTotalQTY);
	}
	mysqli_stmt_free_result($stmt);
	mysqli_stmt_close($stmt);
	
	// Select Top item
	$sqlQuery2 = " SELECT `tmp`.`YearWeek`,`tmp`.`rNo`,`tmp`.`itemIndex`,`i`.`itemName`,`tmp`.`sumSoldQTY` FROM ( " . 
	" SELECT *, @rowNo := if(@pv = YearWeek, @rowNo+1, 1) as rNo, @pv := YearWeek " . 
	" FROM (" . 
		" SELECT " . 
		" YEARWEEK( DATE_SUB( ".$sqlQueryDate." ,INTERVAL ".$sqlSubDate.") ,1) AS `YearWeek`, " . 
		" `s`.`itemIndex` AS `itemIndex`, " . 
		" SUM(`s`.`saleQTY`) AS `sumSoldQTY` " . 
		" FROM `salelist` `s` " . 
		" WHERE DATE_SUB( ".$sqlQueryDate." ,INTERVAL ".$sqlSubDate.") BETWEEN '".$dateForm."' AND DATE_ADD('".$dateTo."',INTERVAL 1 DAY) " . 
		" GROUP BY YEARWEEK( DATE_SUB( ".$sqlQueryDate." ,INTERVAL ".$sqlSubDate.") ,1), `s`.`itemIndex` " . 
		" ORDER BY `YearWeek` ASC ,`sumSoldQTY` DESC " . 
	") temp JOIN (SELECT @rowNo := 0, @pv := 0) tempValue ) tmp " .
	" LEFT JOIN (SELECT `i`.`itemIndex` AS `itemIndex`,`i`.`itemName` AS `itemName` FROM `_item` `i`) `i` ON `tmp`.`itemIndex` = `i`.`itemIndex` WHERE tmp.rNo <= 10";
	
	$stmt = mysqli_prepare($connection, $sqlQuery2);		
	mysqli_stmt_execute($stmt);
	$rows2 = array();
	$row = new stdClass();
	mysqli_stmt_bind_result($stmt, $row->YearWeek, $row->rNo, $row->itemIndex, $row->itemName, $row->sumSoldQTY);

	while (mysqli_stmt_fetch($stmt)) {
		$rows2[] = $row;
		$row = new stdClass();
		mysqli_stmt_bind_result($stmt, $row->YearWeek, $row->rNo, $row->itemIndex, $row->itemName, $row->sumSoldQTY);
	}
	mysqli_stmt_free_result($stmt);
	mysqli_stmt_close($stmt);
	mysqli_close($connection);
}

if(isset($rows)){
	
	$data = array(
		'$sqlQuery' => $sqlQuery,
		'$sqlQuery2' => $sqlQuery2,
		'top10' => array(),
		'overview' => array(
			'bill'=>0,
			'amount'=>0,
			'balance'=>0,
			'qty'=>0,
			'discount'=>0
		),
		/*
		'weekData' => array()
		*/
		'weekData' => array(
			'labels'=>array(),
			'bill'=>array(),
			'amount'=>array(),
			'balance'=>array(),
			'qty'=>array(),
			'discount'=>array()
		),
		'test' => array()
	);
	
	
	foreach($rows as $row){
		// overview
		$tempdata[$row->YearWeek]['bill'] += $row->totalBill;
		$tempdata[$row->YearWeek]['amount'] += $row->saleTotalAmount;
		$tempdata[$row->YearWeek]['balance'] += $row->saleTotalBalance;
		$tempdata[$row->YearWeek]['qty'] += $row->saleTotalQTY;
		$tempdata[$row->YearWeek]['discount'] += $row->saleTotalDiscount;
		// by week
		// *** Sales Amount Vs Sales Balance ***
		// *** Sales Qty Vs Bill(Ticket) ***
		if(!$tempdata[$row->YearWeek]['labels']){
			$date = new DateTime($row->DTE);
			$startOfWeek = $date->format('j M');
			//$date->sub(new DateInterval('P'.((int)$row->DayOfWeek - 1).'D'));
			if((int)$row->DayOfWeek !== 0)
				$date->add(new DateInterval('P'.(7-(int)$row->DayOfWeek).'D'));
			$endOfWeek = $date->format('j M');
			if($date > $maxDate)
				$endOfWeek = $maxDate->format('j M');
				
			$tempdata[$row->YearWeek]['labels'] = $startOfWeek .'-'.$endOfWeek;
			
			//$data['test'][$row->YearWeek] = $row->DTE.' >>> '.$row->DayOfWeek;
			//$tempdata[$row->YearWeek]['labels'] = 'test';
		}
			//$data['test'][] = $row->YearWeek.' >>> '.$row->DTE.' >>> '.$row->DayOfWeek;
		
		// by weekday or weekend
		// *** Sales Amount Per Ticket (SA/Ticket) ***
		// *** Sales Quantity Per Ticket (SQ/Ticket) ***
		//if(((int)$row->DayOfWeek) >= 0 && ((int)$row->DayOfWeek) <= 4) {
		if(((int)$row->DayOfWeek) >= 1 && ((int)$row->DayOfWeek) <= 5) {
			// Week Day
			$tempdata[$row->YearWeek]['weekday']['bill'] += $row->totalBill;
			$tempdata[$row->YearWeek]['weekday']['amount'] += $row->saleTotalAmount;
			$tempdata[$row->YearWeek]['weekday']['balance'] += $row->saleTotalBalance;
			$tempdata[$row->YearWeek]['weekday']['qty'] += $row->saleTotalQTY;
			$tempdata[$row->YearWeek]['weekday']['discount'] += $row->saleTotalDiscount;
			
		} else {
			// Week End
			$tempdata[$row->YearWeek]['weekend']['bill'] += $row->totalBill;
			$tempdata[$row->YearWeek]['weekend']['amount'] += $row->saleTotalAmount;
			$tempdata[$row->YearWeek]['weekend']['balance'] += $row->saleTotalBalance;
			$tempdata[$row->YearWeek]['weekend']['qty'] += $row->saleTotalQTY;
			$tempdata[$row->YearWeek]['weekend']['discount'] += $row->saleTotalDiscount;
			
		}
	}
	// Top 10 Data
	foreach($rows2 as $row){
		$tempTop10x[$row->YearWeek] += $row->sumSoldQTY;
	}
	foreach($rows2 as $row){
		$tempTop10[$row->YearWeek][] = array(
			'name'=>$row->itemName,
			'total'=>(($tempTop10x[$row->YearWeek] > 0)?round(($row->sumSoldQTY/$tempTop10x[$row->YearWeek])*100,2):0)
		);
	}
	foreach($tempTop10 as $k=>$t10){
		$data['top10'][] = array(
			'label' => $tempdata[$k]['labels'],
			'list' => $t10
		);
	}
	
	// Other Data
	foreach($tempdata as $d){
		$data['weekData']['labels'][] = $d['labels'];
		$data['weekData']['bill'][] = (int)$d['bill'];
		$data['weekData']['amount'][] = (float)$d['amount'];
		$data['weekData']['balance'][] = (float)$d['balance'];
		$data['weekData']['qty'][] = (float)$d['qty'];
		$data['weekData']['discount'][] = (float)$d['discount'];
		
		$data['weekData']['saPticketWeekDay'][] = (($d['weekday']['bill'] > 0)?((float)($d['weekday']['amount']/$d['weekday']['bill'])):0);
		$data['weekData']['saPticketWeekEnd'][] = (($d['weekend']['bill'] > 0)?((float)($d['weekend']['amount']/$d['weekend']['bill'])):0);
		$data['weekData']['saPticketLinear'][] = (($d['bill'] > 0)?(float)($d['amount']/$d['bill']):0);
		
		$data['weekData']['sqPticketWeekDay'][] = (($d['weekday']['bill'] > 0)?((float)($d['weekday']['qty']/$d['weekday']['bill'])):0);
		$data['weekData']['sqPticketWeekEnd'][] = (($d['weekend']['bill'] > 0)?((float)($d['weekend']['qty']/$d['weekend']['bill'])):0);
		$data['weekData']['sqPticketLinear'][] = (($d['bill'] > 0)?(float)($d['qty']/$d['bill']):0);
		
		$data['weekData']['weekday']['bill'][] = (float)$d['weekday']['bill'];
		$data['weekData']['weekday']['amount'][] = (float)$d['weekday']['amount'];
		$data['weekData']['weekday']['balance'][] = (float)$d['weekday']['balance'];
		$data['weekData']['weekday']['qty'][] = (float)$d['weekday']['qty'];
		$data['weekData']['weekday']['discount'][] = (float)$d['weekday']['discount'];
		
		$data['weekData']['weekend']['bill'][] = (float)$d['weekend']['bill'];
		$data['weekData']['weekend']['amount'][] = (float)$d['weekend']['amount'];
		$data['weekData']['weekend']['balance'][] = (float)$d['weekend']['balance'];
		$data['weekData']['weekend']['qty'][] = (float)$d['weekend']['qty'];
		$data['weekData']['weekend']['discount'][] = (float)$d['weekend']['discount'];
		/*
		$data['weekData'][] = array(
			'labels' => $d['labels'],
			'bill' => $d['bill'],
			'amount' => $d['amount'],
			'balance' => $d['balance'],
			'qty' => $d['qty'],
			'discount' => $d['discount']
		);
		*/
		
		$data['overview']['bill'] += $d['bill'];
		$data['overview']['amount'] += $d['amount'];
		$data['overview']['balance'] += $d['balance'];
		$data['overview']['qty'] += $d['qty'];
		$data['overview']['discount'] += $d['discount'];
	}
	
	$data['overview']['bill'] = number_format($data['overview']['bill']);
	$data['overview']['amount'] = number_format($data['overview']['amount']);
	$data['overview']['qty'] = number_format($data['overview']['qty']);
	$data['overview']['balance'] = number_format($data['overview']['balance'],2);
	$data['overview']['discount'] = number_format($data['overview']['discount'],2);
	/*
	$data = array(
		'labels'=>array('18may-24may','25may-31may','1jun-7jun','8jun-14jun','15jun-21jun','22jun-25jun'),
		'amount'=>array(207760.00,137999.00,131984.00,119064.00,126936.00,71731.00),
		'balance'=>array(143881.60,126552.80,131367.30,118209.60,125987.60,70711.00),
		'qty'=>array(7102,4251,3978,3552,3712,2153),
		'bill'=>array(2847,1923,1756,1558,1559,844)
	);
	*/
	$json = json_encode($data);
	
	# JSON if no callback
	if( ! isset($_GET['callback']))
		exit($json);
	# JSONP if valid callback
	if(is_valid_callback($_GET['callback']))
		exit("{$_GET['callback']}($json)");
	# Otherwise, bad request
	header('status: 400 Bad Request', true, 400);
	exit();
}
# Otherwise, bad request
header('status: 404 Not Found', true, 404);

?>