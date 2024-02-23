<?php
require_once __DIR__ . "/autoload.inc.php";


// detect with modules
$detected = Module::detect();

// write it to DB file
file_put_contents(__DIR__ . "/db.inc.php", '<?php'.PHP_EOL);
file_put_contents(__DIR__ . "/db.inc.php", '$db = ' . var_export($detected, true) . ';', FILE_APPEND);

header("Location: index.php");
