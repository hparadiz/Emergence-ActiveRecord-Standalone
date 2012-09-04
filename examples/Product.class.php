<?php
class Product extends ActiveRecord
{

	// support subclassing
	static public $rootClass = __CLASS__;
	static public $defaultClass = __CLASS__;
	static public $subClasses = array(__CLASS__);
	
	
	// ActiveRecord configuration
	static public $tableName = 'products';
	static public $singularNoun = 'product';
	static public $pluralNoun = 'products';
	
	static public $primaryKey = 'id';
	
	static public $fields = array(
        'id' => array(
            'type' => 'integer'
            ,'autoincrement' => true
            ,'unsigned' => true
        )
        ,'company_id' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
        ,'name'
        ,'displayName'
        ,'slug'
        ,'product_status' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
		,'listing_id' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
		,'publication_id' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
		,'publication_id2' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
		,'URL' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
		,'parent_id' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
		,'description'
		,'listing_description'
		,'image_id' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
		,'image_id2' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
		,'image_id3' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
		,'image_id4' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
		,'image_id5' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
		,'image_id6' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
	    ,'MediaID'	=>	array(
	    	'type' => 'integer'
	    	,'unsigned' => true
	    )
		,'special_pricing'
		,'article_driver'
		,'ce_driver'
		,'bill_thumb'
		,'bill_board'
		,'banner'
		,'email_recipient_name'
		,'email_recipient_address'
		,'salesperson_id' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
		,'email_sales' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
		,'2012_visits' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
		,'2012_impressions' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
		,'2011_visits' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
		,'2011_impressions' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
		,'stats_updated_at' //datetime
		,'yearly_cost' //float
		,'monthly_cost' //float
		,'external_link'
    );

	static public $relationships = array(
		'Company' => array(
	    	'type' => 'one-one'
	    	,'class' => 'Company'
	    	,'local'	=>	'company_id'
	    	,'foreign' => 'id'
	    	//,'conditions' => 'Status != "Deleted"'
	    	//,'order' => array('name' => 'ASC')
	    )
	    ,'PrimaryImage' => array(
	    	'type' => 'one-one'
	    	,'class' => 'Media'
	    	,'local'	=>	'MediaID'
	    	,'foreign' => 'ID'
	    	//,'conditions' => 'Status != "Deleted"'
	    	//,'order' => array('name' => 'ASC')
	    )
	);

	public function save()
	{
		$this->displayName = $this->name;
		return parent::save();
	}

    public function getData()
    {
    
    	$CategoryQuery = sprintf("SELECT `c`.*
    		FROM `products_categories` AS `pc`
    		INNER JOIN `categories` AS `c` ON (`c`.`id`=`pc`.`category_id`)
    		WHERE `pc`.`product_id`='%d'",$this->id);
    		
    	$CompanyQuery = sprintf("SELECT `company_name` FROM `companies` WHERE `id`='%d'",$this->company_id);
    
    	$data = array(
	    	'Category'		=>	DB::oneRecord($CategoryQuery)
	    	,'Company'		=>	DB::oneValue($CompanyQuery)
	    );
	    
	    $data['CategoryID'] = $data['Category']['id'];
	    $data['SponsorshipLevel'] = DB::oneValue(sprintf("SELECT `level` FROM `products_categories` WHERE `product_id`='%d'",$this->id),'level');
    
	    return array_merge(parent::getData(),$data);
    }

	public static function get_product_categories($type)
	{
		return DB::allRecords('SELECT g.id,  g.name, g.slug, count(g.id) AS count  FROM categories AS `g` 
			inner join products_categories as pc on g.id = pc.category_id
			inner join products as p on p.id = pc.product_id
			WHERE type = ' . $type . ' and p.product_status = 1 
			and p.id NOT IN (SELECT product_id AS pid FROM notes AS n WHERE product_id > 0 GROUP BY parent_id HAVING((max(review_status) != 3) AND (max(note_type != 8)))) 
			GROUP BY g.id having count > 0 order by name;');
	}

	public static function get_category_by_handle($handle)
	{
		return DB::oneRecord('SELECT * from categories  where `slug` = "'.DB::escape($handle).'"');
	}
}