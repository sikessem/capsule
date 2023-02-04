<?php

namespace Sikessem\Capsule\Support;

final class Builder
{
    /**
     * @var array<class-string,mixed[]>
     */
    private array $inputs = [];

    /**
     * @var array<class-string,array<object|string>|string|object|callable(mixed ...$args): mixed>
     */
    private array $resolvers = [];

    /**
     * @param  array<class-string,mixed[]>  $inputs
     * @param array<class-string,array<object|string>|string|object|callable(mixed ...$args): mixed> $resolvers
     */
    public function __construct(array $inputs = [], array $resolvers = [])
    {
        $this->setInputs($inputs)->setResolvers($resolvers);
    }

    /**
     * @param  array<class-string,mixed[]>  $inputs
     */
    public function setInputs(array $inputs): static
    {
        $this->inputs = $inputs;

        return $this;
    }

    /**
     * @return array<class-string,mixed[]>
     */
    public function getInputs(): array
    {
        return $this->inputs;
    }

    /**
     * @param array<class-string,array<object|string>|string|object|callable(mixed ...$args): mixed> $resolvers
     */
    public function setResolvers(array $resolvers): static
    {
        $this->resolvers = $resolvers;

        return $this;
    }

    /**
     * @return array<class-string,array<object|string>|string|object|callable(mixed ...$args): mixed>
     */
    public function getResolvers(): array
    {
        return $this->resolvers;
    }
}
