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

## Copyright and license

Code and documentation copyright 2017 the [Eka Syahwan](https://facebook.com/eka.syahwan.id) (Sdata author) Code released under the MIT License. Docs released under Creative Commons.
