Emergence-ActiveRecord-Standalone
=================================

The only Model class you will ever need for your PHP project.

Interact with your SQL database without writing any SQL.

***

Emergence ActiveRecord Standalone is a standalone version of the Model class which comes with the [Emergence Framework](http://emr.ge).

Unfortunately it currently has dependencies that rely on the framework's database class as well as a few utility classes.

***

Take a look at the examples folder for example models.

A more comprehensive usage manual is available on the Emergence [website](http://emr.ge/manual/models).

***
Please be aware.
----------------

If using your own autoloader please include this code to initialize the model properly.

```php
if(method_exists($class, '__classLoaded'))
{
	call_user_func(array($class, '__classLoaded'));
}
```

***
Examples
--------

Here's an example model class definition.

```php
<?php
class Example extends ActiveRecord {
	// ActiveRecord configuration
	static public $tableName = 'examples'; // the name of this model's table
	
	static public $singularNoun = 'example'; // a singular noun for this model's object
	static public $pluralNoun = 'examples'; // a plural noun for this model's object
	
	// the lowest-level class in your table requires these lines,
	// they can be manipulated via config files to plug in same-table subclasses
	static public $rootClass = __CLASS__;
	static public $defaultClass = __CLASS__;
	static public $subClasses = array(__CLASS__);

	static public $primaryKey = 'id'; // optional, ID is the default

	// gets combined with all the extended layers
	static public $fields = array(
		'Title'
	);
}
```


Once defined we can create a new record of the model like so:

```php
<?php

$object = new Example();
$object->Title = 'i am a string.';
$object->save(); // runs dynamic public function save

echo $object->id; // the automatically assigned ID of this object in SQL
// output: 1, 2, 3, 4, etc everytime you run lines 3 through 5
```


```php
<?php

// create and save at the same time
$object = Example::create(array(
	'Title'	=>	'i am a string.'
	,'CreatorID'	=>	1
),true); // <|-- This boolean(autoSave) is false by default, you will need to uncomment the save() line below if you omit this option or set it to false

//$object->save();

echo $object->id; // the automatically assigned ID of this object in SQL
```

***
Editing Records
```php
<?php

$object = Example::getByID(1); // returns an instance of an Example record
$object->Title = 'i am a string too.';
$object->save(); // runs dynamic public function save
```

```php
<?php

$object = Example::getByID(1); // returns an instance of an Example record
$object->setFields(array(
	'Title'	=>	'i am a string.'
	,'Creator'	=>	1
));
$object->save(); // runs dynamic public function save
```

***

Deleting Records
```php
<?php

$object = Example::getByID(1); // returns an instance of an Example record
$object->destroy(); // runs dynamic public function destroy
```


Credits
=======
Original class written by [Chris Alfano](https://github.com/themightychris) for the [Emergence Framework](http://emr.ge).
Slightly modified by Henry Paradiz for usage in stand alone situations.