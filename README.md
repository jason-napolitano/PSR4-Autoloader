# PSR4-Autoloader
PSR-4 Autoloader Package. Requires **PHP >=7.4**

## Usage
```php
require 'src/Autoloader.php';

// Register the autoloader
Autoloader::register();
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

## License
MIT License

Copyright (c) 2025 Jason Napolitano

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
