# PSR4-Autoloader
PSR-4 Autoloader Package. Requires **PHP >=7.4**

## Usage
```php
require '/path/to/autoload/Bootstrap.php'

new VendorNamespace\ClassName();
```

Then register new namespaces and classmaps in their respective `$psr4` and `$classmap` arrays inside of `src/Autoloader.php`. Below is the format to follow:

```php
$psr4 = [
  'NamespaceName' => 'path/to/directory'
];

$classmap = [
  '\Namespace\Classname' => 'path/to/class/file.php', // Using the '.php` extension
  '\Namespace\Classname' => 'path/to/class/file'      // Without the '.php` extension
];
```
