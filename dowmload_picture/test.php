<?php

	/**
	 * This is a test file.
	 */
	//require_once "AsyncDownLoadImg.php";
	require_once "DownLoadImg.php";

	$urls = array(
		'http://www.meituba.com/',
		'http://photo.sina.com.cn/',
	);
	
	// test DownLoadImg
	$down = new DownLoadImg($urls,true);
	$down->start();
	exit;

	// test mutil-threads DownLoadImg 	
	// $down = new AsyncDownLoadImg($urls);
	// $down->async_start();
	// exit;