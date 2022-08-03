<?php

declare(strict_types=1);

namespace Webpag\Requests;

use GuzzleHttp\Exception\GuzzleException;
use Webpag\Client;
use Webpag\Entities\Entity;
use Webpag\Entities\Paginator;
use Webpag\Exceptions\ApiException;
use Webpag\Exceptions\UnauthenticatedException;
use Webpag\Exceptions\ValidationException;

abstract class Request
{
    protected Client $client;
    protected Entity $entity;
    /**
     * Itens transformados em Query String na URL.
     * @var array
     */
    protected array $query;

    public function __construct(Client $client, array $query = [])
    {
        $this->client = $client;
        $this->query = $query;
    }

    public abstract function method(): string;

    public abstract function endpoint(): string;

    /**
     * Parse the response body (json) to an Entity object or Paginator object.
     *
     * @param array $data Response body content.
     * @return Entity|Paginator
     */
    protected abstract function parseResponse(array $data);

    protected function setEntity(Entity $entity): self
    {
        $this->entity = $entity;
        return $this;
    }

    public function getQuery(): array
    {
        return $this->query;
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
     * @return Paginator|Entity
     */
    public function send()
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

        return $this->parseResponse($data);
    }
}