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
			$html = file_get_contents(CORE_EXCEPTION_TPL);
			if(self::C('debug')){
				$html = str_replace('{$message}',$e->getmessage(),$html);
				$trace = implode('<br/>#',explode('#',$e->getTraceAsString()));
				$html = str_replace('{$trace}',$trace,$html);
			}
			echo $html;
		}


		/**
		 * new a controller 
		 */
		static public function r($group=false,$controller=false){
			static $groupList = array();
			!$group && $group = APP_GROUP;
			!$controller && $controller = APP_CONTROLLER;
			if(!in_array($group,$groupList)){
				self::register_path(APPLICATION_GROUP_DIR.APP_GROUP.'/'.APPLICATION_CONTROLLER_DIR_NAME);
				$groupList[] = $group;
			}
			$controller = self::upper_first($controller).self::upper_first(APPLICATION_CONTROLLER_DIR_NAME); 
			$controller = new $controller();
			return $controller;
		}


		/**
		 * add a path into the included path
		 */
		static public function register_path($path){
			set_include_path(get_include_path() . PATH_SEPARATOR . $path);
		}


		/**
		 * uppercase the first letter of the word
		 */
		static public function upper_first($word){
			$word[0] = strtoupper($word[0]);
			return $word;
		}
	}