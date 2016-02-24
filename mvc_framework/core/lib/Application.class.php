<?php
	class Application{

		public function start(){
			//register include path
			$this->register_path();
			$this->register_autoload_function();
			//read config
			$this->read_config();
			//define const

			//dispatch
			$route = new Route();
			$route->parse();
			//run method in controller
		}


		private function register_path(){
			$path = './core/lib/';
			set_include_path(get_include_path() . PATH_SEPARATOR . $path);
			unset($path);
		}

		private function register_autoload_function(){
			spl_autoload_register(function ($class) {
			    require_once $class . '.class.php';
			});
		}

		private function read_config(){
			$path = './core/conf/config.php';
			$config1 = include($path);
			$path = './application/conf/config.php';
			$config2= include($path);
			$config = array_merge($config1,$config2);
			Tool::c(false,false,$config);
		}

	}