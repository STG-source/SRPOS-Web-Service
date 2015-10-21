<html><body><h1>HACKED! Reply</h1>
<p>This is the default web page for this server.</p>
<p>The web server software is running but no content has been added, yet.</p>

<?php echo "hello wOal --> ";
      print_r($_POST);

      xdebug_start_trace();
	var_dump($_POST);
      xdebug_stop_trace();
?>

<table>
<?php

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

