<?php

/**
 * Orders
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class Orders extends Doctrine_Record {

	public function setUp(){
		$this->setUpParent();
		
		$this->hasOne('Customers', array(
			'local' => 'customers_id',
			'foreign' => 'customers_id'
		));

		$this->hasOne('OrdersStatus', array(
			'local' => 'orders_status',
			'foreign' => 'orders_status_id'
		));

		$this->hasMany('OrdersAddresses', array(
			'local' => 'orders_id',
			'foreign' => 'orders_id',
			'cascade' => array('delete')
		));

		$this->hasMany('OrdersPaymentsHistory', array(
			'local' => 'orders_id',
			'foreign' => 'orders_id',
			'cascade' => array('delete')
		));
		
		$this->hasMany('OrdersProducts', array(
			'local' => 'orders_id',
			'foreign' => 'orders_id',
			'cascade' => array('delete')
		));

		$this->hasMany('OrdersStatusHistory', array(
			'local' => 'orders_id',
			'foreign' => 'orders_id',
			'cascade' => array('delete')
		));

		$this->hasMany('OrdersTotal', array(
			'local' => 'orders_id',
			'foreign' => 'orders_id',
			'cascade' => array('delete')
		));
	}
	
	public function setUpParent(){
	}
	
	public function preInsert($event){
		$this->date_purchased = date('Y-m-d H:i:s');
	}
	
	public function preUpdate($event){
		$this->last_modified = date('Y-m-d H:i:s');
	}
	
	public function setTableDefinition(){
		$this->setTableName('orders');

		$this->hasColumn('orders_id', 'integer', 4, array(
		'type' => 'integer',
		'length' => 4,
		'unsigned' => 0,
		'primary' => true,
		'autoincrement' => true,
		));
		$this->hasColumn('customers_id', 'integer', 4, array(
		'type' => 'integer',
		'length' => 4,
		'unsigned' => 0,
		'primary' => false,
		'default' => '0',
		'notnull' => true,
		'autoincrement' => false,
		));
		$this->hasColumn('customers_telephone', 'string', 32, array(
		'type' => 'string',
		'length' => 32,
		'fixed' => false,
		'primary' => false,
		'default' => '',
		'notnull' => true,
		'autoincrement' => false,
		));
		$this->hasColumn('customers_email_address', 'string', 96, array(
		'type' => 'string',
		'length' => 96,
		'fixed' => false,
		'primary' => false,
		'default' => '',
		'notnull' => true,
		'autoincrement' => false,
		));
		$this->hasColumn('last_modified', 'timestamp', null, array(
		'type' => 'timestamp',
		'primary' => false,
		'notnull' => false,
		'autoincrement' => false,
		));
		$this->hasColumn('date_purchased', 'timestamp', null, array(
		'type' => 'timestamp',
		'primary' => false,
		'notnull' => false,
		'autoincrement' => false,
		));
		$this->hasColumn('orders_status', 'integer', 4, array(
		'type' => 'integer',
		'length' => 4,
		'unsigned' => 0,
		'primary' => false,
		'default' => '0',
		'notnull' => true,
		'autoincrement' => false,
		));
		$this->hasColumn('orders_date_finished', 'timestamp', null, array(
		'type' => 'timestamp',
		'primary' => false,
		'notnull' => false,
		'autoincrement' => false,
		));
		$this->hasColumn('usps_track_num', 'string', 40, array(
		'type' => 'string',
		'length' => 40,
		'fixed' => false,
		'primary' => false,
		'notnull' => false,
		'autoincrement' => false,
		));
		$this->hasColumn('usps_track_num2', 'string', 40, array(
		'type' => 'string',
		'length' => 40,
		'fixed' => false,
		'primary' => false,
		'notnull' => false,
		'autoincrement' => false,
		));
		$this->hasColumn('ups_track_num', 'string', 40, array(
		'type' => 'string',
		'length' => 40,
		'fixed' => false,
		'primary' => false,
		'notnull' => false,
		'autoincrement' => false,
		));
		$this->hasColumn('ups_track_num2', 'string', 40, array(
		'type' => 'string',
		'length' => 40,
		'fixed' => false,
		'primary' => false,
		'notnull' => false,
		'autoincrement' => false,
		));
		$this->hasColumn('fedex_track_num', 'string', 40, array(
		'type' => 'string',
		'length' => 40,
		'fixed' => false,
		'primary' => false,
		'notnull' => false,
		'autoincrement' => false,
		));
		$this->hasColumn('fedex_track_num2', 'string', 40, array(
		'type' => 'string',
		'length' => 40,
		'fixed' => false,
		'primary' => false,
		'notnull' => false,
		'autoincrement' => false,
		));
		$this->hasColumn('dhl_track_num', 'string', 40, array(
		'type' => 'string',
		'length' => 40,
		'fixed' => false,
		'primary' => false,
		'notnull' => false,
		'autoincrement' => false,
		));
		$this->hasColumn('dhl_track_num2', 'string', 40, array(
		'type' => 'string',
		'length' => 40,
		'fixed' => false,
		'primary' => false,
		'notnull' => false,
		'autoincrement' => false,
		));
		$this->hasColumn('currency', 'string', 3, array(
		'type' => 'string',
		'length' => 3,
		'fixed' => true,
		'primary' => false,
		'notnull' => false,
		'autoincrement' => false,
		));
		$this->hasColumn('currency_value', 'decimal', 14, array(
		'type' => 'decimal',
		'length' => 14,
		'unsigned' => 0,
		'primary' => false,
		'notnull' => false,
		'autoincrement' => false,
		'scale' => false,
		));
		$this->hasColumn('preorder_status', 'integer', 4, array(
		'type' => 'integer',
		'length' => 4,
		'unsigned' => 0,
		'primary' => false,
		'default' => '0',
		'notnull' => true,
		'autoincrement' => false,
		));
		$this->hasColumn('shipping_module', 'string', 255, array(
		'type' => 'string',
		'length' => 255,
		'fixed' => false,
		'primary' => false,
		'notnull' => false,
		'autoincrement' => false,
		));
		$this->hasColumn('payment_module', 'string', 64, array(
		'type' => 'string',
		'length' => 64,
		'fixed' => false,
		'primary' => false,
		'notnull' => true,
		'autoincrement' => false,
		));
		$this->hasColumn('ip_address', 'string', 64, array(
		'type' => 'string',
		'length' => 64,
		'fixed' => false,
		'primary' => false,
		'notnull' => true,
		'autoincrement' => false,
		));
		$this->hasColumn('bill_attempts', 'integer', 1, array(
		'type' => 'integer',
		'length' => 1,
		'unsigned' => 0,
		'primary' => false,
		'notnull' => false,
		'autoincrement' => false,
		));
	}
}