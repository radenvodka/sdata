<?php
error_reporting(0);
/**
 * @Author: Eka Syahwan
 * @Date:   2017-11-06 22:54:36
 * @Last Modified by:   Nokia 1337
 * @Last Modified time: 2019-08-17 01:56:44
 */
class Sdata
{
	public function setRules($rules = null){
		
		if(file_exists($rules[proxy][file])){
			$this->setNewProxy();
			return $this->proxy_rules = $rules;
		}

	}
	public function setNewProxy(){
		$bl 	= file_get_contents("proxy-blacklist.txt");
		$file 	= file_get_contents($this->proxy_rules['proxy']['file']);
		$file 	= explode("\r\n", $file);
		for ($i=0; $i <12; $i++) { 
			$proxy = $file[array_rand($file)];
			if(preg_match("/".$proxy."/", $bl)){
				break;
			}
			$i++;
		}
		if($proxy){
			file_put_contents("proxy-use.txt", $proxy);
		}
	}
	public function setProxy(){
		$file 	= file_get_contents("proxy-use.txt");
		$file 	= explode(":", $file);
		return array(
			'ip' => $file[0],
			'port' => $file[1], 
		);
	}
	public function sdata($url = null , $custom = null){
		mkdir('cookies'); // pleas don't remove
		$ch 	 	= array();
		$mh 		= curl_multi_init();
		$total 		= count($url);
		$allrespons = array();
		for ($i = 0; $i < $total; $i++) {
			if($url[$i]['cookies']){
				$cookies		= $url[$i]['cookies'];
			}else{
				$cookies 		= 'cookies/shc-'.md5($this->cookies())."-".time().'.txt'; 
			}
			$ch[$i] 			= curl_init();
			$threads[$ch[$i]] 	= array(
				'proses_id' => $i,
				'url' 		=> $url[$i]['url'],
				'cookies' 	=> $cookies, 
				'note' 		=> $url[$i]['note'],
			);
		    curl_setopt($ch[$i], CURLOPT_URL, $url[$i]['url']);
			if($custom[$i]['gzip']){
				curl_setopt($ch[$i], CURLOPT_ENCODING , "gzip");
			}
		    curl_setopt($ch[$i], CURLOPT_HEADER, false);
		    curl_setopt($ch[$i], CURLOPT_COOKIEJAR,  $cookies);
      		curl_setopt($ch[$i], CURLOPT_COOKIEFILE, $cookies);
		    if($custom[$i]['rto']){
		    	curl_setopt($ch[$i], CURLOPT_TIMEOUT, $custom[$i]['rto']);
		    }else{
		    	curl_setopt($ch[$i], CURLOPT_TIMEOUT, 60);
		    }
		    if($custom[$i]['header']){
		    	curl_setopt($ch[$i], CURLOPT_HTTPHEADER, $custom[$i]['header']);
		    }
		    if($custom[$i]['post']){
		    	if(is_array($custom[$i]['post'])){
		    		$query = http_build_query($custom[$i]['post']);
		    	}else{
		    		$query = $custom[$i]['post'];
		    	}
		    	curl_setopt($ch[$i], CURLOPT_POST, true);
		    	curl_setopt($ch[$i], CURLOPT_POSTFIELDS, $query);
		    }
		    if($custom[$i]['proxy']){
		    	curl_setopt($ch[$i], CURLOPT_PROXY, 	$custom[$i]['proxy']['ip']);
		    	curl_setopt($ch[$i], CURLOPT_PROXYPORT, $custom[$i]['proxy']['port']);
		    	if( $custom[$i]['proxy']['type'] ){
		    		curl_setopt($ch[$i], CURLOPT_PROXYTYPE, $custom[$i]['proxy']['type']);
		    	}
		    }
		    if(!empty($this->setProxy())){
		    	$proxy = $this->setProxy();
		    	curl_setopt($ch[$i], CURLOPT_PROXY, 	$proxy['ip']);
		    	curl_setopt($ch[$i], CURLOPT_PROXYPORT, $proxy['port']);
		    }
		    curl_setopt($ch[$i], CURLOPT_VERBOSE, false);
		    curl_setopt($ch[$i], CURLOPT_CONNECTTIMEOUT , 0);
		    curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($ch[$i], CURLOPT_FOLLOWLOCATION, true);
		    curl_setopt($ch[$i], CURLOPT_SSL_VERIFYPEER, false);
		    curl_setopt($ch[$i], CURLOPT_SSL_VERIFYHOST, false); 
        	if($custom[$i]['uagent']){
		    	curl_setopt($ch[$i], CURLOPT_USERAGENT, $custom[$i]['uagent']);
		    }else{
				curl_setopt($ch[$i], CURLOPT_USERAGENT, "Mozilla/5.0 (iPhone; CPU iPhone OS 8_3 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) CriOS/42.0.2311.47 Mobile/12F70 Safari/600.1.4");
		    }
	    	curl_multi_add_handle($mh, $ch[$i]);
		}
		$active = null;
		do {
		    $mrc = curl_multi_exec($mh, $active);
		    while($info = curl_multi_info_read($mh))
		    {	
		    	$threads_data	= $threads[$info['handle']];
		    	$result 		= curl_multi_getcontent($info['handle']);
		       	$info 			= curl_getinfo($info['handle']);

		    	if($this->proxy_rules[proxy][rules][respons]){

		    		if(preg_match("/".$this->proxy_rules[proxy][rules][respons][text]."/", $result)){

			    		$fopnm = fopen("proxy-blacklist.txt", "a+");
			    		fwrite($fopnm , $proxy['ip'].":".$proxy['port']."\r\n");
			    		fclose($fopnm);

			    		$this->setNewProxy();

		    		}

		    	}

		    	if($this->proxy_rules[proxy][rules][http_code]){

		    		if($this->proxy_rules[proxy][rules][http_code]['text'] == $info['http_code']){

			    		$fopnm = fopen("proxy-blacklist.txt", "a+");
			    		fwrite($fopnm , $proxy['ip'].":".$proxy['port']."\r\n");
			    		fclose($fopnm);

			    		$this->setNewProxy();

		    		}

		    	}

		       	$allrespons[] 	= array(
		       		'id' 		=> $threads_data['proses_id'],
		       		'data' 		=> $threads_data, 
		       		'respons' 	=> $result,
		       		'info' 		=> array(
		       			'url' 		=> $info['url'],
		       			'http_code' => $info['http_code'], 
		       		),
		       	);
		        curl_multi_remove_handle($mh, $info['handle']);
		    }
		    usleep(100);
		} while ($active);
		curl_multi_close($mh);

		usort($allrespons, function($a, $b) {
		    return $a['id'] <=> $b['id'];
		});

		return $allrespons;
	}
	public function cookies($length = 60) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString.time().rand(10000000,99999999);
	}
	public function session_remove($arrayrespons){
		foreach ($arrayrespons as $key => $value) {
			unlink($value['data']['cookies']);
		}
	}
	public function aasort (&$array, $key) {
	    $sorter=array();
	    $ret=array();
	    reset($array);
	    foreach ($array as $ii => $va) {
	        $sorter[$ii]=$va[$key];
	    }
	    asort($sorter);
	    foreach ($sorter as $ii => $va) {
	        $ret[$ii]=$array[$ii];
	    }
	    $array=$ret;
	}

}
$sdata = new Sdata();
