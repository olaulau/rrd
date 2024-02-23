<?php
require_once __DIR__ . "/config.inc.php";

// draw graphs
foreach($graph_histos as $histo => $graph_histo) {
	$start = $now - $graph_histo ["duration"];
	foreach($graph_sizes as $size => $graph_size) {
		$cmd = "rrdtool graph '$file_path$name-$device-$histo-$size.png' -s $start -e $now -w {$graph_size ["width"]} -h {$graph_size ["height"]} -t 'Températures' \
			DEF:$ds_name=$rrd_file:$ds_name:AVERAGE LINE2:$ds_name#FF0000:'$device'";
		$res = passthru($cmd, $result_code);
	}
}
