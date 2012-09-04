<?php
class SalesPeople extends ActiveRecord
{
	// support subclassing
	static public $rootClass = __CLASS__;
	static public $defaultClass = __CLASS__;
	static public $subClasses = array(__CLASS__);


	// ActiveRecord configuration
	static public $tableName = 'sales_people';
	static public $singularNoun = 'salesperson';
	static public $pluralNoun = 'salespeople';
	
	static public $primaryKey = 'id';
	
	static public $fields = array(
        'id' => array(
            'type' => 'integer'
            ,'autoincrement' => true
            ,'unsigned' => true
        )
        ,'firstname'
        ,'lastname'
        ,'email'
        ,'initials'
    );
}