<?php
class Entry extends ActiveRecord {

	// support subclassing
	static public $rootClass = __CLASS__;
	static public $defaultClass = __CLASS__;
	static public $subClasses = array(__CLASS__);


	// ActiveRecord configuration
	static public $tableName = 'entries';
	static public $singularNoun = 'entry';
	static public $pluralNoun = 'entries';
	
	static public $primaryKey = 'id';
	
	static public $fields = array(
        'id' => array(
            'type' => 'integer'
            ,'autoincrement' => true
            ,'unsigned' => true
        )
		,'position_id' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
		,'zone_id' => array(
			'type' => 'integer'
			,'unsigned' => true
			,'notnull' => false
		)
		,'headline'
		,'subhead'
		,'byline'
		,'summary'
		,'section'
		,'url'
		,'secondary_url'
		,'insertion_html'
		,'image'
		,'image_crop'
		,'image_url'
		,'image_alt'
		,'date' => array(
            'type'  =>  'timestamp'
            ,'notnull' => false
		)
		,'starts_at' => array(
            'type'  =>  'timestamp'
            ,'notnull' => false
		)
		,'ends_at' => array(
            'type'  =>  'timestamp'
            ,'notnull' => false
		)
		,'is_sticky'
		,'is_must_read'
		,'sort' => array(
			'type' => 'integer'
			,'notnull' => false
		)
	);
	
	static public $relationships = array(
		'Campaign' => array(
	    	'type' => 'one-one'
	    	,'class' => 'Campaign'
	    	,'local'	=>	'id'
	    	,'foreign' => 'entry_id'
	    	//,'conditions' => 'Status != "Deleted"'
	    	//,'order' => array('name' => 'ASC')
	    )
	    ,'Zone'	=>	array(
	    	'type'		=>	'one-one'
	    	,'class'	=>	'Zone'
	    	,'local'	=>	'zone_id'
	    	,'foreign'	=>	'id'
	    )
	    ,'Position'	=>	array(
	    	'type'		=>	'one-one'
	    	,'class'	=>	'ZonePosition'
	    	,'local'	=>	'position_id'
	    	,'foreign'	=>	'id'
	    )
	);
	
	public function getValue($name,$usePrivate=false)
    {
        switch($name)
        {
            case 'url':
            	if($usePrivate)
            	{
	            	return $this->_getFieldValue($name);
            	}
            	else
            	{
	            	return '/go/e'.$this->id;	
            	}
            case 'html':
            	return $this->html();
            
            default:
            	return parent::getValue($name);
		}
	}	
	
	public function html()
	{
		if($this->insertion_html)
		{
			return stripslashes(str_replace('[timestamp]',time(),$this->insertion_html));
		}
		else {
			$ad = '<a href="%s" target="_blank"><img src="%s" alt="%s"></a>';
			return sprintf($ad,$this->url,$this->image,$this->image_alt);
		}
	}
	
	public function getClickCount($start,$end)
	{
		if($this->Campaign)
		{
			$Clicks = sprintf("SELECT COUNT(*) as `Count` FROM `go_clicks`
				WHERE (`entry_id`='%d' OR `campaign_id`='%d') AND `Created`
					BETWEEN '%s' AND '%s'"
				,$this->id,$this->Campaign->id,$start,$end);
		}
		else
		{
			$Clicks = sprintf("SELECT COUNT(*) as `Count` FROM `go_clicks`
				WHERE `entry_id`='%d' AND `Created`
					BETWEEN '%s' AND '%s'"
				,$this->id,$start,$end);
		}
		
		return DB::oneValue($Clicks,'Count');
	}
	
	public function getImpressionCount($start,$end)
	{
		$Impressions = sprintf("SELECT COUNT(*) as `Count` FROM `entry_impressions`
			WHERE `EntryID`='%d' AND `Created`
				BETWEEN '%s' AND '%s'"
			,$this->id,$start,$end);
		return DB::oneValue($Impressions,'Count');
	}
	
	public function createImpression()
	{
		if(!Site::isBot()) // if not bot
		{
			if(!$UserAgent = UserAgent::getByField('UserAgent',$_SERVER['HTTP_USER_AGENT']))
			{
				$UserAgent = UserAgent::create(array('UserAgent'=>$_SERVER['HTTP_USER_AGENT']),true);
			}

			return EntryImpression::create(array(
				'EntryID'		=>	$this->id
				,'IP'			=>	$_SERVER['REMOTE_ADDR']
		        ,'URL'			=>	DB::escape($_SERVER['REQUEST_URI'])
		        ,'UserAgent'	=>	$UserAgent->ID
			),true);
		}
	}
}