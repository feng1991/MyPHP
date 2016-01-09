<?php

	require_once "Tool.php";

	/**
	 * download imgage in urls
	 */
	class DownLoadImg{

		protected $method;
		protected $log_file;
		protected $urls;
		protected $done_urls;
		protected $undone_urls;
		protected $done_imgs;

		/**
		 * Need urls to download
		 */
		public function __construct($urls = false,$curl = false){
			header('content-type:text/html;charset=utf-8');
			date_default_timezone_set('PRC');
			if($urls){
				$this->urls = $urls;
			}
			if($curl){
				$this->method = 1;
			}else{
				$this->method = 0;
			}
			$this->done_urls = array();
			$this->undone_urls = array();
			$this->done_imgs = array();
			$this->undone_imgs = array();
		}


		/**
		 * get start
		 */
		public function start(){
			foreach($this->urls as $url){
				$begin_time = microtime(true);
				array_push($this->undone_urls,$url);
				while(!empty($this->undone_urls)){
					$do_url = array_shift($this->undone_urls);
					$this->make_log('Begin url:'.$do_url);
					$text = $this->get_contents($do_url);
					$this->get_link_url($do_url,$text);
					$match = $this->get_img_urls($text);
					$this->save_imgs($url,$match);
					array_push($this->done_urls,$do_url);
				}
				echo sprintf(" DownLoadImg use time:%s\n",microtime(true) - $begin_time);	
			}
		}


		/**
		 * get the content in the given url
		 */
		protected function make_log($str){
			if(!$this->log_file){
				$time = date('Y-m-d-H-i-s');
				$this->log_file = sprintf('./%s_log.txt',$time);
			}
			Tool::log($str,$this->log_file);
		}


		/**
		 * get the content in the given url
		 */
		protected function get_contents($url){
			if($this->method == 0){
				$text = @file_get_contents($url);
			}else{
				$text = Tool::php_curl($url);
			}
			//Tool::dump($text,true);
			return $text;
		}


		/**
		 * get the url of the link using RegExp
		 */
		protected function get_link_url($url,$text){
			$this->make_log('Begin link');
			$pattern = '/<a[^<]+href=\"?([^\"<]+)\"?[^<]*>/i';
			preg_match_all($pattern,$text,$match);
			if($match){
				$links = $match[1];
				//Tool::dump($match,true);
				foreach($links as $link){
					if($link[0] == '/' || $link[0] == '.'){
						$link = $url.ltrim($link,'./');
					}
					if(!in_array($link,$this->undone_urls) && !in_array($link,$this->done_urls)){
						array_push($this->undone_urls,$link);
					}
				}
			}
			//Tool::dump($this->undone_urls,true);
		}


		/**
		 * get the url of the imgae using RegExp
		 */
		protected function get_img_urls($text){
			$this->make_log('Begin img_url');
			$pattern = '/<img[^<]+src=\"?([^<]+\.(jpeg|jpg|gif|bmp|bnp|png|gif))\"?[^<]*>/i';
			preg_match_all($pattern,$text,$match);
			//Tool::dump($match,true);
			return $match;
		}


		/**
		 * save the imgae by the url
		 */
		protected function save_imgs($url,$match){
			$this->make_log('Begin save_img_url');
			if(!$match){
				return false;
			}
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
				if(!$img)  continue;
				if($img[0] == '/' || $imgs[0] == '.'){
					$img = $url.ltrim($img,'./');
				}
				if(in_array($img,$this->done_imgs)){
					continue;
				}
				$img_content = $this->get_contents($img);
				if(!$img_content)  continue;
				$this->make_log('downloading img_url:'.$img);
				$new_fileName = $save_path.md5(uniqid('', true)).'.'.$type[$i];
				file_put_contents($new_fileName, $img_content);
				array_push($this->done_imgs,$img);
			}
		}
	}