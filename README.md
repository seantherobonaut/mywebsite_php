# My personal website!
Requires the use of my [php-lib](https://github.com/seantherobonaut/php-lib) library. 

For the website to even start, the global paths must be configured in index.php.
```php
$GLOBALS['path_root'] = __DIR__.'/'; 
$GLOBALS['path_app'] = $GLOBALS['path_root'].'app/'; 
$GLOBALS['path_lib'] = $GLOBALS['path_root'].'lib/';

require $GLOBALS['path_app'].'server/init.php';    
```
When these values aren't set, `'app/setup.php'` will exit the code.