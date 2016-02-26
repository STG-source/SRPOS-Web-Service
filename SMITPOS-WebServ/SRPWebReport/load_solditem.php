<?php
	error_reporting(E_ALL & ~E_NOTICE);
	header('Content-Type: text/html; charset=utf-8');
	include("cfg.inc.php");
	
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
" `i`.`itemIndex` AS `itemIndex`, " .
" `i`.`itemID` AS `itemID`, " .
" `i`.`itemName` AS `itemName`, " .
" `i`.`itemDetail` AS `itemDesc`, " .
" IFNULL(`s`.`sumSoldQTY`, 0) AS `sumSoldQTY`, " .
" `i`.`itemPrice` AS `itemPrice`, " .
" IFNULL((`s`.`sumSoldQTY`* `i`.`itemPrice`), 0) AS `TotalPrice`, " .
" `i`.`itemCatagoryIndex` AS `itemCat` " .
" FROM `_item` `i` " .
// salelist
" LEFT JOIN (" .
	" SELECT " . 
	" `s`.`itemIndex` AS `itemIndex` , " . 
	" SUM(`s`.`saleQTY`) AS `sumSoldQTY` " . 
	" FROM `salelist` `s` " . 
	" WHERE DATE_SUB( ".$sqlQueryDate." ,INTERVAL ".$sqlSubDate.") BETWEEN '".$dateForm."' AND DATE_ADD('".$dateTo."',INTERVAL 1 DAY) " . 
	" GROUP BY `s`.`itemIndex`  " .
") `s` ON `i`.`itemIndex` = `s`.`itemIndex`" .
//"WHERE `s`.`sumSoldQTY` > 0" .
" ORDER BY `i`.`itemCatagoryIndex`, `i`.`itemIndex` ASC";

	$stmt = mysqli_prepare($connection, $sqlQuery);		
	mysqli_stmt_execute($stmt);
	$rows = array();
	$row = new stdClass();
	mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itemName, $row->itemDesc, $row->sumSoldQTY, $row->itemPrice, $row->TotalPrice, $row->itemCat);
	
	while (mysqli_stmt_fetch($stmt)) {
		$rows[] = $row;
		$row = new stdClass();
		mysqli_stmt_bind_result($stmt, $row->itemIndex, $row->itemID, $row->itemName, $row->itemDesc, $row->sumSoldQTY, $row->itemPrice, $row->TotalPrice, $row->itemCat);
	}
	mysqli_stmt_free_result($stmt);
	
	mysqli_stmt_close($stmt);
	
	// Catagory
	$sqlQuery = "SELECT " .
"`c`.`itemCatagoryIndex` AS `itemCatagoryIndex`, " .
"`c`.`catagory` AS `catagory` " .
"FROM `_itemcatagory` `c` " .
"ORDER BY `c`.`itemCatagoryIndex` ASC";

	$stmt = mysqli_prepare($connection, $sqlQuery);		
	mysqli_stmt_execute($stmt);
	$catagories = array();
	$row = new stdClass();
	mysqli_stmt_bind_result($stmt, $row->itemCatagoryIndex, $row->catagory);
	
	while (mysqli_stmt_fetch($stmt)) {
		$catagories[] = $row;
		$row = new stdClass();
		mysqli_stmt_bind_result($stmt, $row->itemCatagoryIndex, $row->catagory);
	}
	mysqli_stmt_free_result($stmt);
	
	foreach($catagories as $cat){
		$catagory[$cat->itemCatagoryIndex] = $cat->catagory;
	}
	
	mysqli_close($connection);
	
}

if(isset($rows)){
	$cat = 0;
	echo('
<table class="table table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>รหัสสินค้า</th>
			<th>ชื่อสินค้า</th>
			<th>ยอดจำหน่าย</th>
			<th>ราคาต่อหน่วย</th>
			<th>ราคาสุทธิ</th>
		</tr>
	</thead>
	<tbody>');
	$i = 0;
	foreach($rows as $row){
	
		if($row->itemCat > $cat)
		{
			$cat = $row->itemCat;
			echo('
			<tr>
				<td colspan="6">'.($catagory[$row->itemCat]?$catagory[$row->itemCat]:'Other').'</td>
			</tr>');
		}
		
		echo('
		<tr>
			<td>'.(++$i).'</td>
			<td>'.$row->itemID.'('.$row->itemCat.')</td>
			<td>'.$row->itemName.'</td>
			<td>'.number_format($row->sumSoldQTY).'</td>
			<td>'.number_format($row->itemPrice,2).'</td>
			<td>'.number_format($row->TotalPrice,2).'</td>
		</tr>');
	
		$totalSoldQTY += $row->sumSoldQTY;
		$totalPrice += $row->TotalPrice;
	}
	echo('
		<tr>
			<td colspan="3">จำนวนรวม</td>
			<td>'.number_format($totalSoldQTY).'</td>
			<td>ราคารวม</td>
			<td>'.number_format($totalPrice,2).'</td>
		</tr>
	</tbody>
</table>');
}

?>