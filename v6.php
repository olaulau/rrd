#!/bin/php
<?php

// const
$name = "temperature";
$rrd_file = "$name.rrd";
$png_file = "$name.png";
$ds_name = "temperature";
$device = "nvme0n1";
$step = 1; // 1 sec tick
$heartbeat = $step * 2;
$min = 0;
$max = 100;
$xff = 0.5;

// prepare
$cmd = "date +%s";
$now = exec($cmd, $output, $result_code);

// create rrdtool database
if(!file_exists($rrd_file)) {
	echo "creating rrd database" . PHP_EOL;
	$db_start = $now - $step;
	$rras = [
		[ // last min history	(1 sec step * 60 rows)
			"steps"	=> 1,
			"rows"	=> 60,
		],
		[ // last hour history	(1 min step * 60 rows)
			"steps"	=> 60,
			"rows"	=> 60,
		],
		[ // last day history	(10 min step)
			"steps"	=> 60*10,
			"rows"	=> 6*24,
		],
		[ // last week history	(1 hour step)
			"steps"	=> 60*60,
			"rows"	=> 24*7,
		],
		[ // last month history	(1 day step)
			"steps"	=> 60*60*24,
			"rows"	=> 31,
		],
		[ // last year history	(1 week step)
			"steps"	=> 60*60*24*7,
			"rows"	=> 52,
		],
	];
	$cmd = "rrdtool create $rrd_file --start $db_start --step $step \
        DS:$ds_name:GAUGE:$heartbeat:$min:$max \
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
