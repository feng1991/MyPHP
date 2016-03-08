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
			unset($var,$exit);
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
			unset($e,$trace);
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
			unset($group);
			return $controller;
		}


		/**
		 * new a model 
		 */
		static public function m($tableName){
			static $models = array();
			if(!$models[$tableName]){
				$models[$tableName] = new Model($tableName);
			}
			return $models[$tableName];
		}


		/**
		 * write log
		 */
		static public function l($text,$file=false){
			if(!is_dir(APPLICATION_LOG)){
				mkdir(APPLICATION_LOG,0777,true);
			}
			if(!$file){
				$file = APPLICATION_DEFAULT_LOG;
			}
			$file = APPLICATION_LOG.$file;
			$time = date('Y-m-d H:i:s');
			$content = sprintf("Time: %s \nContent: %s \n\n",$time,$text);
			file_put_contents($file, $content,FILE_APPEND);
			unset($text,$file,$time,$content);
		}


		/**
		 * add a path into the included path
		 */
		static public function register_path($path){
			set_include_path(get_include_path() . PATH_SEPARATOR . $path);
			unset($path);
		}


		/**
		 * uppercase the first letter of the word
		 */
		static public function upper_first($word){
			$word[0] = strtoupper($word[0]);
			return $word;
		}
	}