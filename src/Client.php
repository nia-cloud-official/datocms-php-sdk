<?php
namespace DatoCMS;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use DatoCMS\Exceptions\{
    ApiException,
    AuthException,
    RateLimitException
};
use DatoCMS\Support\RequestHelper;

class Client
{
    private $httpClient;
    private $apiToken;

    public function __construct(string $apiToken)
    {
        $this->apiToken = $apiToken;
        $stack = HandlerStack::create();
        
        $this->httpClient = new GuzzleClient([
            'base_uri' => 'https://graphql.datocms.com/',
            'headers' => [
                'Authorization' => "Bearer {$this->apiToken}",
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'handler' => $stack,
            'timeout' => 15,
        ]);
    }

    public function query(string $query, array $variables = []): array
    {
        try {
        // Cast empty arrays to objects, keep non-empty as-is
        $variablesForJson = empty($variables) ? new \stdClass() : $variables;

        $response = $this->httpClient->post('', [
            'json' => [
                'query' => $query,
                'variables' => $variablesForJson 
            ]
        ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['errors'])) {
                throw new ApiException(
                    'DatoCMS Error: ' . json_encode($data['errors'])
                );
            }

            return $data['data'];

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $status = $e->getResponse()->getStatusCode();
            
            if ($status === 401) {
                throw new AuthException('Invalid API token');
            }
            
            if ($status === 429) {
                throw new RateLimitException('Too many requests');
            }

            throw new ApiException($e->getMessage(), $status);
        }
    }

    public function uploadFile(string $filePath): array
    {
        return RequestHelper::handleFileUpload(
            $this->httpClient,
            $filePath
        );
    }
}
