<?php
error_reporting(E_ALL & ~E_NOTICE); // disabled error except notice.

date_default_timezone_set('Asia/Bangkok');
// SQL
$CFG['DBusername'] = "root"; // config your username mySQL Database
$CFG['DBpassword'] = ""; // config your password mySQL Database
$CFG['DBhost'] = "localhost";
$CFG['DBport'] = "3306";
$CFG['DBname'] = "stechschema"; // config your default Database
$tablename = "saledetail";

// config your indicator rate (lv => rate)
$indicator_rate = array(
	2 => 300,
	3 => 600,
	4 => 1000,
	5 => 1500,
	6 => 2500,
	7 => 5000
);

$subHour = 2; // sub 2 hour for close 2am. (same open at 2am.)

// Fix Datetime when query
//$sqlFixTimezone = '+07:00'; // config your timezone

// MICROSECOND,SECOND,MINUTE,HOUR,DAY,WEEK,MONTH,QUARTER,YEAR
$sqlFixTime_Add = '7 HOUR';
//$sqlFixTime_Sub = '';

// === Do not edit ===
$sqlSubDate = $subHour.' HOUR';

// misc function
function indicator_level($val, $custom_rate = false) {
	global $indicator_rate;
	if($custom_rate)
		$iRate = $custom_rate;
	else
		$iRate = $indicator_rate;
	krsort($iRate);
	foreach($iRate as $lv=>$rate){
		if($val > $rate)
			return 'indicator_lv'.$lv;
	}
	return 'indicator_lv1';
}

function is_valid_callback($subject)
{
    $identifier_syntax
      = '/^[$_\p{L}][$_\p{L}\p{Mn}\p{Mc}\p{Nd}\p{Pc}\x{200C}\x{200D}]*+$/u';

    $reserved_words = array('break', 'do', 'instanceof', 'typeof', 'case',
      'else', 'new', 'var', 'catch', 'finally', 'return', 'void', 'continue', 
      'for', 'switch', 'while', 'debugger', 'function', 'this', 'with', 
      'default', 'if', 'throw', 'delete', 'in', 'try', 'class', 'enum', 
      'extends', 'super', 'const', 'export', 'import', 'implements', 'let', 
      'private', 'public', 'yield', 'interface', 'package', 'protected', 
      'static', 'null', 'true', 'false');

    return preg_match($identifier_syntax, $subject)
        && ! in_array(mb_strtolower($subject, 'UTF-8'), $reserved_words);
}
?>