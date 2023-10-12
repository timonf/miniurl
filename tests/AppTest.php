<?php

declare(strict_types=1);

namespace MiniUrl\Tests;

use MiniUrl\App;
use MiniUrl\Resolver\NotFoundResolver;
use MiniUrl\Resolver\SingleLinkResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

final class AppTest extends TestCase
{
    public function testItResolvesFirstGuess(): void
    {
        $app = App::createFromResolverList([
            new SingleLinkResolver('a', 'https://www.example.com/a'),
            new SingleLinkResolver('a', 'https://www.example.com/b'),
        ]);

        /** @var RedirectResponse $response */
        $response = $app->run(Request::create('/a'));

        $this->assertSame('https://www.example.com/a', $response->getTargetUrl());
    }

    public function testItReturnsServerErrorWithNoEntries(): void
    {
        $app = App::createFromResolverList([]);

        /** @var RedirectResponse $response */
        $response = $app->run(Request::create('/a'));

        $this->assertSame(500, $response->getStatusCode());
    }

    public function testItReturnsServerErrorWithNotMatchingEntries(): void
    {
        $app = App::createFromResolverList([
            new SingleLinkResolver('a', 'https://www.example.com/a'),
            new SingleLinkResolver('b', 'https://www.example.com/b'),
            new NotFoundResolver(),
        ]);

        /** @var RedirectResponse $response */
        $response = $app->run(Request::create('/c'));

        $this->assertSame(404, $response->getStatusCode());
    }
}
