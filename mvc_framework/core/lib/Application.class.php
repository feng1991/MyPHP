<?php
	class Application{

		public function start(){
			var_dump($this);

			//register include path
			$this->register_path();
			$this->register_autoload_function();
			$r = new Route();
			var_dump($r);


			//read config

			//define const
			//dispatch
		}


		private function register_path(){
			$path = '/core/lib/';
			set_include_path(get_include_path() . PATH_SEPARATOR . $path);
		}

		private function register_autoload_function(){
			spl_autoload_register(function ($class) {
			    require_once $class . '.class.php';
			});
		}

	}