<?php declare(strict_types=1);

namespace Webpag\Requests;

use GuzzleHttp\Exception\GuzzleException;
use Webpag\Client;
use Webpag\Entities\Entity;
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

    public function setEntity(Entity $entity): self
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
     */
    public function send()
    {
        $response = $this->client->send($this);
        $bodyResponse = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() === 422) {
            $e = new ValidationException($bodyResponse['message'] ?? 'Validation errors.', 422);
            $e->setErrors($bodyResponse['errors'] ?? []);
            throw $e;
        }

        if ($response->getStatusCode() > 201) {
            // 1. Erros gerais;
        }

        //Parsear a Response Sucessful;

        //Retonar objeto;
    }
}