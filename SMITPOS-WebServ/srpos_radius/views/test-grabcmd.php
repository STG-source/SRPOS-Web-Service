<html><body>
<p>This page is about to test the SRPOS Radius Grab Command on this server.</p>
<!--
The idea of this code I give the credit to you guys in below links who give the answer:
http://stackoverflow.com/questions/19499891/php-post-to-another-server-then-return-the-other-servers-response
http://stackoverflow.com/questions/6044941/php-send-post-request-then-read-xml-response
-->

<?php
	// Below sequence of scripts I want to implement in Sccrrbase service.

	//$url = URL_TO_RECEIVING_PHP;
	$url = "http://192.168.1.200/srpos_radius/controllers/grabcmd.php";

	$fields = array(
		"wifiUser" => "",
		"expiration" => "DEAD"
	);

	$fields["wifiUser"] = "C58100293";

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

	echo $result;
?>

</body></html>
