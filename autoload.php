<?php

spl_autoload_register(function($class){
	    $dirs = ['/app/', '/src/Model/', '/src/Http/', '/src/', '/tests/', 'src/Exception/', '/'];
	    foreach ($dirs as $dir) {
	    	$path = __DIR__.$dir.str_replace(['\\','_'], '/', $class).'.php';
	    	if(file_exists($path)){
	    		var_dump($path);
	    		require_once($path);
	    	}
	    }
	}
);