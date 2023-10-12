<?php

declare(strict_types=1);

namespace MiniUrl\Resolver;

use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LinkListResolver implements Resolvable
{
    private ?array $linkList = null;

    public function __construct(private string $jsonLinkListFile) { }

    public function canResolve(Request $request): bool
    {
        return array_key_exists(ltrim($request->getPathInfo(), '/'), $this->getLinkList());
    }

    public function resolve(Request $request): Response
    {
        return new RedirectResponse($this->getLinkList()[ltrim($request->getPathInfo(), '/')]);
    }

    private function getLinkList(): array
    {
        if (is_array($this->linkList)) {
            return $this->linkList;
        }

        if (!file_exists($this->jsonLinkListFile)) {
            throw new Exception('Could not find file.');
        }

        $jsonContent = file_get_contents($this->jsonLinkListFile);
        $this->linkList = json_decode($jsonContent, associative: true, flags: JSON_THROW_ON_ERROR);

        return $this->linkList;
    }
}
