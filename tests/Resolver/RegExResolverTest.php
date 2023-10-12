<?php

declare(strict_types=1);

namespace MiniUrl\Tests;

use MiniUrl\Resolver\RegExResolver;
use MiniUrl\Resolver\SingleLinkResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

final class RegExResolverTest extends TestCase
{
    public function testItCanResolveCorrectly(): void
    {
        $resolver = new RegExResolver('/^a$/', 'https://www.example.com');

        $this->assertTrue($resolver->canResolve(Request::create('/a')));
        $this->assertFalse($resolver->canResolve(Request::create('/b')));
        $this->assertFalse($resolver->canResolve(Request::create('/abc')));
    }

    public function testItResolvesToCorrectUrl(): void
    {
        $resolver = new RegExResolver('/^([0-9]+)$/', 'https://www.example.com/$1');

        /** @var RedirectResponse $response */
        $response = $resolver->resolve(Request::create('/123'));

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertTrue($response->isRedirect());
        $this->assertSame('https://www.example.com/123', $response->getTargetUrl());
    }
}
