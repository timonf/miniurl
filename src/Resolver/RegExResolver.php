<?php

declare(strict_types=1);

namespace MiniUrl\Resolver;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegExResolver implements Resolvable
{
    private ?array $linkList = null;

    public function __construct(private string $regularExpression, private string $redirection) { }

    public function canResolve(Request $request): bool
    {
        $key = ltrim($request->getPathInfo(), '/');
        $matchCounter = preg_match($this->regularExpression, $key);

        return is_int($matchCounter) && $matchCounter > 0;
    }

    public function resolve(Request $request): Response
    {
        $key = ltrim($request->getPathInfo(), '/');
        $url = preg_replace($this->regularExpression, $this->redirection, $key);

        return new RedirectResponse($url);
    }
}
