<?php

declare(strict_types=1);

namespace MiniUrl;

use Exception;
use MiniUrl\Resolver\Resolvable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class App
{
    /** @var Resolvable[] $resolvers */
    private function __construct(private array $resolvers)
    {
        foreach ($this->resolvers as $resolver) {
            if (!$resolver instanceof Resolvable) {
                throw new Exception('Given entry in the list is not a valid URL resolver.');
            }
        }
    }

    public static function createFromResolverList(array $resolvers): self
    {
        return new self($resolvers);
    }

    public function run(Request $request): Response
    {
        try {
            foreach ($this->resolvers as $resolver) {
                if (!$resolver->canResolve($request)) {
                    continue;
                }

                return $resolver->resolve($request);
            }

            throw new Exception('No URL resolver found. Specify at least a NotFountResolver.');
        } catch (\Throwable $exception) {
            return new Response(
                sprintf('Internal Server Error. Error: %s', $exception->getMessage()),
                500,
            );
        }
    }
}
