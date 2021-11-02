<?php

// No direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';
require_once(JPATH_SITE.'/components/com_jsn/helpers/helper.php');


$usersID = JAccess::getUsersByGroup($params->get('groupid'));
$users = array();
foreach($usersID as $cUserID) {
	$users[] = JFactory::getUser($cUserID);
}

$i = 0;
foreach($users as $user) {
	$tempUser = new JsnUser($user->id);

	if(!empty($tempUser->getValue('gruppenfunktion'))) {
		// Gruppenfunktion IST definiert
		$tempUser->gruppenfunktion = $tempUser->getValue('gruppenfunktion');
	}
	else {
		// Gruppenfunktion ist NICHT definiert
		if(!empty($tempUser->getValue('position')) && !empty($tempUser->getValue('bereich'))) {
			$tempUser->gruppenfunktion = $tempUser->getValue('position') . ' ' . $tempUser->getValue('bereich') . ' ' . $tempUser->getValue('abteilung');
		}

	}

	if(empty($tempUser->getValue('kontaktseite'))) {
			$tempUser->kontaktadresse = $params->get('defaultContactAddress');
	}
	else {
		$tempUser->kontaktadresse = $tempUser->getValue('kontaktseite');
	}

	if(is_numeric($tempUser->getValue('facebook'))) {
		$tempUser->facebook = 'profile.php?id=' . $tempUser->getValue('facebook');
	}

	// Save user object back to array
	$users[$i] = $tempUser;
	$i++;
}


// Render output
//require JModuleHelper::getLayoutPath('mod_hrz_jsn_group');
$layout = $params->get('layout');
require(JModuleHelper::getLayoutPath('mod_hrz_jsn_group', $layout ));
