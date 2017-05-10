<?php
require ('djondb\Command.php');
require ('djondb\DjondbConnection.php');
require ('djondb\DjondbCursor.php');
require ('djondb\DjondbException.php');
require ('djondb\Network.php');

use djondb\DjondbConnection as DjondbConnection;

if(isset($_POST['name']) || isset($_POST['lastName']) || isset($_POST['street']) || isset($_POST['number'])){
    

    $c = new DjondbConnection("localhost", 1243);
    $isCon = $c->open();

    if ($isCon) {
	    $address = (object)array("street" => $_POST['street'], "number" => $_POST['number']);
	    $addresses = array($address);
	    $obj = (object)array("name" => $_POST['name'], "lastName" => $_POST['lastName'], "addresses"=> $addresses);

	    $json = json_encode($obj);
	
	    $insertDQL = "insert $json into phprocks:customer";
	    $c->executeUpdate($insertDQL);
        echo "Insert Successfully.";
        echo "<meta http-equiv='refresh' content='2;url=test.php'>";
	    // Find
	    // $cur = $c->executeQuery("select * from phprocks:customer");
    }
}else{
    ?>
    <!doctype>
    <html>
        <head>
	        <title>djonDB - insert</title>
        </head>
        <body>
            <h2>Insert</h2>
            <form action="insert.php" method="post">
	            <table>
		            <tr>
                        <th>FistName</th>
                        <td><input type='text' name='name'></td>
                    </tr>
                    <tr>
                        <th>LastName</th>
                        <td><input type='text' name='lastName'></td>
                    </tr>
                    <tr>
                        <th colspan='2'><center>Addresses</center></th>
                    </tr>
                    <tr>
                        <th>Street</th>
                        <td><input type='text' name='street'></td>
                    </tr>
                    <tr>
                        <th>Number</th>
                        <td><input type='text' name='number'></td>
                    </tr>
                    <tr>
                        <td>
                            <button type='submit'>Insert</button> 
                            <button type='reset'>Clear</button>
                        </td>
                    </tr>
                </table>
            </form>
        </body>
    </html>
<?php } ?>






