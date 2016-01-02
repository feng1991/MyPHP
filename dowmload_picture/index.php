<?php

	/**
	 * download imgage in urls
	 */
	class DownLoadImg{

		protected $urls;

		/**
		 * Need urls to download
		 */
		public function __construct($urls = false){
			header('content-type:text/html;charset=utf-8');
			if($urls){
				$this->urls = $urls;
			}
		}


		/**
		 * get start
		 */
		public function start(){
			foreach($this->urls as $url){
				$begin_time = microtime(true);
				$text = $this->get_contents($url);
				//Tool::dump($text,true);
				$match = $this->get_img_urls($text);
				//Tool::dump($match);
				$this->save_imgs($url,$match);
				echo sprintf(" DownLoadImg use time:%s\n",microtime(true) - $begin_time);	
			}
		}


		/**
		 * get the html content in the given url
		 */
		protected function get_contents($url){
			return @file_get_contents($url);
		}


		/**
		 * get the url of the imgae using RegExp
		 */
		protected function get_img_urls($text){
			$pattern = '/<img.+src=\"?(.+\.(jpeg|jpg|gif|bmp|bnp|png|gif))\"?.+>/i';
			preg_match_all($pattern,$text,$match);
			return $match;
		}


		/**
		 * save the imgae by the url
		 */
		protected function save_imgs($url,$match){
			$imgs = $match[1];
			$type = $match[2];
			//Tool::dump($imgs,true);
			preg_match('/\w+\:\/\/(.+)\//',$url,$domain);
			//Tool::dump($domain,true);
			$save_path = sprintf("./imgs/%s/",$domain[1]);
			if(!is_dir($save_path)){
				mkdir($save_path,0777,true);
			}
			foreach($imgs as $i => $img){
				!$img && continues;
				//相对地址转换为绝对地址
				if($img[0] == '/'){
					$img = $url.ltrim($img,'/');
				}
				$img_content = @file_get_contents($img);
				!$img_content && continues;
				$new_fileName = $save_path.md5(uniqid('', true)).'.'.$type[$i];
				file_put_contents($new_fileName, $img_content);
			}
		}

	}













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
	 * function tool
	 */
	class Tool{

		static function dump($str,$exit=false){
			header('content-type:text/html;charset=utf-8');
			echo '<pre>';
			var_dump($str);
			echo '</pre>';
			if($exit){
				exit;
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
	exit;



	/**
	 * test
	 */
	$urls = array(
		"http://www.mm131.com/",
		"http://www.mmkaixin.com/",
	);
	$down = new DownLoadImg($urls);
	$down->start();
	
	

	
	