<?php

	/**
	 * This is a test file.
	 */

	require_once "AsyncDownLoadImg.php";



	/**
	 * test tool
	 */
	
	// $imgs = array(
	// 	'http://img1.mm131.com/tupai/f1.jpg',
	// 	'http://img1.mm131.com/tupai/f2.jpg',
	// 	'http://img1.mm131.com/tupai/f3.jpg',
	// 	'http://img1.mm131.com/tupai/f4.jpg',
	// );

	// $time1 = microtime(true);
	// $res = Tool::php_curl($imgs[0]);
	// $res = Tool::php_curl($imgs[1]);
	// $res = Tool::php_curl($imgs[2]);
	// $res = Tool::php_curl($imgs[3]);
	// $time2 = microtime(true);
	// echo 'time:'.($time2 - $time1).'<br/>';
	// file_put_contents('./1.jpg', $res);
	// //Tool::dump($res);

	// $time3 = microtime(true);
	// $res2 = file_get_contents($imgs[0]);
	// $res2 = file_get_contents($imgs[1]);
	// $res2 = file_get_contents($imgs[2]);
	// $res2 = file_get_contents($imgs[3]);
	// $time4 = microtime(true);
	// echo 'time:'.($time4 - $time3);
	// //Tool::dump($res2);
	// file_put_contents('./2.jpg', $res2);
	//exit;







	/**
	 * test DownLoadImg
	 */
	
	// $urls = array(
	// 	//'http://www.renti114.com/',//lost big pic
	// 	//'http://www.22mm.cc/',
	// 	//'http://www.yneol.com.cn/hot',
	// 	//'http://tu.duowan.com/',
	// 	//'http://www.uumnt.com/'
	// 	//"http://www.mm131.com/",
	// 	// "http://www.mmkaixin.com/",
	// 	'http://www.17786.com/',//4882
	// );
	
	// $down = new DownLoadImg($urls,true);
	// $down->start();
	// exit;










	/**
	 * test mutil-threads DownLoadImg 
	 */
	
	// $urls = array(
	// 	array("http://www.mm131.com/"),
	// 	array("http://www.mmkaixin.com/"),
	// );
	// $down = new AsyncDownLoadImg($urls);
	// $down->async_start();
	//exit;



