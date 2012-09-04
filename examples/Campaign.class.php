<?php
class Campaign extends ActiveRecord
{
	// support subclassing
	static public $rootClass = __CLASS__;
	static public $defaultClass = __CLASS__;
	static public $subClasses = array(__CLASS__);


	// ActiveRecord configuration
	static public $tableName = 'campaigns';
	static public $singularNoun = 'campaign';
	static public $pluralNoun = 'campaigns';
	
	static public $primaryKey = 'id';
	
	static public $fields = array(
        'id' => array(
            'type' => 'integer'
            ,'autoincrement' => true
            ,'unsigned' => true
        )
		,'placement_id'
		,'entry_id' => array(
			'type' => 'integer'
			,'unsigned' => true
		)
		,'vertical_id' => array(
			'type' => 'integer'
			,'unsigned' => true
		)
		,'cat_id' => array(
			'type' => 'integer'
			,'unsigned' => true
		)
		,'company_id' => array(
			'type' => 'integer'
			,'unsigned' => true
		)
		,'product_id' => array(
			'type' => 'integer'
			,'unsigned' => true
		)
		,'company_name'
		,'product_name'
		,'contact_name'
		,'contact_email'
		,'banner_type' => array(
			'type' => 'integer'
			,'unsigned' => true
		)
		,'livedate' => array(
			'type' => 'date'
			,'unsigned' => true
		)
		,'dollarvalue'	=> array(
			'type' => 'integer'
			,'unsigned' => true
		)
		,'monthly_cost' => array( // float
			'type' => 'integer'
			,'unsigned' => true
		)
		,'price_info'
		,'can_count_clicks' => array(
			'type' => 'integer'
			,'unsigned' => true
		)
		,'month_visits' => array(
			'type' => 'integer'
			,'unsigned' => true
		)
		,'month_impressions' => array(
			'type' => 'integer'
			,'unsigned' => true
		)
		,'next_month_visits' => array(
			'type' => 'integer'
			,'unsigned' => true
		)
		,'next_month_impressions' => array(
			'type' => 'integer'
			,'unsigned' => true
		)
		,'total_visits' => array(
			'type' => 'integer'
			,'unsigned' => true
		)
		,'total_impressions' => array(
			'type' => 'integer'
			,'unsigned' => true
		)
		,'2011_visits' => array(
			'type' => 'integer'
			,'unsigned' => true
		)
		,'2011_impressions'	=> array(
			'type' => 'integer'
			,'unsigned' => true
		)
		,'2012_visits' => array(
			'type' => 'integer'
			,'unsigned' => true
		)
		,'2012_impressions' => array(
			'type' => 'integer'
			,'unsigned' => true
		)
		,'stats_updated_at' => array(
			'type' => 'date'
			,'unsigned' => true
		)
		,'created_at' => array(
            'type'  =>  'timestamp'
            ,'notnull' => false
		)
		,'updated_at' => array(
            'type'  =>  'timestamp'
            ,'notnull' => false
		)
	);	
	
	
	static public $relationships = array(
		'Entry' => array(
	    	'type' => 'one-one'
	    	,'class' => 'Entry'
	    	,'local'	=>	'entry_id'
	    	,'foreign' => 'id'
	    	//,'conditions' => 'Status != "Deleted"'
	    	//,'order' => array('name' => 'ASC')
	    )
		,'Company' => array(
	    	'type' => 'one-one'
	    	,'class' => 'Company'
	    	,'local'	=>	'company_id'
	    	,'foreign' => 'id'
	    	//,'conditions' => 'Status != "Deleted"'
	    	//,'order' => array('name' => 'ASC')
	    )
		,'Product' => array(
	    	'type' => 'one-one'
	    	,'class' => 'Product'
	    	,'local'	=>	'product_id'
	    	,'foreign' => 'id'
	    	//,'conditions' => 'Status != "Deleted"'
	    	//,'order' => array('name' => 'ASC')
	    )
	);
}