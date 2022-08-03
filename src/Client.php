<?php declare(strict_types=1);

namespace Webpag;

use GuzzleHttp\Client as Http;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Webpag\Requests\Request;

class Client
{
    protected string $urlBase = 'https://api.webpag.com.br/api';
    protected string $authToken;
    protected bool $isTesting = false;

    public function __construct(
        ?string $authToken,
        bool $isTesting = false,
        string $urlBaseTesting = 'https://staging.api.webpag.com.br/api'
    ) {
        $this->authToken = $authToken;
        if ($this->isTesting = $isTesting) {
            $this->urlBase = $urlBaseTesting;
        }
    }

    /**
     * @throws GuzzleException
     */
    public function send(Request $request): ResponseInterface
    {
        $http = new Http();
        $options = [
            'headers' => [
                'auth-token' => $this->authToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'http_errors' => false,
            'body' => $request->method() !== 'GET'
                 ? $request->bodyAsJson()
                 : null,
            'query' => $request->getQuery(),
        ];

        return $http->request(
            $request->method(),
            $this->urlBase . $request->endpoint(),
            $options,
        );
    }
}