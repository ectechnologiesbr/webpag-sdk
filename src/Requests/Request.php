<?php

declare(strict_types=1);

namespace Webpag\Requests;

use GuzzleHttp\Exception\GuzzleException;
use Webpag\Client;
use Webpag\Entities\Entity;
use Webpag\Exceptions\ApiException;
use Webpag\Exceptions\UnauthenticatedException;
use Webpag\Exceptions\ValidationException;

abstract class Request
{
    protected Client $client;
    protected Entity $entity;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public abstract function method(): string;

    public abstract function endpoint(): string;

    /**
     * Parse the response body (json) to an Entity object.
     *
     * @param array $data Response body content.
     * @return Entity
     */
    protected abstract function parseResponseToEntity(array $data): Entity;

    protected function setEntity(Entity $entity): self
    {
        $this->entity = $entity;
        return $this;
    }

    public function bodyAsJson(): string
    {
        return json_encode($this->entity);
    }

    /**
     * @throws GuzzleException
     * @throws ValidationException
     * @throws UnauthenticatedException
     * @throws ApiException
     */
    public function send(): Entity
    {
        $response = $this->client->send($this);

        $data = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() === 422) {
            $e = new ValidationException($data['message'] ?? 'Validation errors.', 422);
            $e->setErrors($data['errors'] ?? []);
            throw $e;
        }
        if ($response->getStatusCode() === 401) {
            throw new UnauthenticatedException($data['message'] ?? 'Please check the "auth-token" header.');
        }
        if ($response->getStatusCode() > 201) {
            throw new ApiException($data['message'] ?? 'Server Error.');
        }

        return $this->parseResponseToEntity($data);
    }
}