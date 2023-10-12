<?php

declare(strict_types=1);

namespace MiniUrl\Resolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NotFoundResolver implements Resolvable
{
    public function canResolve(Request $request): bool
    {
        return true;
    }

    public function resolve(Request $request): Response
    {
        return new Response('Not found. Sorry.', 404);
    }
}
