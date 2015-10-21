<html><body><h1>It's HACKED!</h1>
<p>This is the default web page for this server.</p>
<p>The web server software is running but no content has been added, yet.</p>

<?php
	echo "tABUCHET --> ";
    print_r($_POST);
	
	//$url = URL_TO_RECEIVING_PHP;
	$url = "http://192.168.1.200/srpos_radius/controllers/grabcmd.php";

	//$PARAM1 = 12123;
	//$PARAM2 = 55889;
	// mean?? array ( 'PARAM1'=>$_POST['PARAM1'],
    //    'PARAM2'=>$_POST['PARAM2']	);

	$fields = array(
			"vOVOL",
			"BMS"
	);

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