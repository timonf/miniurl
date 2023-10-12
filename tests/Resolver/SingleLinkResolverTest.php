<?php

declare(strict_types=1);

namespace MiniUrl\Tests;

use MiniUrl\Resolver\SingleLinkResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

final class SingleLinkResolverTest extends TestCase
{
    public function testItCanResolveCorrectly(): void
    {
        $resolver = new SingleLinkResolver('a', 'https://www.example.com');

        $this->assertTrue($resolver->canResolve(Request::create('/a')));
        $this->assertFalse($resolver->canResolve(Request::create('/b')));
    }

    public function testItResolvesToCorrectUrl(): void
    {
        $resolver = new SingleLinkResolver('a', 'https://www.example.com');

        /** @var RedirectResponse $response */
        $response = $resolver->resolve(Request::create('/a'));

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertTrue($response->isRedirect());
        $this->assertSame('https://www.example.com', $response->getTargetUrl());
    }
}
