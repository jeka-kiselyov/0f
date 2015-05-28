<?php

	require "includes/tools_init.php";

	logstr('Creating first user...', 'system');

	$m_users = autoloader_get_model_or_class('users');

	$all = $m_users->get_all();

	if ($all && $all->count() > 0)
	{
		logstr("No need. There're users in database already", 'system');
		exit;		
	} else {
		$user = $m_users->register('default', 'admin', 'admin', 'admin@example.com');

		if ($user && $user->id)
		{
			$db = db::getInstance();
			$db->query("UPDATE users SET confirmation_code = '', is_admin = '1' WHERE id = '".(int)$user->id."' LIMIT 1;");
		}	
		
		logstr("Done. Username: admin Password: admin", 'system');	
	}





?>