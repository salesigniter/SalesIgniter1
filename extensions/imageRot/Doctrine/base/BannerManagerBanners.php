<?php

/**
 * Products
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class BannerManagerBanners extends Doctrine_Record {

	public function setUp(){
		
		$this->hasMany('BannerManagerBannersToGroups', array(
			'local' => 'banners_id',
			'foreign' => 'banners_id',
			'cascade' => array('delete')
		));

	}
	
	public function preInsert($event){
		$this->banners_date_added = date('Y-m-d H:i:s');


		if($this->banners_date_scheduled == '0000-00-00 00:00:00'){
			$this->banners_status = '2';//running
			$this->banners_date_status_changed = date("Y-m-d");
		}
	}

	public function setTableDefinition(){
		$this->setTableName('banner_manager_banners');

		$this->hasColumn('banners_id', 'integer', 4, array(
			'type'          => 'integer',
			'length'        => 4,
			'unsigned'      => 0,
			'primary'       => true,
			'autoincrement' => true
		));
		$this->hasColumn('banners_name', 'string', 64, array(
			'type'          => 'string',
			'length'        => 64,
			'fixed'         => false,
			'primary'       => false,
			'notnull'       => false,
			'autoincrement' => false
		));

		$this->hasColumn('banners_date_added', 'timestamp', null, array(
			'type'          => 'timestamp',
			'primary'       => false,
			'default'       => '0000-00-00 00:00:00',
			'notnull'       => true,
			'autoincrement' => false
		));
		$this->hasColumn('banners_date_scheduled', 'timestamp', null, array(
			'type'          => 'timestamp',
			'default'       => '0000-00-00 00:00:00',
			'primary'       => false,
			'notnull'       => false,
			'autoincrement' => false
		));
		$this->hasColumn('banners_date_status_changed', 'timestamp', null, array(
			'type'          => 'timestamp',
			'primary'       => false,
			'notnull'       => false,
			'autoincrement' => false
		));
		$this->hasColumn('banners_expires_date', 'timestamp', null, array(
			'type'          => 'timestamp',
			'default'       => '0000-00-00 00:00:00',
			'primary'       => false,
			'notnull'       => false,
			'autoincrement' => false
		));
		$this->hasColumn('banners_status', 'integer', 1, array(
			'type'          => 'integer',
			'length'        => 1,
			'unsigned'      => 0,
			'primary'       => false,
			'default'       => '0',
			'notnull'       => true,
			'autoincrement' => false
		));

		$this->hasColumn('banners_products_id', 'integer', 4, array(
			'type'          => 'integer',
			'length'        => 4,
			'unsigned'      => 0,
			'primary'       => false,
			'default'       => '0',
			'notnull'       => true,
			'autoincrement' => false
		));

		$this->hasColumn('banners_url', 'string', 250, array(
			'type'          => 'string',
			'length'        => 250,
			'fixed'         => false,
			'primary'       => false,
			'notnull'       => false,
			'autoincrement' => false
		));
		$this->hasColumn('banners_body', 'string', 100, array(
			'type'          => 'string',
			'length'        => 100,
			'fixed'         => false,
			'primary'       => false,
			'notnull'       => false,
			'autoincrement' => false
		));

		$this->hasColumn('banners_body_thumbs', 'string', 100, array(
			'type'          => 'string',
			'length'        => 100,
			'fixed'         => false,
			'primary'       => false,
			'notnull'       => false,
			'autoincrement' => false
		));

		$this->hasColumn('banners_html', 'string', null, array(
			'type'          => 'string',
			'fixed'         => false,
			'primary'       => false,
			'notnull'       => false,
			'autoincrement' => false
		));

		$this->hasColumn('banners_description', 'string', null, array(
			'type'          => 'string',
			'fixed'         => false,
			'primary'       => false,
			'notnull'       => false,
			'autoincrement' => false
		));

		$this->hasColumn('banners_small_description', 'string', 400, array(
			'type'          => 'string',
			'length'        => 400,
			'fixed'         => false,
			'primary'       => false,
			'notnull'       => false,
			'autoincrement' => false
		));

		$this->hasColumn('banners_views', 'integer', 6, array(
			'type'          => 'integer',
			'length'        => 6,
			'unsigned'      => 0,
			'default'       => '0',
			'autoincrement' => false
		));

		$this->hasColumn('banners_clicks', 'integer', 6, array(
			'type'          => 'integer',
			'length'        => 6,
			'unsigned'      => 0,
			'default'       => '0',
			'autoincrement' => false
		));
		$this->hasColumn('banners_sort_order', 'integer', 6, array(
			'type'          => 'integer',
			'length'        => 6,
			'unsigned'      => 0,
			'autoincrement' => false
		));
	$this->hasColumn('banners_expires_views', 'integer', 6, array(
			'type'          => 'integer',
			'length'        => 6,
			'unsigned'      => 0,
			'default'       => '0',
			'autoincrement' => false
		));

		$this->hasColumn('banners_expires_clicks', 'integer', 6, array(
			'type'          => 'integer',
			'length'        => 6,
			'unsigned'      => 0,
			'default'       => '0',
			'autoincrement' => false
		));
	}
}