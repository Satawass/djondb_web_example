<?php
require ('djondb\Command.php');
require ('djondb\DjondbConnection.php');
require ('djondb\DjondbCursor.php');
require ('djondb\DjondbException.php');
require ('djondb\Network.php');

use djondb\DjondbConnection as DjondbConnection;

$c = new DjondbConnection("localhost", 1243);
$isCon = $c->open();

if(isset($_POST['id']) || isset($_POST['name']) || isset($_POST['lastName']) || isset($_POST['street']) || isset($_POST['number'])){

    if ($isCon) {
	    $address = (object)array("street" => $_POST['street'], "number" => $_POST['number']);
	    $addresses = array($address);
	    $obj = (object)array("_id" => $_POST['id'], "_revision" => $_POST['revision'], "name" => $_POST['name'], "lastName" => $_POST['lastName'], "addresses"=> $addresses);

	    $json = json_encode($obj);
        
	    $updateDQL = "update $json into phprocks:customer";
        // print($updateDQL);
	    $c->executeUpdate($updateDQL);
        echo "Edit Successfully.";
        echo "<meta http-equiv='refresh' content='2;url=test.php'>";
    }
}else{

    $id = $_GET['_id'];
    // echo $id;
    // Find
	$cur = $c->executeQuery("select * from phprocks:customer where _id = '$id'");
    ?>

    <!doctype>
    <html>
        <head>
	        <title>djonDB - update</title>
        </head>
        <body>
            <h2>Edit</h2>
            <form action="edit.php" method="post">
                <?php
                while($cur->next()) {
                    $recovered = $cur->current();
                ?>
	            <table>
		            <tr>
                        <th>FistName</th>
                        <td><input type='text' name='name' value='<?php print($recovered->name); ?>'></td>
                    </tr>
                    <tr>
                        <th>LastName</th>
                        <td><input type='text' name='lastName' value='<?php print($recovered->lastName); ?>'></td>
                    </tr>
                    <tr>
                        <th colspan='2'><center>Addresses</center></th>
                    </tr>
                    <tr>
                        <th>Street</th>
                        <td><input type='text' name='street' value='<?php print($recovered->addresses[0]->street); ?>'></td>
                    </tr>
                    <tr>
                        <th>Number</th>
                        <td><input type='text' name='number' value='<?php print($recovered->addresses[0]->number); ?>'></td>
                    </tr>
                    <input type='hidden' name='id' value='<?php echo $id;?>'>
                    <input type='hidden' name='revision' value='<?php echo $_GET['_revision'];?>'>
                    <tr>
                        <td>
                            <button type='submit'>Edit</button> 
                            <button type='reset'>Clear</button>
                        </td>
                    </tr>
                </table>
                <?php } ?>
            </form>
        </body>
    </html>
<?php } ?>



