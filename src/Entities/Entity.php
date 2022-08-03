<?php

declare(strict_types=1);

namespace Webpag\Entities;

use JsonSerializable;

class Entity implements JsonSerializable
{
    protected array $attributes;

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * @param string $attribute
     * @return mixed|null
     */
    public function getAttribute(string $attribute)
    {
        return $this->attributes[$attribute] ?? null;
    }

    public function setAttribute(string $key, $value): self
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    public function jsonSerialize()
    {
        return $this->attributes;
    }

}