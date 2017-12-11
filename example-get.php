<?php
require_once("sdata-modules.php");
/**
 * @Author: Eka Syahwan
 * @Date:   2017-12-11 17:01:26
 * @Last Modified by:   Eka Syahwan
 * @Last Modified time: 2017-12-11 17:15:02
 */
$url 	= array(); 
for ($i=0; $i <12; $i++) { 

	$url[] = array(
		'url' => 'http://ip-api.com/json',
		'note' => 'optional', 
	);

}
$result = $sdata->sdata($url);

print_r($result);