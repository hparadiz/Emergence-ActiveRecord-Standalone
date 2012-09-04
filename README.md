Emergence-ActiveRecord-Standalone
=================================

The only Model class you will ever need for your PHP project

***

Emergence ActiveRecord Standalone is a standalone version of the Model class which comes with the [Emergence Framework](http://emr.ge).

Unfortunately it currently has dependencies that rely on the framework's database class as well as a few utility classes.

***

Take a look at the examples folder for example models.

A more concrete usage manual is available on the Emergence [website](http://emr.ge/manual/models).

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