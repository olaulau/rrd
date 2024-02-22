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

/* draw graphs */
$graph_histo = [
	"1mi" => [
		"name"		=> "last minute",
		"duration"	=> 60,
	],
	"1h" => [
		"name"		=> "last hour",
		"duration"	=> 60*60,
	],
	"1d" => [
		"name"		=> "last day",
		"duration"	=> 60*60*24,
	],
	"1w" => [
		"name"		=> "last week",
		"duration"	=> 60*60*24*7,
	],
	"1mo" => [
		"name"		=> "last month",
		"duration"	=> 60*60*24*31,
	],
	"1y" => [
		"name"		=> "last year",
		"duration"	=> 60*60*24*365,
	],
];
$graph_sizes = [
	"small" => [
		"width"		=> "350",
		"height"	=> "200",
	],
	"medium" => [
		"width"		=> "1050",
		"height"	=> "600",
	],
	"full" => [
		"width"		=> "1920",
		"height"	=> "1080",
	],
];

// last hour
$start = $now - $graph_histo ["1h"] ["duration"];
$cmd = "rrdtool graph '$name-$device-1h-small.png' -s $start -e $now -w {$graph_sizes ["small"] ["width"]} -h {$graph_sizes ["small"] ["height"]} -t 'Températures' \
	DEF:$ds_name=$rrd_file:$ds_name:AVERAGE LINE2:$ds_name#FF0000:'$device'";
$res = passthru($cmd, $result_code);
