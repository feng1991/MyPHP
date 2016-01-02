<?php

/**
 * 多线程加速
 * 写成类的形式
 * js加载的图片怎么取
 * 相关链接 爬取
 * 输入网址后打包成压缩文件并下载
 */

	function dump($str,$exit=false){
		header('content-type:text/html;charset=utf-8');
		echo '<pre>';
		var_dump($str);
		echo '</pre>';
		if($exit){
			exit;
		}
	}


	

	
	$urls = array(
		"http://www.wmpic.me/tupian/yijing/",
		"http://huaban.com/",
	);
	foreach($urls as $url){

		$begin_time = microtime(true);

		//1.获得内容
		$text = file_get_contents($url);
		//dump($text,true);
		
		//2.获得图片地址
		$pattern = '/<img.+src=\"?(.+\.(jpeg|jpg|gif|bmp|bnp|png))\"?.+>/i';
		preg_match_all($pattern,$text,$match);
		$imgs = $match[1];
		$type = $match[2];
		//dump($match);
		//dump($imgs,true);

		//3.保存图片到本地
		preg_match('/\w+\:\/\/(.+)\//',$url,$domain);
		//dump($domain,true);
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
			$img_content = file_get_contents($img);
			!$img_content && continues;
			$new_fileName = $save_path.md5(uniqid('', true)).'.'.$type[$i];
			file_put_contents($new_fileName, $img_content);
			//exit;
		}

		echo sprintf("use time:%s\n",microtime(true) - $begin_time);	
	}
	
	

	
	