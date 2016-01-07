<?php
	

	/**
	 * function tool
	 */
	class Tool{

		/**
		 * var_dump with format
		 */ 
		static function dump($str,$exit=false){
			//header('content-type:text/html;charset=utf-8');
			echo '<pre>';
			var_dump($str);
			echo '</pre>';
			if($exit){
				exit;
			}
		}


		/**
		 * curl
		 */ 
		static function php_curl($url, $data = array(), $timeout = 30, $CA = false){   

			$cacert = getcwd() . '/cacert.pem'; //CA根证书 
			$SSL = substr($url, 0, 8) == "https://" ? true : false; 

			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); 
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout-2); 
			if ($SSL && $CA) { 
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);   // 只信任CA颁布的证书 
				curl_setopt($ch, CURLOPT_CAINFO, $cacert); // CA根证书（用来验证的网站证书是否是CA颁布） 
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名，并且是否与提供的主机名匹配 
			} else if ($SSL && !$CA) { 
			 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书 
			 	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 检查证书中是否设置域名 
			} 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:')); //避免data数据过长问题 
			if($data){
				curl_setopt($ch, CURLOPT_POST, true); 
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
				//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); //data with URLEncode 
			}
			$ret = curl_exec($ch); 
			//var_dump(curl_error($ch));  //查看报错信息 

			curl_close($ch); 
			return $ret;   
		}

	}




	//test imgs
	$imgs = array(
		'http://img1.mm131.com/tupai/f1.jpg',
		'http://img1.mm131.com/tupai/f2.jpg',
		'http://img1.mm131.com/tupai/f3.jpg',
		'http://img1.mm131.com/tupai/f4.jpg',
	);

	$time1 = microtime(true);
	$res = Tool::php_curl($imgs[0]);
	$res = Tool::php_curl($imgs[1]);
	$res = Tool::php_curl($imgs[2]);
	$res = Tool::php_curl($imgs[3]);
	$time2 = microtime(true);
	echo 'time:'.($time2 - $time1).'<br/>';
	file_put_contents('./1.jpg', $res);
	//Tool::dump($res);

	$time3 = microtime(true);
	$res2 = file_get_contents($imgs[0]);
	$res2 = file_get_contents($imgs[1]);
	$res2 = file_get_contents($imgs[2]);
	$res2 = file_get_contents($imgs[3]);
	$time4 = microtime(true);
	echo 'time:'.($time4 - $time3);
	//Tool::dump($res2);
	file_put_contents('./2.jpg', $res2);



