<?php

declare(strict_types=1);

namespace MiniUrl\Tests;

use MiniUrl\Resolver\LinkListResolver;
use MiniUrl\Resolver\NotFoundResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

final class LinkListResolverTest extends TestCase
{
    public function testItCanResolveCorrectly(): void
    {
        $resolver = new LinkListResolver(__DIR__ . '/../../links.example.json');

        $this->assertTrue($resolver->canResolve(Request::create('/welcome')));
        $this->assertFalse($resolver->canResolve(Request::create('/bye')));
    }

    public function testItResolvesToCorrectUrl(): void
    {
        $resolver = new LinkListResolver(__DIR__ . '/../../links.example.json');

        /** @var RedirectResponse $response */
        $response = $resolver->resolve(Request::create('/welcome'));

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertTrue($response->isRedirect());
        $this->assertSame('https://www.example.com/', $response->getTargetUrl());
    }
}
