<?php

	require "includes/tools_init.php";

	logstr("Testing environment...", 'system');
	logstr("Step #1. Path permissions", 'system');

	$directories = ['cache/logs',
					'cache/minification',
					'cache/system_cache',
					'cache/templates_cache',
					'cache/templates_compiled',
					'app/public/css/dist',
					'app/public/scripts/dist',
					'app/public/uploads'];

	foreach ($directories as $dir) {

		$writable_by_world = false;
		$is_dir = false;

		if (is_dir(SITE_PATH.DIRECTORY_SEPARATOR.$dir))
		{
			$is_dir = true;
			/// @todo: really, need to check if it's writable by apache user
			$p = fileperms(SITE_PATH.DIRECTORY_SEPARATOR.$dir);
			$writable_by_world = ($p & 0x0002) ? true : false;
			$writable_by_group = ($p & 0x0010) ? true : false;
			$writable_by_owner = ($p & 0x0080) ? true : false;
		}

		if ($is_dir && $writable_by_world)
			logstr("Path '".$dir."' exists and is writable. OK", 'system');
		elseif (!$is_dir)
			logstr("Path '".$dir."' doesn't exist. \033[1;31mERROR\033[0m", 'system');
		else
			logstr("Path '".$dir."' is not writable. chmod it. \033[1;31mERROR\033[0m", 'system');
	}

	logstr("Step #2. Database", 'system');

	$db = db::getInstance();
	if ($db->IsConnected())
		logstr("Connected to database ".__db_database__."@".__db_host__.". OK", 'system');
	else
		logstr("Can not connect to database ".__db_database__."@".__db_host__.". \033[1;31mERROR\033[0m", 'system');

	logstr("Step #3. Is uglifyjs installed", 'system');

	$output = [];
	exec('uglifyjs -V 2>&1', $output);
	$installed = false;
	if (isset($output[0]) && preg_match('/^(uglify-js )?[0-9\.]+$/i', $output[0]))
		$installed = true;

	if (!$installed)
	{
		logstr("uglifyjs is not installed. Run `npm install uglify-js -g` \033[1;31mERROR\033[0m", 'system');
	} else {
		logstr("uglifyjs is installed.  OK", 'system');		
	}

	logstr("Step #4. Is lessc installed", 'system');

	$output = [];
	exec('lessc -v 2>&1', $output);
	$installed = false;
	if (isset($output[0]) && preg_match('/^(lessc) [0-9\.]+/i', $output[0]))
		$installed = true;

	if (!$installed)
	{
		logstr("lessc is not installed. Run `npm install -g less` \033[1;31mERROR\033[0m", 'system');
	} else {
		logstr("lessc is installed.  OK", 'system');		
	}

    logstr("Step #4. Is cleancss installed", 'system');
  
    $output = [];
    exec('cleancss -v 2>&1', $output);
    $installed = false;
    if (isset($output[0]) && preg_match('/^[0-9\.]+$/i', $output[0]))
        $installed = true;
  
    if (!$installed)
    {
        logstr("cleancss is not installed. Run `npm install -g clean-css` \033[1;31mERROR\033[0m", 'system');
    } else {
        logstr("cleancss is installed.  OK", 'system');     
    }

	logstr("Done.", 'system');	