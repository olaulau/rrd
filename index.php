<?php
require_once __DIR__ . "/autoload.inc.php";

// load DB
if (!file_exists("./db.inc.php")) {
	header("Location: detect.php");
}
require_once __DIR__."/db.inc.php";
// var_dump($db); die;

?>
<html>
	<head>

	</head>
	<body>
		<a href="detect.php">force detection</a> <br/>
		
		<ul>
			<?php
			foreach($db as $module) {
				?>
				<li><?= $module->getType() ?> : <?= $module->getName() ?></li>
				<?php
			}
			?>
		</ul
	</body>
</html>
