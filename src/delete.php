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
    $_id = $_GET['_id'];
    $_rev = $_GET['_revision'];
	$cur = $c->remove('phprocks', 'customer', $_id, $rev);
    print('Delete Successfully.');?>
    <meta http-equiv="refresh" content="0;url=test.php">
<?php
}
?>