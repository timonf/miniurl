<?php

declare(strict_types=1);

namespace MiniUrl\Resolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface Resolvable
{
    public function canResolve(Request $request): bool;
    public function resolve(Request $request): Response;
}
