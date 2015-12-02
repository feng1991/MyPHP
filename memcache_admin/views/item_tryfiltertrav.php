<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style>
		#search{
			padding:8px;
			margin:15px 5px;
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
		.origin,.dump,.unserialize{
			color:blue;
		}
		.origin:hover,.dump:hover,.unserialize:hover{
			cursor:pointer;
		}
		.dump_value,.unser_value{
			display:none;
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
	function dump($var,$exit=false){
		echo "<pre>";
		var_dump($var);
		echo "</pre>";
		if($exit){
			exit;
		}
	}

	if($_POST['submit']){
		$ip = $_POST['ip'];
		$port = $_POST['port'];
		$s_key = $_POST['key'];
		$s_value = $_POST['value'];
		$ip_port = $ip.":{$port}";
		$count = 0;

		$mem = new Memcache();
		$mem->addServer($ip,$port,true);
		//获得有值的slabs
		$items = $mem->getExtendedStats('items');
	    $items = $items[$ip_port]['items'];
	    foreach ($items as $key=>$values){
	    	//获得每个slabs的内容
	        $str = $mem->getExtendedStats('cachedump',$key,0);
	        $line = $str[$ip_port];
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
	                $count++;
	                //将过滤后的值输出
	                $unser_value = unserialize($value);
	                ?>
	                <div class='result'>
	                	<span class='key'><?php echo 'NO.'.$count.' : '.$k; ?></span>:<br/><br/>
	                	<span class="value"><?php echo $value; ?></span><br/>
	                	<span class="dump_value"><?php dump($value); ?></span><br/>
	                	<span class="unser_value"><?php dump($unser_value); ?></span><br/>
	                	<span class="origin">原样</span>
	                	<span class="dump">打印</span>
	                	<span class="unserialize">反序列化</span>
	                </div>
	                <?php
	            }
	        }
	    }
	}
?>

<script type="text/javascript" src="../include/js/jquery-1.6.1.min.js"></script>
<script>
	$('.origin').click(function(){
		$(this).parent('.result').find('.value').show();
		$(this).parent('.result').find('.dump_value').hide();
		$(this).parent('.result').find('.unser_value').hide();
	});
	$('.dump').click(function(){
		$(this).parent('.result').find('.value').hide();
		$(this).parent('.result').find('.dump_value').show();
		$(this).parent('.result').find('.unser_value').hide();
	});
	$('.unserialize').click(function(){
		$(this).parent('.result').find('.value').hide();
		$(this).parent('.result').find('.dump_value').hide();
		$(this).parent('.result').find('.unser_value').show();
	});
</script>



