<?php
namespace DatoCMS\Support;

use GuzzleHttp\Psr7\Utils;

class RequestHelper
{
    public static function handleFileUpload($client, string $filePath): array
    {
        $file = Utils::tryFopen($filePath, 'r');
        
        $response = $client->post('/uploads', [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => $file,
                    'filename' => basename($filePath)
                ]
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
