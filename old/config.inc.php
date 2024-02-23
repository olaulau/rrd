<?php

// constants
$name = "temperature";
$device = "nvme0n1";
$file_path = "data/";
$rrd_file = "$file_path$name.rrd";
$ds_name = $device;
$step = 1; // 1 sec tick
$heartbeat = $step * 2;
$min_value = 0;
$max_value = 100;
$xff = 0.5;

// prepare
$now = time();

// arrays
$rras = [
    [ // last min history	(1 sec step * 60 rows)
        "steps"         => 1,
        "rows"	        => 60,
    ],
    [ // last hour history	(1 min step * 60 rows)
        "steps"			=> 60,
        "rows"			=> 60,
    ],
    [ // last day history	(10 min step)
        "steps"			=> 60*10,
        "rows"			=> 6*24,
    ],
    [ // last week history	(1 hour step)
        "steps"			=> 60*60,
        "rows"			=> 24*7,
    ],
    [ // last month history	(1 day step)
        "steps"			=> 60*60*24,
        "rows"			=> 31,
    ],
    [ // last year history	(1 week step)
        "steps"			=> 60*60*24*7,
        "rows"	        => 52,
    ],
    [ // 10 years history	(1 month step)
        "steps"			=> 60*60*24*31,
        "rows"	        => 12*10,
    ],
];

$graph_histos = [
	"1mi" => [
		"name"		=> "last minute",
		"duration"	=> 60,
		"graph_period"  => 10,
	],
	"1h" => [
		"name"		=> "last hour",
		"duration"	=> 60*60,
		"graph_period"  => 60,
	],
	"1d" => [
		"name"		=> "last day",
		"duration"	=> 60*60*24,
		"graph_period"  => 60*60,
	],
	"1w" => [
		"name"		=> "last week",
		"duration"	=> 60*60*24*7,
		"graph_period"  => 60*60*24,
	],
	"1mo" => [
		"name"		=> "last month",
		"duration"	=> 60*60*24*31,
		"graph_period"  => 60*60*24*7,
	],
	"1y" => [
		"name"		=> "last year",
		"duration"	=> 60*60*24*365,
		"graph_period"  => 60*60*24*31,
	],
	"10y" => [
		"name"		=> "10 years",
		"duration"	=> 60*60*24*365*10,
		"graph_period"  => 60*60*24*365,
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
