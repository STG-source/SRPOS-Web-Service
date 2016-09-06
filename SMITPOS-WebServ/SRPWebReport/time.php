<?php
	error_reporting(E_ALL & ~E_NOTICE);
	include("cfg.inc.php");
	
	$connection = mysqli_connect(
		$CFG['DBhost'],
		$CFG['DBusername'],
		$CFG['DBpassword'],
		$CFG['DBname'],
		$CFG['DBport']
	);
	
	mysqli_query($connection, "SET NAMES 'utf8'");
	
	$sqlQueryDate = "NOW()";
	if($sqlFixTimezone){
		$sqlQueryDate = "CONVERT_TZ( ".$sqlQueryDate." , CONCAT(IF(TIMEDIFF(NOW(), UTC_TIMESTAMP) >= 0,'+',''),TIME_FORMAT(TIMEDIFF(NOW(), UTC_TIMESTAMP),'%H:%i')),'".$sqlFixTimezone."')";
	}
	if($sqlFixTime_Add){
		$sqlQueryDate = "DATE_ADD( ".$sqlQueryDate." ,INTERVAL ".$sqlFixTime_Add.")";
	}
	if($sqlFixTime_Sub){
		$sqlQueryDate = "DATE_SUB( ".$sqlQueryDate." ,INTERVAL ".$sqlFixTime_Sub.")";
	}
	
// Query SQL Timezone
	$sqlQuery = "SELECT 
	@@global.time_zone,
	@@session.time_zone,
	@@system_time_zone,
	CONCAT(IF(TIMEDIFF(NOW(), UTC_TIMESTAMP) >= 0,'+',''),TIME_FORMAT(TIMEDIFF(NOW(), UTC_TIMESTAMP),'%H:%i')) as timeZone,
	NOW(),
	".$sqlQueryDate." as currTimeMod";
	$stmt = mysqli_prepare($connection, $sqlQuery);
	mysqli_stmt_execute($stmt);
	$row = new stdClass();
	mysqli_stmt_bind_result($stmt, $row->globalTimezone, $row->sessionTimezone, $row->systemTimezone, $row->timezone, $row->currentTime, $row->currentTimeMod);
	mysqli_stmt_fetch($stmt);
	echo('<b>SQL Config Global Timezone</b> : '.$row->globalTimezone.'<br/>');
	echo('<b>SQL Config Session Timezone</b> : '.$row->sessionTimezone.'<br/>');
	echo('<b>SQL Config System Timezone</b> : '.$row->systemTimezone.'<br/>');
	echo('<b>SQL Check Timezone</b> : '.$row->timezone.'<br/>');
	echo('<b>SQL Current Time</b> : '.$row->currentTime.'<br/>');
	echo('<b>SQL Modify Current Time</b> : '.$row->currentTimeMod.' ('.($sqlTimezone?' Timezone '.$sqlTimezone:'').($sqlFixTime_Add?' Add '.$sqlFixTime_Add:'').($sqlFixTime_Sub?' Sub '.$sqlFixTime_Sub:'').' )<br/>');

	echo('<b>PHP Current Time</b> : '.date("Y-m-d H:i:s").'<br/>');
	echo('<b>PHP Current Timezone</b> : '.date_default_timezone_get().'<br/>');
	mysqli_stmt_free_result($stmt);
	mysqli_stmt_close($stmt);
?>