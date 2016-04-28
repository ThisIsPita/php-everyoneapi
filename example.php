<?php
//include everyoneAPI library.
require_once("everyoneapi.php");

//create everyoneAPI object.
$obj = new everyoneAPI("[account_sid]", "[auth_token]");

//get all data points.
$data = $obj->getData("5551234567");

//print line type data point.
echo $data->{'data'}->{'linetype'};

//view formatted response.
echo "<pre>";
var_dump($data);
echo "</pre>"
?>