<?php

/**
 * CustomersStreamingViews
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class RoyaltiesSystemRoyaltiesEarned  extends Doctrine_Record {

	public function setUp(){
		$this->setUpParent();
		if (sysConfig::exists('EXTENSION_STREAMPRODUCTS_ENABLED')){
			$this->hasOne('ProductsStreams', array(
			                                      'local' => 'streaming_id',
			                                      'foreign' => 'stream_id'
			                                 ));
		}

		if (sysConfig::exists('EXTENSION_DOWNLOADPRODUCTS_ENABLED')){
			$this->hasOne('ProductsDownloads', array(
			                                        'local' => 'download_id',
			                                        'foreign' => 'download_id'
			                                   ));
		}
		$this->hasOne('Products', array(
		                               'local' => 'products_id',
		                               'foreign' => 'products_id'
		                          ));
		$this->hasOne('Orders', array(
		                               'local' => 'orders_id',
		                               'foreign' => 'orders_id'
		                          ));
		$this->hasOne('Customers', array(
		                               'local' => 'content_provider_id',
		                               'foreign' => 'customers_id'
		                          ));
	}

	public function setUpParent(){
		$Customers = Doctrine::getTable('Customers')->getRecordInstance();
		$Orders = Doctrine::getTable('Orders')->getRecordInstance();
		$Products = Doctrine::getTable('Products')->getRecordInstance();


		$Customers->hasMany('RoyaltiesSystemRoyaltiesEarned', array(
		                                                           'local' => 'customers_id',
		                                                           'foreign' => 'content_provider_id'
		                                                           	  ));
		$Orders->hasMany('RoyaltiesSystemRoyaltiesEarned', array(
		                                                           'local' => 'orders_id',
		                                                           'foreign' => 'orders_id'
		                                                      ));
		$Products->hasMany('RoyaltiesSystemRoyaltiesEarned', array(
		                                                'local' => 'products_id',
		                                                'foreign' => 'products_id'
		                                           ));
	}

	public function setTableDefinition(){
		$this->setTableName('RoyaltiesSystemRoyaltiesEarned');
		$this->hasColumn('royalties_earned_id', 'integer', 4, array(
		                                                           'type' => 'integer',
		                                                           'length' => 4,
		                                                           'unsigned' => 0,
		                                                           'primary' => true,
		                                                           'notnull' => true,
		                                                           'autoincrement' => true,
		                                                      ));
		$this->hasColumn('content_provider_id', 'integer', 4, array(
			'type' => 'integer',
			'length' => 4,
			'unsigned' => 0,
			'primary' => false,
			'notnull' => true,
			'autoincrement' => false,
		));
		$this->hasColumn('customers_id', 'integer', 4, array(
			'type' => 'integer',
			'length' => 4,
			'unsigned' => 0,
			'primary' => false,
			'notnull' => true,
			'autoincrement' => false,
		));
		$this->hasColumn('products_id', 'integer', 4, array(
			'type' => 'integer',
			'length' => 4,
			'unsigned' => 0,
			'primary' => false,
			'notnull' => true,
			'autoincrement' => false,
		));
		$this->hasColumn('orders_id', 'integer', 4, array(
			'type' => 'integer',
			'length' => 4,
			'unsigned' => 0,
			'primary' => false,
			'notnull' => true,
			'autoincrement' => false,
		));
		$this->hasColumn('download_id', 'integer', 4, array(
			'type' => 'integer',
			'length' => 4,
			'unsigned' => 0,
			'primary' => false,
			'notnull' => true,
			'autoincrement' => false,
		));
		$this->hasColumn('streaming_id', 'integer', 4, array(
			'type' => 'integer',
			'length' => 4,
			'unsigned' => 0,
			'primary' => false,
			'notnull' => true,
			'autoincrement' => false,
		));
		$this->hasColumn('rented_products_id', 'integer', 4, array(
			'type' => 'integer',
			'length' => 4,
			'unsigned' => 0,
			'primary' => false,
			'notnull' => true,
			'autoincrement' => false,
		));
		$this->hasColumn('products_barcode', 'integer', 16, array(
			'type' => 'varchar',
			'length' => 16,
			'unsigned' => 0,
			'primary' => false,
			'notnull' => true,
			'autoincrement' => false,
		));
		$this->hasColumn('royalty', 'float', 15, array(
			'type' => 'float',
			'length' => 15,
			'unsigned' => 0,
			'primary' => false,
			'notnull' => true,
			'autoincrement' => false,
		));

		$this->hasColumn('date_added', 'timestamp', null, array(
			'type' => 'timestamp',
			'default' =>'0000-00-00 00:00:00',
			'primary' => false,
			'notnull' => true,
			'autoincrement' => false,
		));
		$this->hasColumn('shipment_date', 'timestamp', null, array(
			'type' => 'timestamp',
			'default' =>'0000-00-00 00:00:00',
			'primary' => false,
			'notnull' => true,
			'autoincrement' => false,
		));
		$this->hasColumn('arrival_date', 'timestamp', null, array(
			'type' => 'timestamp',
			'default' =>'0000-00-00 00:00:00',
			'primary' => false,
			'notnull' => true,
			'autoincrement' => false,
		));
		$this->hasColumn('purchase_type', 'string', 16, array(
			'type' => 'string',
			'length' => 16,
			'default' => '',
			'primary' => false,
			'notnull' => true,
			'autoincrement' => false,
		));
	}
}
