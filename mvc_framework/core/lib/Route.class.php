<?php
	class Route{

		/**
		 * parse the url and define group,controller,method
		 */
		public function parse(){
			//Tool::d($_SERVER);
			$pathinfo = strtolower(trim($_SERVER['PATH_INFO'],'/'));
			$pathinfo = explode('/',$pathinfo);
			Tool::d($pathinfo);
		}
	}
