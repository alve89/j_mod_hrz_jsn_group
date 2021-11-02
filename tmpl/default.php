<?php
// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
$document = Factory::getDocument();
$document->addStyleSheet(JURI::base().'modules/'.$module->module . '/css/style.css');

foreach($users as $user) {

	$cssWrapperWidth = 1;

?>
<!--<div class="jsn_group_single_profile_wrapper" style="width: <?=100/$params->get('maxElementsInRow');?>%">-->
<div class="jsn_group_single_profile_wrapper jsn_group_col_<?=count($users)>$params->get('maxElementsInRow') ? $params->get('maxElementsInRow') : count($users);?>">
	<div class="jsn_group_profile_wrapper" >
		<div class="jsn_group_profile_avatar">
			<img src="/<?=$user->getValue('avatar');?>" />
		</div>
		<div class="jsn_group_profile_overlay" style="background-color: <?=$params->get('backgroundcolor');?>">
			<div class="jsn_group_profile_name" style="color: <?=$params->get('fontcolor');?>">
				<span><?=$user->getValue('firstname') . ' ' . $user->getValue('lastname');?></span>
			</div>
			<div class="jsn_group_profile_line" style="background-color: <?=$params->get('fontcolor');?>"></div>
			<div class="jsn_group_profile_bereich ">
				<?=$user->gruppenfunktion;?>
			</div>
				<div class="jsn_group_profile_contact_icons" style="color: <?=$params->get('fontcolor');?>" >
					<center>
						<?php
						if(!empty($user->getValue('facebook'))): ?>
						<a href="https://facebook.com/<?=$user->getValue('facebook');?>" target="_blank">
							<div class="jsn_group_profile_contact_icon">

									<i class="fa fa-facebook"></i>
							</div>
						</a>
						<?php endif;
						if(!empty($user->getValue('instagram'))): ?>
							<div class="jsn_group_profile_contact_icon"><a href="https://instagram.com/<?=$user->getValue('instagram');?>" target="_blank"><i class="fa fa-instagram"></a></i></div>
						<?php endif;
						if($params->get('show_mail')): ?>
						<div class="jsn_group_profile_contact_icon">
							<form name="contactLink" action="<?=$params->get('defaultContactAddress');?>" method="post" target="_blank">
						    <input type="hidden" name="<?=$params->get('parameterName');?>" value="<?=$user->getValue('convert_forms_contact_id');?>" />
						    <input type="hidden" name="uid" value="<?=$user->getValue('id');?>" />
						    <button type="submit" >
						      <i class="fa fa-envelope"></i>
						    </button>
						  </form>
						</div>
						<?php endif;?>
					</center>
				</div>
		</div>
	</div>
</div>


<?php

}
?>
