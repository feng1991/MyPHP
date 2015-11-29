<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style>
		#search{
			padding:8px;
			margin:5px;
			background-color: #f2f2f3;
		}
		input{font-size: 14px}
		.search-option{
			padding:8px;
		}
		.result{
			padding:5px;
			margin:5px;
			background-color: #f2f2f3;
		}
	</style>
</head>
<body>
	<form action="" method="post">
		<div id="search">
			<div class="search-option">IP:&#12288;<input type="text" name="ip" value="<?php if($_POST['ip']){echo $_POST['ip'];}else{echo "127.0.0.1";} ?>"></div>
			<div class="search-option">PORT:&#12288;<input type="text" name="port" value="<?php if($_POST['ip']){echo $_POST['port'];}else{echo "11211";} ?>"></div>
			<div class="search-option">KEY:&#12288;<input type="text" name="key" value="<?php if($_POST['ip']){echo $_POST['key'];} ?>"></div>
			<div class="search-option">VALUE:&#12288;<input type="text" name="value" value="<?php if($_POST['ip']){echo $_POST['value'];} ?>"></div>
			<input type="hidden" name="type" value="con">
			<input type="hidden" name="num" value="0">
			<input type="hidden" name="action" value="tryfiltertrav">
			<div class="search-option"><input class="but" name="submit" type="submit" value="查询"/></div>
		</div>
	</form>
</body>
</html>


<?php
	function dump($var){
		echo "<pre>";
		var_dump($var);
		echo "</pre>";
		exit;
	}

	if($_POST['submit']){
		$ip = $_POST['ip'];
		$port = $_POST['port'];
		$s_key = $_POST['key'];
		$s_value = $_POST['value'];

		$mem = new Memcache();
		$mem->addServer($ip,$port,true);
		//获得有值的slabs
		$items = $mem->getExtendedStats('items');
	    $items = $items[$ip.":{$port}"]['items'];
	    foreach ($items as $key=>$values){
	    	//获得每个slabs的内容
	        $str = $mem->getExtendedStats('cachedump',$key,0);
	        $line = $str[$ip.":{$port}"];
	        if (is_array($line) && count($line)>0){
	            foreach ($line as $k=>$v){
	            	//过滤不合条件的键值
	                if($s_key){
	                	if(false === strpos($k,$s_key)){
	                		continue;
	                	}
	                }
	                $value = $mem->get($k);
	                if($s_value){
	                	if(false === strpos($value,$s_value)){
	                		continue;
	                	}
	                }
	                echo "<div class='result'>".$k.':'.$value.'</div>';
	            }
	        }
	    }
	}
?>