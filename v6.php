<?php
require_once __DIR__ . "/config.inc.php";

// create rrdtool database
if(!file_exists($rrd_file)) {
	echo "creating rrd database" . PHP_EOL;
	$db_start = $now - $step;
	
	$cmd = "rrdtool create $rrd_file --start $db_start --step $step \
        DS:$ds_name:GAUGE:$heartbeat:$min_value:$max_value \
		";
	foreach($rras as $rra) {
		$cmd .= "RRA:AVERAGE:$xff:{$rra['steps']}:{$rra['rows']} \
		";
	}
	$res = passthru($cmd, $result_code);
}

// get value
$cmd = "sudo nvme smart-log /dev/$device | grep 'Temperature Sensor' | head -n1 | cut -d':' -f2 | cut -d' ' -f2"; // nvme
// $cmd = "smartctl -a /dev/$device | grep Temperature_Celsius | tr -s ' ' | cut -d' ' -f10"; // sata
$val = exec($cmd, $output, $result_code);

$cmd = "rrdtool update $rrd_file $now:$val";
$res = passthru($cmd, $result_code);

// fetch data
$start = $now - 60;
$cmd = "rrdtool fetch $rrd_file AVERAGE --resolution $step --start $start --end $now";
// $res = passthru($cmd, $result_code);
