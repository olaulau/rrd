<?php

$max_value = 60;
$i = 0;
while($i < $max_value) {
    echo $i . PHP_EOL;
    $cmd = "./v6.php";
    $res = passthru($cmd, $result_code);
    sleep(1);
    $i++;
}
$cmd = "./v6_graphs.php";
$res = passthru($cmd, $result_code);
