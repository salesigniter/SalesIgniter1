<?php
	$Categories = Doctrine_Core::getTable('Categories');
	if (isset($_GET['cID']) && empty($_POST)){
		$Category = $Categories->find((int)$_GET['cID']);
		$Category->refresh(true);
	}else{
		$Category = $Categories->getRecord();
	}



	$languages = tep_get_languages();
?>
<form name="new_category" action="<?php echo itw_app_link(tep_get_all_get_params(array('app', 'appName', 'action')) . 'action=saveCategory');?>" method="post" enctype="multipart/form-data">
<div class="pageHeading"><?php
 echo sysLanguage::get('HEADING_TITLE');
?></div>
<br />

<div id="tab_container">
 <ul>
  <li class="ui-tabs-nav-item"><a href="#page-1"><span><?php echo sysLanguage::get('TAB_GENERAL');?></span></a></li>
  <li class="ui-tabs-nav-item"><a href="#page-2"><span><?php echo sysLanguage::get('TAB_DESCRIPTION');?></span></a></li>
  <?php
   $contents = EventManager::notifyWithReturn('NewCategoryTabHeader');
   if (!empty($contents)){
		foreach($contents as $content){
			echo $content;
		}
   }
  ?>
 </ul>

 <div id="page-1"><?php include(sysConfig::getDirFsAdmin() . 'applications/categories/pages_tabs/tab_general.php');?></div>
 <div id="page-2"><?php include(sysConfig::getDirFsAdmin() . 'applications/categories/pages_tabs/tab_description.php');?></div>
  <?php
   $contents = EventManager::notifyWithReturn('NewCategoryTabBody', &$Category);
   if (!empty($contents)){
		foreach($contents as $content){
			echo $content;
		}
   }
  ?>
</div>
<br />
<div style="text-align:right"><?php
   $saveButton = htmlBase::newElement('button')->setType('submit')->usePreset('save');
   $cancelButton = htmlBase::newElement('button')->usePreset('cancel')
   ->setHref(itw_app_link(null, 'categories', 'default', 'SSL'));

   echo $saveButton->draw() . $cancelButton->draw();
?></div>
</form>