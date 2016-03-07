<?php
	
	class Model{

		protected $db;
		protected $tableName;
		protected $where;
		protected $join;
		protected $group;
		protected $having;
		protected $limit;

		public function __construct($tableName){
			
			if(!$tableName){
				throw new Exception('Model need tableName');
			}
			$this->tableName = $tableName;
		}
	}