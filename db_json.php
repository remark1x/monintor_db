<?php
$data =array(
	'mondb'=>array(
		'user'=>"anyone",
		'password'=>"Password2018!",
		'dbname'=>"MyDBv2"
		)
);

$jstring= json_encode($data);
echo $jstring;
file_put_contents("/home/wwwfile/mon.json",$jstring);

?>
