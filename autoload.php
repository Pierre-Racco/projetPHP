<?php

/* register autoloader here */

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

// $my_hugeautoloader = function ($className)//& pour la lecture ET l'écriture
// {
//     $directories = [__DIR__.'/src', __DIR__.'/tests'];


//     foreach ($directories as $dir) {
//         // tests + inclusion pour le répertoire courant
//         $file = $dir . '/' . str_replace(['\\', '_'], '/', $className) . '.php';

//         if (file_exists($file)) {
//             require_once $file;
//             break;
//         }
//     }
    
// };
// spl_autoload_register($my_hugeautoloader);