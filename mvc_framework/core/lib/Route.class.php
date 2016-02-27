<?php
	class Route{

		/**
		 * parse the url and define group,controller,method
		 */
		static public function parse(){
			$pathinfo = strtolower(trim($_SERVER['PATH_INFO'],'/'));
			$pathinfo && $pathinfo = explode('/',$pathinfo);
			$len = count($pathinfo);
			if($len < 3){
				throw new Exception("Need group or controller or method!");
			}
			define('APP_GROUP',$pathinfo[0]);
			define('APP_CONTROLLER',$pathinfo[1]);
			define('APP_METHOD',$pathinfo[2]);
			for($i = 3;$i < $len-1 && $len > 1;$i = $i+2){
				$_GET[$pathinfo[$i]] = $pathinfo[$i+1];
			}
			$_REQUEST = array_merge($_GET,$_POST);
		}
	}
