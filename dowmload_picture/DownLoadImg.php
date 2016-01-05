<?php


	/**
	 * download imgage in urls
	 */
	class DownLoadImg{

		protected $urls;
		protected $done_urls;
		protected $undone_urls;
		protected $done_imgs;
		protected $undone_imgs;


		/**
		 * Need urls to download
		 */
		public function __construct($urls = false){
			header('content-type:text/html;charset=utf-8');
			if($urls){
				$this->urls = $urls;
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
					$do_url = array_pop($this->undone_urls);
					$text = $this->get_contents($do_url);
					$this->get_link_url($text);
					$match = $this->get_img_urls($text);
					$this->save_imgs($url,$match);
					array_push($this->done_urls,$do_url);
				}
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
		 * get the url of the link using RegExp
		 */
		protected function get_link_url($text){
			$pattern = '/<a.+href=\"?([^\"]+)\"?(>|\s+\w*>)/i';
			preg_match_all($pattern,$text,$match);
			if($match){
				$links = $match[1];
				//Tool::dump($match,true);
				foreach($links as $link){
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
				if($img[0] == '/' || $imgs[0] == '.'){
					$img = $url.ltrim($img,'./');
				}
				$img_content = @file_get_contents($img);
				!$img_content && continues;
				$new_fileName = $save_path.md5(uniqid('', true)).'.'.$type[$i];
				file_put_contents($new_fileName, $img_content);
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
	 * test
	 */
	$urls = array(
		"http://www.mm131.com/",
		//"http://www.mmkaixin.com/",
		//'http://tu.duowan.com',
	);
	$down = new DownLoadImg($urls);
	$down->start();


	
	

	
	