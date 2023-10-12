<?php

declare(strict_types=1);

namespace MiniUrl\Resolver;

use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SingleLinkResolver implements Resolvable
{
    public function __construct(
        private string $key,
        private string $redirectUrl,
    ) {}

    public function canResolve(Request $request): bool
    {
        return $this->key === ltrim($request->getPathInfo(), '/');
    }

    public function resolve(Request $request): Response
    {
        return new RedirectResponse($this->redirectUrl);
    }
}
