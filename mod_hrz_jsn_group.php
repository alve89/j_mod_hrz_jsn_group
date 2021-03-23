	<?php

	// No direct access
	defined('_JEXEC') or die;

	// Include the syndicate functions only once
	require_once dirname(__FILE__) . '/helper.php';
	require_once(JPATH_SITE.'/components/com_jsn/helpers/helper.php');


	$usersID = JAccess::getUsersByGroup($params->get('groupid'));
	$users = array();
	foreach($usersID as $cUserID)
	{
		$users[] = JFactory::getUser($cUserID);
	}


	// Render output
	require JModuleHelper::getLayoutPath('mod_hrz_jsn_group');
