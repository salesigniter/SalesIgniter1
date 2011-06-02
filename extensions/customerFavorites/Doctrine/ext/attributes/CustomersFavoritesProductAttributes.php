<?php

/**
 * CustomersToCustomerGroups
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class CustomersFavoritesProductAttributes extends Doctrine_Record {

	public function setUp(){
		parent::setUp();
		$this->setUpParent();
		
		$this->hasOne('CustomerFavorites', array(
			'local' => 'customer_favorites_id',
			'foreign' => 'customers_favorites_id'
		));

		$this->hasOne('ProductsAttributes', array(
			'local' => 'products_attributes_id',
			'foreign' => 'products_attributes_id'
		));

	}

	public function setUpParent(){
		$CustomersFavorites = Doctrine::getTable('CustomerFavorites')->getRecordInstance();

		$CustomersFavorites->hasMany('CustomersFavoritesProductAttributes', array(
			'local' => 'customer_favorites_id',
			'foreign' => 'customers_favorites_id',
			'cascade' => array('delete')
		));

		$ProductsAttributes = Doctrine::getTable('ProductsAttributes')->getRecordInstance();

		$ProductsAttributes->hasMany('CustomersFavoritesProductAttributes', array(
			'local' => 'products_attributes_id',
			'foreign' => 'products_attributes_id',
			'cascade' => array('delete')
		));
	}

	public function setTableDefinition(){
		$this->setTableName('customers_favorites_product_attributes');
		
		$this->hasColumn('customers_favorites_id', 'integer', 4, array(
			'type' => 'integer',
			'length' => 4,
			'unsigned' => 0,
			'primary' => true,
			'autoincrement' => false,
		));
		
		$this->hasColumn('products_attributes_id', 'integer', 4, array(
			'type' => 'integer',
			'length' => 4,
			'unsigned' => 0,
			'primary' => true,
			'autoincrement' => false,
		));
	}
}