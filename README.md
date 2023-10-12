MiniURL
=======

Most simple URL resolver. Written in PHP. Works without database.


Installation
------------

1. `composer install --no-dev`
2. `cp config.example.php config.php`
3. `php -S localhost:8080 -t .`


Configuration
-------------

You can add, edit and change the order of given resolvers.

```php
<?php

declare(strict_types=1);

return [
    // LinkListResolver will match URL according to an associative JSON array.
    new MiniUrl\Resolver\LinkListResolver(__DIR__ . '/links.example.json'),
    
    // SingleLinkResolver will match a simple URL (`http://localhost:8080/test` redirects to `https://www.example.com`).
    new MiniUrl\Resolver\SingleLinkResolver('test', 'https://www.example.com'),
    
    // RegExResolver is useful to extract certain parts and use it in target URL.
    new MiniUrl\Resolver\RegExResolver('/^search\/([\w\d\s]+)$/', 'https://duckduckgo.com/?q=$1'),
    
    // Keep this line as last entry to return a simple 404 page as a fallback.
    new MiniUrl\Resolver\NotFoundResolver(), 
];
```


Testing
-------

1. `composer install`
2. `composer run tests`
