# Sdata 
PHP cURL : Sdata modules multi threading

# Requirements
- PHP 7
- PHP CURL

# How to use 

* GET DATA
```
$url 	= array(); 
for ($i=0; $i <12; $i++) { 

	$url[] = array(
		'url' => 'http://exapme.com',
		'note' => 'optional', 
	);

}
$result = $sdata->sdata($url);

print_r($result);

```

* POST DATA
```
$url 	= array(); 
for ($i=0; $i <12; $i++) { 
  $custom[] = array(
    'header' => array(
        "accept: application/json",
        "content-type: application/json",
    ),
    'post' => '{"emailAddress":"example@gmail.com"}'
  );
	$url[] = array(
		'url' => 'http://example.com/post',
		'note' => 'optional', 
	);

}
$result = $sdata->sdata($url , $custom);

print_r($result);

```
* Use Proxy

```
$url 	= array(); 

$proxy = array(
  'ip' => '127.0.0.1',
  'port' => '80'
);

for ($i=0; $i <12; $i++) { 
  $custom[] = array(
    'header' => array(
        "accept: application/json",
        "content-type: application/json",
    ),
    'proxy' => $proxy,
    'post' => '{"emailAddress":"example@gmail.com"}'
  );
	$url[] = array(
		'url' => 'http://exapme.com',
		'note' => 'optional', 
	);

}
$result = $sdata->sdata($url);

print_r($result);

```

* Remove cookies files
```
$url 	= array(); 
for ($i=0; $i <12; $i++) { 

	$url[] = array(
		'url' => 'http://exapme.com',
		'note' => 'optional', 
	);

}
$result = $sdata->sdata($url);

print_r($result);

$sdata->session_remove($result);

```

* Set Rotation proxy using rules

```
$ProxyRotation['proxy'] = array(
	'file' => 'proxy.txt',
	'rules' => array(
		'respons' 	=> array('text' =>  'city'), 
		'http_code' => array('text' =>  0), 
	), 
);

$sdata->setRules($ProxyRotation);
```
* example : Rotation proxy using rules
```
<?php
require_once("sdata-modules.php");
/**
 * @Author: Eka Syahwan
 * @Date:   2017-12-11 17:01:26
 * @Last Modified by:   Nokia 1337
 * @Last Modified time: 2019-08-17 01:44:33
*/

$ProxyRotation['proxy'] = array(
	'file' => 'proxy.txt',
	'rules' => array(
		'respons' 	=> array('text' =>  'city'), 
		'http_code' => array('text' =>  0), 
	), 
);

$sdata->setRules($ProxyRotation);

while (TRUE) {
	$url[] = array(
		'url' => 'http://ip-api.com/json/',
		'note' => $emailnya, 
	);
	$res = $sdata->sdata($url);unset($url);
	foreach ($res as $key => $value) {
		print_r($value);
		$json = json_decode($value[respons],true);
		echo $json['query']."\r\n";
	}
}
```

## Copyright and license

Code and documentation copyright 2017 the [Eka Syahwan](https://facebook.com/eka.syahwan.id) (Sdata author) Code released under the MIT License. Docs released under Creative Commons.
