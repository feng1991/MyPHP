<?php
	class Application{

		public function start(){
			try{
				//define const
				$this->define_const();
				//register include path
				$this->register_autoload_function();
				Tool::register_path(CORE_LIB_DIR);
				//read config
				$this->read_config();
				//dispatch
				Route::parse();
				//run method in controller
				$controller = Tool::r();
				//Tool::d($controller);
				$method = APP_METHOD;
				$controller->$method();
			}catch(Exception $e){
				Tool::e($e);
			}
		}


		private function register_autoload_function(){
			spl_autoload_register(function ($class) {
				$fileName = $class . '.class.php';
				@include_once $fileName;
				unset($fileName,$class);
			});
			spl_autoload_register(function ($class) {
			    Tool::e(new Exception("Could not find {$class} class"));
			    exit;
			});
		}


		private function read_config(){
			$config1 = include(CORE_CONFIG);
			$config2= include(APPLICATION_CONFIG);
			$config = array_merge($config1,$config2);
			Tool::c(false,false,$config);
			unset($config1,$config2,$config);
		}


		private function define_const(){
			//name
			define('APPLICATION_CONTROLLER_DIR_NAME','controller');
			//file
			define('CORE_CONFIG','./core/conf/config.php');
			define('APPLICATION_CONFIG','./application/conf/config.php');
			define('APPLICATION_DEFAULT_LOG','log.txt');
			define('CORE_EXCEPTION_TPL','./core/view/exception.html');
			//dir
			define('CORE_LIB_DIR','./core/lib/');
			define('APPLICATION_GROUP_DIR','./application/group/');
			define('APPLICATION_LOG','./application/data/log/');
		}

	}