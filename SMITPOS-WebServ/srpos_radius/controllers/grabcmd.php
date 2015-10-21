<!-- 
<html><body><h1>SRPOS Radius:: Grab Command Reply</h1>
<p>This block for HTML to represent $_POST data
in table.</p>
<table>
<<!-- ?php
	foreach ($_POST as $key => $value) {
		echo "<tr>";
		echo "<td>";
		echo $key;
		echo "</td>";
		echo "<td>";
        echo $value;
        echo "</td>";
		echo "</tr>";
	}
?>
</table>
</body></html>
-->

<!-- ?php // This block is for debugging
	xdebug_start_trace();
	var_dump($_POST);
	xdebug_stop_trace();
? -->

<?php // Main controller block to interface the service.
	require_once("../services/RadcheckService.php");

	$wifiUser = $_POST['wifiUser'];
	$expiration = $_POST['expiration'];

	if ($expiration != "DEAD") {
		echo "KILL_NG";
		return;
	}

	// Doing the task for set wifiUser expiration from here ...
	$cls_RadcheckService = new RadcheckService();

	$max_ID = $cls_RadcheckService->get_Max_listIndex($wifiUser);
	
	if ($max_ID != 0){
		$row = new stdClass();
		$row->id = $max_ID;	
		$row->username = $wifiUser;
		$row->attribute = "Expiration";
		$row->op = ":=";
		$row->value = $expiration;
		$cls_RadcheckService->updateRadcheck($row);
	}

	echo "KILL_OK";
?>
