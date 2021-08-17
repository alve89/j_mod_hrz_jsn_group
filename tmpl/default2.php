<?php
// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
$document = Factory::getDocument();
$document->addStyleSheet(JURI::base().'modules/'.$module->module . '/css/style.css');


foreach($users as $user) {
	// Retrieve all additional user details like image, social contact information etc.
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
	<div class="jsn_group_profile_wrapper" style="border: 1px solid #cdcdcd; padding-bottom: 20px;">
		<div class="jsn_group_profile_avatar jsn_group_profile">
			<img src="/<?=$user->getValue('avatar');?>" />
		</div>

    <div class="jsn_group_layout2_wrapper">
      <div class="jsn_group_layout2_social_information">
				<?php
				if($params->get('show_social')) {
					if(!empty($user->getValue('instagram'))) { ?>
						<div class="jsn_group_profile_layout2_social jsn_group_profile_layout2_social_instagram" style="color: <?=$params->get('linkcolor');?>;">
							<a href="https://instagram.com/<?=$user->getValue('instagram');?>" target="_blank">
								<i class="fa fa-instagram"></i>
							</a>
						</div>
					<?php }
					if(!empty($user->getValue('facebook'))) { ?>
					<div class="jsn_group_profile_layout2_social jsn_group_profile_layout2_social_facebook" style="color: <?=$params->get('linkcolor');?>;">
						<a href="https://facebook.com/<?=$user->getValue('facebook');?>" target="_blank">
							<i class="fa fa-facebook"></i>
						</a>
					</div>
				<?php } }
				if($params->get('show_mail')) {?>
						<div style="display: inline-block; width: 20px; text-align: left;">
							<a href="<?=$user->kontaktadresse;?>" target="_blank" style="color: <?=$params->get('linkcolor');?>;">
								<i class="fa fa-envelope"></i>
							</a>
						</div>
			<?php }
			if($params->get('show_phone') && !empty($user->getValue('telefonnummer'))) {?>
				<div style="display: inline-block; width: 20px; text-align: left;">
					<a href="tel:<?=$user->getValue('telefonnummer');?>" style="color: <?=$params->get('linkcolor');?>;">
						<i class="fa fa-phone"></i>
					</a>
				</div>
		  <?php } ?>
      </div>
      <div class="jsn_group_layout2_information">
        <div class="jsn_group_layout2_information_inner_wrapper">
          <div style="color: <?=$params->get('fontcolor');?>; height: 28px; padding-left: 10px;">
    				<span><h3><?=$user->getValue('firstname') . ' ' . $user->getValue('lastname');?></h3></span>
    			</div>
          <div style="color: <?=$params->get('fontcolor');?>; padding-left: 10px; ">
    				<span style="font-size: 18px"><?=$user->getValue('responsibilities');?></span>
    			</div>
        </div>
      </div>
    </div>

	</div>
</div>


<?php

}
?>
