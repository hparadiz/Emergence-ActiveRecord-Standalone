<?php
define('classes_directory',$_SERVER['DOCUMENT_ROOT'].'/examples/');

function autoloader($class)
{
	/* All Classes */
	$file = classes_directory.$class.'.class.php';
	if(is_readable($file))
	{
		include($file);
	}
	
	// for ActiveRecord
	if(method_exists($class, '__classLoaded'))
	{
		call_user_func(array($class, '__classLoaded'));
	}
}

spl_autoload_register('autoloader');