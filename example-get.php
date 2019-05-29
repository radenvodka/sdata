<?php
require_once("sdata-modules.php");
/**
 * @Author: Eka Syahwan
 * @Date:   2017-12-11 17:01:26
 * @Last Modified by:   Nokia 1337
 * @Last Modified time: 2019-05-29 22:02:20
 */
$url 	= array(); 
for ($i=0; $i <12; $i++) { 

	$url[] = array(
		'url' => 'http://ip-api.com/json?id='.$i,
		'note' => 'optional', 
	);

}
$result = $sdata->sdata($url);

print_r($result);