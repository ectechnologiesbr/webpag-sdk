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
     * @param null $default
     * @return mixed|null
     */
    public function getAttribute(string $attribute, $default = null)
    {
        return $this->attributes[$attribute] ?? $default;
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

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getId(): ?int
    {
        return $this->getAttribute('id');
    }

    public function getCreatedAt(): ?string
    {
        return $this->getAttribute('created_at');
    }

    public function getUpdatedAt(): ?string
    {
        return $this->getAttribute('updated_at');
    }
}