<?php
/*
	Related Products Extension Version 1

	I.T. Web Experts, Rental Store v2
	http://www.itwebexperts.com

	Copyright (c) 2009 I.T. Web Experts

	This script and it's source is not redistributable
*/

class pointsRewardsInstall extends extensionInstaller {

	public function __construct(){
		parent::__construct('pointsRewards');
	}

	public function install(){
		if (sysConfig::exists('EXTENSION_POINTS_REWARDS_SYSTEM_ENABLED') === true) return;

		parent::install();
	}

	public function uninstall($remove = false){
		if (sysConfig::exists('EXTENSION_POINTS_REWARDS_SYSTEM_ENABLED') === false) return;

		parent::uninstall($remove);
	}
}
?>