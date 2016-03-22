<?php
	error_reporting(E_ALL & ~E_NOTICE);
	header('Content-Type: text/html; charset=utf-8');
	include("cfg.inc.php");
	$dayIs = array( 0=>'Sunday',1=>'Monday',2=>'Tuesday',3=>'Wednesday',4=>'Thursday',5=>'Friday',6=>'Saturday');
	
// Input Result
if(isset($_POST['startDate']) && isset($_POST['endDate'])){
	$dateForm = $_POST['startDate'];
	$dateTo = $_POST['endDate'];
	
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
	
	$sqlQueryDate = "`s`.`CRE_DTE`";
	if($sqlFixTimezone){
		$sqlQueryDate = "CONVERT_TZ( ".$sqlQueryDate." , CONCAT(IF(TIMEDIFF(NOW(), UTC_TIMESTAMP) >= 0,'+',''),TIME_FORMAT(TIMEDIFF(NOW(), UTC_TIMESTAMP),'%H:%i')),'".$sqlFixTimezone."')";
	}
	if($sqlFixTime_Add){
		$sqlQueryDate = "DATE_ADD( ".$sqlQueryDate." ,INTERVAL ".$sqlFixTime_Add.")";
	}
	if($sqlFixTime_Sub){
		$sqlQueryDate = "DATE_SUB( ".$sqlQueryDate." ,INTERVAL ".$sqlFixTime_Sub.")";
	}
	
	$sqlQuery = "SELECT " . 
		" YEARWEEK( DATE_SUB( ".$sqlQueryDate." ,INTERVAL ".$sqlSubDate.") , 1 ) AS  `YearWeek` , " . 
		" WEEK( DATE_SUB( ".$sqlQueryDate." ,INTERVAL ".$sqlSubDate.") , 1 ) AS  `Week` , " . 
		" DATE_FORMAT( DATE_SUB( ".$sqlQueryDate." ,INTERVAL ".$sqlSubDate.") ,'%w' ) AS `DayOfWeek`, " . 
		" DATE( DATE_SUB( ".$sqlQueryDate." ,INTERVAL ".$sqlSubDate.") ) AS  `DTE` , " . 
		" HOUR( ".$sqlQueryDate." ) AS  `hours` , " . 
		" SUM( `s`.`saleTotalBalance` ) AS `SumTotalBalance`" . 
	" FROM  `saledetail`  `s` " . 
	" WHERE DATE_SUB( ".$sqlQueryDate." ,INTERVAL ".$sqlSubDate." )" .
	" BETWEEN '".$dateForm."' AND DATE_ADD('".$dateTo."',INTERVAL 1 DAY) " . 
	" GROUP BY DATE(  DATE_SUB( ".$sqlQueryDate." ,INTERVAL ".$sqlSubDate.")  ) , HOUR( ".$sqlQueryDate." ) " . 
	" ORDER BY `s`.`CRE_DTE` ASC";
	
	$stmt = mysqli_prepare($connection, $sqlQuery);		
	mysqli_stmt_execute($stmt);
	$rows = array();
	$row = new stdClass();
	mysqli_stmt_bind_result($stmt, $row->YearWeek, $row->Week, $row->DayOfWeek, $row->DTE, $row->hours, $row->SumTotalBalance);
	
	while (mysqli_stmt_fetch($stmt)) {
		$rows[] = $row;
		$row = new stdClass();
		mysqli_stmt_bind_result($stmt, $row->YearWeek, $row->Week, $row->DayOfWeek, $row->DTE, $row->hours, $row->SumTotalBalance);
	}
	mysqli_stmt_free_result($stmt);
	mysqli_stmt_close($stmt);
	mysqli_close($connection);
}
$testMode = false;
if(isset($rows) && $testMode == true){
	echo('
<table class="table table-bordered">
	<thead>
		<tr>
			<th class="title dt">YearWeek</th>
			<th class="title dt">Week</th>
			<th class="title dt">DayOfWeek</th>
			<th class="title dt">DTE</th>
			<th class="title dt">hours</th>
			<th class="title dt">SumTotalBalance</th>
		</tr>
	</thead>
	<tbody>');
	foreach($rows as $row){
		echo('
		<tr>
			<td>'.$row->YearWeek.'</td>
			<td>'.$row->Week.'</td>
			<td>'.$row->DayOfWeek.'</td>
			<td>'.$row->DTE.'</td>
			<td>'.$row->hours.'</td>
			<td>'.$row->SumTotalBalance.'</td>
		</tr>');
	}
	echo('
	</tbody>
</table>');
	die();
}

if(isset($rows)){
	$cat = 0;
	$data = array();
	foreach($rows as $row){
		$data[$row->YearWeek]['week'] = $row->Week;
		$hours = (int)$row->hours;
		
		if($hours < $subHour)
			$hours = 22;
		else if($hours < 7)
			$hours = 7;
		else if($hours > 22)
			$hours = 22;
		
		$data[$row->YearWeek]['list'][$row->DayOfWeek]['date'] = $row->DTE;
		$data[$row->YearWeek]['list'][$row->DayOfWeek]['hour'][($hours)] += (float)$row->SumTotalBalance;
		$data[$row->YearWeek]['list'][$row->DayOfWeek]['total'] += (float)$row->SumTotalBalance;
		$data[$row->YearWeek]['total'] += (float)$row->SumTotalBalance;
	}
	echo('
<div class="sheet">
<table id="indicator" class="table table-bordered">
	<tbody>
		<tr>
			<td>Indicator :</td>');
	foreach($indicator_rate as $lv=>$rate){
		echo('<td class="data indicator_lv'.$lv.'">'.$rate.'+</td>');
	}
	echo('
		</tr>
	</tbody>
</table>
</div>');
	
	//print_r($data);
	echo('
<table class="table table-bordered">
	<thead>
		<tr>
			<th class="title dt">Date/Time</th>
			<th class="title hour7">7:00</th>
			<th class="title mainTime">8:00</th>
			<th class="title mainTime">9:00</th>
			<th class="title mainTime">10:00</th>
			<th class="title mainTime">11:00</th>
			<th class="title mainTime">12:00</th>
			<th class="title mainTime">13:00</th>
			<th class="title mainTime">14:00</th>
			<th class="title mainTime">15:00</th>
			<th class="title mainTime">16:00</th>
			<th class="title mainTime">17:00</th>
			<th class="title mainTime">18:00</th>
			<th class="title mainTime">19:00</th>
			<th class="title mainTime">20:00</th>
			<th class="title mainTime">21:00</th>
			<th class="title hour22">22:00</th>
			<th class="title total">Total</th>
		</tr>
	</thead>
	<tbody>');
	$i = 0;
	$totalHour = array();
	
	foreach($data as $Yearweek=>$dataYearweek){
		echo('<tr>
			<td colspan="18" class="tb-week">Week '.$dataYearweek['week'].'</td></tr>');
		foreach($dataYearweek['list'] as $k=>$d){
			echo('<tr>');
			echo('<td class="data day" title="'.$d['date'].'">'.$dayIs[$k].'</td>');
			echo('<td class="data hour7 '.indicator_level($d['hour'][7]).'">'.number_format($d['hour'][7],2).'</td>');
			echo('<td class="data '.indicator_level($d['hour'][8]).'">'.number_format($d['hour'][8],2).'</td>');
			echo('<td class="data '.indicator_level($d['hour'][9]).'">'.number_format($d['hour'][9],2).'</td>');
			echo('<td class="data '.indicator_level($d['hour'][10]).'">'.number_format($d['hour'][10],2).'</td>');
			echo('<td class="data '.indicator_level($d['hour'][11]).'">'.number_format($d['hour'][11],2).'</td>');
			echo('<td class="data '.indicator_level($d['hour'][12]).'">'.number_format($d['hour'][12],2).'</td>');
			echo('<td class="data '.indicator_level($d['hour'][13]).'">'.number_format($d['hour'][13],2).'</td>');
			echo('<td class="data '.indicator_level($d['hour'][14]).'">'.number_format($d['hour'][14],2).'</td>');
			echo('<td class="data '.indicator_level($d['hour'][15]).'">'.number_format($d['hour'][15],2).'</td>');
			echo('<td class="data '.indicator_level($d['hour'][16]).'">'.number_format($d['hour'][16],2).'</td>');
			echo('<td class="data '.indicator_level($d['hour'][17]).'">'.number_format($d['hour'][17],2).'</td>');
			echo('<td class="data '.indicator_level($d['hour'][18]).'">'.number_format($d['hour'][18],2).'</td>');
			echo('<td class="data '.indicator_level($d['hour'][19]).'">'.number_format($d['hour'][19],2).'</td>');
			echo('<td class="data '.indicator_level($d['hour'][20]).'">'.number_format($d['hour'][20],2).'</td>');
			echo('<td class="data hour21 '.indicator_level($d['hour'][21]).'">'.number_format($d['hour'][21],2).'</td>');
			echo('<td class="data hour22 '.indicator_level($d['hour'][22]).'">'.number_format($d['hour'][22],2).'</td>');
			echo('<td class="data total">'.number_format($d['total'],2).'</td>');
			echo('</tr>');
			$totalHour[7] += $d['hour'][7];
			$totalHour[8] += $d['hour'][8];
			$totalHour[9] += $d['hour'][9];
			$totalHour[10] += $d['hour'][10];
			$totalHour[11] += $d['hour'][11];
			$totalHour[12] += $d['hour'][12];
			$totalHour[13] += $d['hour'][13];
			$totalHour[14] += $d['hour'][14];
			$totalHour[15] += $d['hour'][15];
			$totalHour[16] += $d['hour'][16];
			$totalHour[17] += $d['hour'][17];
			$totalHour[18] += $d['hour'][18];
			$totalHour[19] += $d['hour'][19];
			$totalHour[20] += $d['hour'][20];
			$totalHour[21] += $d['hour'][21];
			$totalHour[22] += $d['hour'][22];
			$totalHour['total'] += $d['hour']['total'];
		}
	}
	echo('
	</tbody>
</table>');
}
?>