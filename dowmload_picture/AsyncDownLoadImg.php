<?php

	require_once "Tool.php";
	require_once "DownLoadImg.php";

	/**
	 * download imgage in urls using muti-threads
	 */
	class AsyncDownLoadImgBasic extends Thread { 

	      public function __construct($arg){  
	        $this->arg = $arg;  
	      }  
	      
	      public function run(){  
	        if($this->arg){
	        	$down = new DownLoadImg($this->arg);
				$down->start();
	        }  
	     }  
	}



	/**
	 * download imgage in urls using muti-threads
	 */
	class AsyncDownLoadImg{

		protected $urls;

		public function __construct($urls){  
		   $this->urls = $urls;  
		}  

		public function async_start(){  
			if($this->urls){
				$threads = array();
				foreach($this->urls as $url){
					$threads[] = new AsyncDownLoadImgBasic($url);   
				}
				$begin = microtime(true);
				//start a thread
				foreach ($threads as $work) {
				    $work->start();
				}
				//wait the thread end
				foreach($threads as $work){
					while ($work->isRunning()) {
				         usleep(10);
				     }
				    $work->join();
				}
				echo "Time:".(microtime(true)-$begin);
			}  
		}  
	}

	











	

	/**
	 * mutil-threads test
	 */
	$urls = array(
		array("http://www.mm131.com/"),
		array("http://www.mmkaixin.com/"),
	);
	$down = new AsyncDownLoadImg($urls);
	$down->async_start();
	



	
	

	
	