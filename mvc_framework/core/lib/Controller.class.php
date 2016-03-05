<?php
	class Controller{

		/**
		 *  get the input by get method
		 */
		public function get($name,$fun=false,$default=null){
			return $this->getinput($name,$fun,$default,1);
		}


		/**
		 *  get the input by post method
		 */
		public function post($name,$fun=false,$default=null){
			return $this->getinput($name,$fun,$default,2);
		}


		/**
		 *  get the input by request method
		 */
		public function request($name,$fun=false,$default=null){
			return $this->getinput($name,$fun,$default,0);
		}


		/**
		 *  get the input
		 */
		private function getinput($name,$fun=false,$default=null,$type=0){
			if(!$name){
				return false;
			}
			if($type == 1){
				$value = $_GET[$name];
			}elseif($type == 2){
				$value = $_POST[$name];
			}else{
				$value = $_REQUEST[$name];
			}
			if($value === null && $default !== null){
				$value = $default;
			}
			if(function_exists($fun)){
				$value = $fun($value);
			}
			return $value;
		}


		/**
		 * output the result by the form of json 
		 */
		public function json_out($data,$status=1,$msg='',$exit=false){
			$out = array(
				'status' => $status,
				'msg' => $msg,
				'data' => $data
			);
			echo json_encode($out);
			if($exit){
				exit;
			}
		}
	}