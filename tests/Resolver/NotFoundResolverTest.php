<?php

declare(strict_types=1);

namespace MiniUrl\Tests;

use MiniUrl\Resolver\NotFoundResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

final class NotFoundResolverTest extends TestCase
{
    public function testItCanResolveCorrectly(): void
    {
        $resolver = new NotFoundResolver();

        $this->assertTrue($resolver->canResolve(Request::create('/a')));
    }

    public function testItResolvesToCorrectUrl(): void
    {
        $resolver = new NotFoundResolver();
        $response = $resolver->resolve(Request::create('/a'));

        $this->assertSame(404, $response->getStatusCode());
    }
}
