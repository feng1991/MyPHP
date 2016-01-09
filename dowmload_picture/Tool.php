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
		 * make log
		 */ 
		static function log($str , $fileName=false){
			date_default_timezone_set('PRC');
			$time = date('Y-m-d-H-i-s');
			$log = sprintf("Time:%s , %s\n\n",$time,$str);
			$fp = fopen($fileName,"a+");
			flock($fp, LOCK_EX);
			fwrite($fp,$log);
			flock($fp, LOCK_UN);
			fclose($fp);
		}



		/**
		 * curl
		 */ 
		static function php_curl($url, $data = array(), $timeout = 30, $CA = false){   
			$cacert = getcwd() . '/cacert.pem'; 
			$SSL = substr($url, 0, 8) == "https://" ? true : false; 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); 
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout-2); 
			if ($SSL && $CA) { 
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); 
				curl_setopt($ch, CURLOPT_CAINFO, $cacert);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);  
			} else if ($SSL && !$CA) { 
			 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
			 	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); 
			} 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
			if($data){
				curl_setopt($ch, CURLOPT_POST, true); 
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
				//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); //data with URLEncode 
			}
			$ret = curl_exec($ch); 
			//var_dump(curl_error($ch)); 
			curl_close($ch); 
			return $ret;   
		}

	}


