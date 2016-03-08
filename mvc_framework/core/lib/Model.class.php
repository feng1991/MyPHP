<?php
	
	class Model{

		protected $db;
		protected $tableName;
		protected $where;
		protected $join;
		protected $group;
		protected $having;
		protected $limit;

		/**
		 * connetct the database
		 */
		public function __construct($tableName){
			$database = Tool::c('database');
			$this->db = new PDO($database['dsn'],$database['user'],$database['password']);			
			if(!$tableName){
				throw new Exception('Model need tableName');
			}
			$this->tableName = $tableName;
			return $this->db;
		}


		/**
		 * set limit
		 */
		public function limit($start,$end=false){
			if(!$start){
				return false;
			}
			$start = intval($start);
			if(!$end){
				$this->limit = 'limit '.$start;
			}else{
				$end = intval($end);
				$this->limit = 'limit '.$start.','.$end;
			}
			return $this->db;
		}


		/**
		 * return all result
		 */
		public function select(){
			$sql = sprintf('select * from %s %s',$this->tableName,$this->limit);
			$pdoState = $this->db->query($sql);
			//Tool::d($sql,1);
			$result = $pdoState->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}


		/**
		 * return one result
		 */
		public function find(){
			$result = $this->select();
			if(is_array($result)){
				return $result[0];
			}else{
				return false;
			}
		}
	}