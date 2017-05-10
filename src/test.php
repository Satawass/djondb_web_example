<?php

require ('djondb\Command.php');
require ('djondb\DjondbConnection.php');
require ('djondb\DjondbCursor.php');
require ('djondb\DjondbException.php');
require ('djondb\Network.php');

use djondb\DjondbConnection as DjondbConnection;

$c = new DjondbConnection("localhost", 1243);
$isCon = $c->open();
if ($isCon) {
	// Find
	$cur = $c->executeQuery("select * from phprocks:customer");
	?>
<!doctype>
<html>
<head>
	<title>
	djonDB
	</title>
</head>
<body>
<a href='insert.php'>Add</a>
	<table border=1>
		<tr><th>FistName</th><th>LastName</th><th>Street</th><th>Number</th><th colspan='2'></th></tr>
		<?php
		while($cur->next()) {
			$recovered = $cur->current();
		?>
				<tr>
					<td><?php print($recovered->name); ?></td>
					<td><?php print($recovered->lastName); ?></td>
					<td><?php print($recovered->addresses[0]->street); ?></td>
					<td style="text-align: center"><?php print($recovered->addresses[0]->number); ?></td>
					<td><a href='edit.php?_id=<?php print($recovered->_id) ?>&_revision=<?php print($recovered->_revision)?>'>Edit</a></td>
					<td><a href='delete.php?_id=<?php print($recovered->_id) ?>&_revision=<?php print($recovered->_revision)?>'>Delete</a></td>
				</tr>
		<?php
		}
		?>
	</table>
</body>
</html>
	<?php
}

?>

