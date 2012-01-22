<?php

/**
 * Admin
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class AdminFavorites extends Doctrine_Record {
	
	public function setUp(){

	}
	

	public function setTableDefinition(){
		$this->setTableName('admin_favorites');

		$this->hasColumn('admin_favs_id', 'integer', 4, array(
			'type' => 'integer',
			'length' => 4,
			'unsigned' => 0,
			'primary' => true,
			'autoincrement' => true
		));
		
		$this->hasColumn('admin_favs_name', 'string', null, array(
			'type' => 'string',
			'length' => null,
			'fixed' => false,
			'primary' => false,
			'default' => '',
			'notnull' => true,
			'autoincrement' => false
		));

		$this->hasColumn('favorites_links', 'string', null, array(
			'type' => 'string',
			'length' => null,
			'fixed' => false,
			'primary' => false,
			'default' => '',
			'notnull' => true,
			'autoincrement' => false
		));
		$this->hasColumn('favorites_names', 'string', null, array(
			'type' => 'string',
			'length' => null,
			'fixed' => false,
			'primary' => false,
			'default' => '',
			'notnull' => true,
			'autoincrement' => false
		));
	}
}