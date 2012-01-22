<?php
	$Categories = Doctrine_Core::getTable('Categories');
	if (isset($_GET['cID'])){
		$Category = $Categories->findOneByCategoriesId((int)$_GET['cID']);
	}else{
		$Category = $Categories->create();
		if (isset($_GET['parent_id'])){
			$Category->parent_id = $_GET['parent_id'];
		}
	}

	if (isset($_POST['parent_id']) && $_POST['parent_id'] > -1){
		$Category->parent_id = $_POST['parent_id'];
	}

	$Category->sort_order = (int)$_POST['sort_order'];
	$Category->categories_menu = (isset($_POST['categories_menu']) ? $_POST['categories_menu'] : 'infobox');

	if ( ($categories_image = new upload('categories_image', sysConfig::getDirFsCatalog() . 'images'))) {
		if(!empty($categories_image->filename)){
			$Category->categories_image = $categories_image->filename;
		}
	}

	$languages = tep_get_languages();
	$CategoriesDescription =& $Category->CategoriesDescription;
	for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
		$lID = $languages[$i]['id'];

		$CategoriesDescription[$lID]->language_id = $lID;
		$CategoriesDescription[$lID]->categories_name = $_POST['categories_name'][$lID];
		$CategoriesDescription[$lID]->categories_description = $_POST['categories_description'][$lID];
		if(!empty($_POST['categories_seo_url'][$lID])){
			$CategoriesDescription[$lID]->categories_seo_url = tep_friendly_seo_url($_POST['categories_seo_url'][$lID]);
		}else{
			$CategoriesDescription[$lID]->categories_seo_url = tep_friendly_seo_url($_POST['categories_name'][$lID]);
		}
	}

	/*
	 * anything additional to handle into $ArticlesDescription ?
	 */
	EventManager::notify('CategoriesDescriptionsBeforeSave', &$CategoriesDescription);

	$Category->save();

	EventManager::attachActionResponse(itw_app_link(tep_get_all_get_params(array('action', 'cID')) . 'cID=' . $Category->categories_id, null, 'default'), 'redirect');
?>
