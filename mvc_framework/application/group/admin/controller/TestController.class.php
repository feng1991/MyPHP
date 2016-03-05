<?php
	class TestController extends Controller{

		public function test(){
			Tool::d($_GET);
			//$this->json_out(null,2,'',true);
			$this->json_out($_GET);
			Tool::d($this->get('name','strtoupper'));
			Tool::d($this->post('name','',3));
			Tool::d($this->request('name'));
			Tool::l('hi');
		}
	}