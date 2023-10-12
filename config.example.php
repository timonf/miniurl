<?php

declare(strict_types=1);

return [
    new MiniUrl\Resolver\LinkListResolver(__DIR__ . '/links.example.json'),
    new MiniUrl\Resolver\SingleLinkResolver('mit', 'https://opensource.org/license/mit/'),
    new MiniUrl\Resolver\RegExResolver('/^search\/([\w\d\s]+)$/', 'https://duckduckgo.com/?q=$1'),
    new MiniUrl\Resolver\NotFoundResolver(), // Keep this line to return a simple 404 page as a fallback.
];
