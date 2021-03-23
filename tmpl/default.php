<?php 
// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
$document = Factory::getDocument();
$document->addStyleSheet(JURI::base().'modules/'.$module->module . '/css/style.css');

foreach($users as $user) {
	$user=new JsnUser($user->id);

	if(!empty($user->getValue('gruppenfunktion'))) {
		// Gruppenfunktion IST definiert
		$user->funktion = $user->getValue('gruppenfunktion');
	}
	else {
		// Gruppenfunktion ist NICHT definiert
		if(!empty($user->getValue('position')) && !empty($user->getValue('bereich')))  {
			$user->funktion = $user->getValue('position') . ' ' . $user->getValue('bereich') . ' ' . $user->getValue('abteilung');
		}

	}
	
	if(!empty($user->getValue('kontaktseite'))) {
		// Kontaktseite IST definiert
		if(!empty($user->getValue('convert_forms_contact_id')) && !empty($params->get('parameterName'))) {
			$user->kontaktadresse = $user->getValue('kontaktseite') . '?' . $params->get('parameterName') . '=' . $user->getValue('convert_forms_contact_id');
		}
		else {
			$user->kontaktadresse = $user->getValue('kontaktseite');
		}
	}
	else {

		if(!empty($user->getValue('convert_forms_contact_id')) && !empty($params->get('parameterName'))) {
			$user->kontaktadresse = $params->get('defaultContactAddress') . '?' . $params->get('parameterName') . '=' . $user->getValue('convert_forms_contact_id');
		}
		else {
			$user->kontaktadresse = $params->get('defaultContactAddress');
		}
	}


!empty(parse_url($user->kontaktadresse)['query']) ? $user->kontaktadresse .= '&' : $user->kontaktadresse .= '?';

$user->kontaktadresse .= 'uid='.$user->getValue('id');
	

	
?>
<!--<div class="jsn_group_single_profile_wrapper" style="width: <?=100/$params->get('maxElementsInRow');?>%">-->
<div class="jsn_group_single_profile_wrapper jsn_group_col_<?=count($users)>$params->get('maxElementsInRow') ? $params->get('maxElementsInRow') : count($users);?>">
	<div class="jsn_group_profile_wrapper" >
		<div class="jsn_group_profile_avatar jsn_group_profile">
			<img src="/<?=$user->getValue('avatar');?>" />
		</div>
		<div class="jsn_group_profile_overlay">
			<div class="jsn_group_profile_name jsn_group_profile">
				<span><?=$user->getValue('firstname') . ' ' . $user->getValue('lastname');?></span>
			</div>
			<div class="jsn_group_profile_line"></div>
			<div class="jsn_group_profile_bereich jsn_group_profile">
				<?=$user->funktion;?>
			</div>
			<div class="jsn_group_profile_contact jsn_group_profile">
				<div class="jsn_group_profile_contact_icon">
					<div class="jsn_group_profile_contact_icon_mail_desktop">
						<a href="<?=$user->kontaktadresse;?>" target="_blank">
							<i class="fa fa-envelope"></i>
						</a>
					</div>
					<div class="jsn_group_profile_contact_icon_mail_mobile">
						<a href="<?=$user->kontaktadresse;?>" target="_blank">
							<i class="fa fa-envelope"></i>
						</a>
					</div>
					<a href="tel:<?=$user->getValue('telefonnummer');?>">
						<i class="fa fa-phone"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>


<?php

}
?>
