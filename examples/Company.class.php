<?php
class Company extends ActiveRecord
{
	// support subclassing
	static public $rootClass = __CLASS__;
	static public $defaultClass = __CLASS__;
	static public $subClasses = array(__CLASS__);


	// ActiveRecord configuration
	static public $tableName = 'companies';
	static public $singularNoun = 'company';
	static public $pluralNoun = 'companies';
	
	static public $primaryKey = 'id';
	
	static public $fields = array(
        'id' => array(
            'type' => 'integer'
            ,'autoincrement' => true
            ,'unsigned' => true
        )
	    ,'company_name'
	    ,'company_displayname'
	    ,'slug'
	    ,'sort_name'
	    ,'logo_file'
	    ,'MediaID'	=>	array(
	    	'type' => 'integer'
	    	,'unsigned' => true
	    )
	    ,'address1'
	    ,'address2'
	    ,'city'
	    ,'state'
	    ,'zip'
	    ,'country'
	    ,'website'
	    ,'phone_number'
	    ,'phone_number2'
	    ,'email1'
	    ,'email1_description'
	    ,'email2'
	    ,'email2_description'
	    ,'email3'
	    ,'email3_description'
	    ,'description'
	    ,'default_sales_name'
	    ,'default_sales_email'
	    ,'default_sales_name2'
	    ,'default_sales_email2'
	    ,'default_lab_sales_name'
	    ,'default_lab_sales_email'
	    ,'default_salesperson'	=>	array(
	    	'type' => 'integer'
	    	,'unsigned' => true
	    )
	    ,'email_salesperson_id1'	=>	array(
	    	'type' => 'integer'
	    	,'unsigned' => true
	    )
	    ,'email_salesperson_id2'	=>	array(
	    	'type' => 'integer'
	    	,'unsigned' => true
	    )
	    ,'stats_updated_at'	=>	array(
	    	'type' => 'timestamp'
	    )
	    ,'CreatorID'	=>	array(
	    	'type' => 'integer'
	    	,'unsigned' => true
	    )
	    ,'pdf_name'
	    ,'default_email_report_name1'
	    ,'default_email_report_email1'
	    ,'default_email_report_name2'
	    ,'default_email_report_email2'
	    ,'default_email_report_name3'
	    ,'default_email_report_email3'
	);
	
	static public $relationships = array(
		'Logo' => array(
	    	'type' => 'one-one'
	    	,'class' => 'Media'
	    	,'local'	=>	'MediaID'
	    	,'foreign' => 'ID'
	    	//,'conditions' => 'Status != "Deleted"'
	    	//,'order' => array('name' => 'ASC')
	    )
	);
	
	public function getData()
	{
		$data = parent::getData();
		return array_merge($data,array(
			'ProductCount'	=>	DB::oneValue(sprintf("SELECT COUNT(*) FROM `products` WHERE `company_id`='%d';",$this->id))
		));
	}
}