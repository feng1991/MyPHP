<?php
	class Tool{

		/**
		 * var_dump a variable in a better way
		 */
		static public function d($var,$exit=false){
			echo "<pre>";
			var_dump($var);
			echo "</pre>";
			if($exit){
				exit;
			}
		}

		/**
		 * set and get config
		 */
		static public function c($name=false,$value=false,$set=false){
			static $config = null;
			if($set){
				return $config = $set;
			}
			if($name){
				if($value){
					return $config[$name] = $value;
				}
				return $config[$name];
			}
		}


		/**
		 * print the exception message
		 */
		static public function e($e){
			//self::d($e);exit;
			$html = file_get_contents('./core/view/exception.html');
			$html = str_replace('{$message}',$e->getmessage(),$html);
			$trace = implode('<br/>#',explode('#',$e->getTraceAsString()));
			$html = str_replace('{$trace}',$trace,$html);
			echo $html;
		}
	}