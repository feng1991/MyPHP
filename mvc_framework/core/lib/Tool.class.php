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
	}