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
	$wifiUser = $_POST['wifiUser'];
	$expiration = $_POST['expiration'];

	//echo $wifiUser . " :=: " . $expiration;
	// Doing the task for set wifiUser expiration from here ...
	// include_once ...
	// if $expiration == "DEAD"
?>
