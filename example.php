<?php

require __DIR__ . '/vendor/autoload.php';

use DatoCMS\Client;
use DatoCMS\Exceptions\ApiException;

$client = new Client(getenv('DATOCMS_TOKEN'), [
    'timeout' => 15,
    'max_retries' => 5
]);

try {
    // Get paginated posts
    $result = $client->query('
        query {
            allPosts(first: 10) {
                id
                title
                content
            }
        }
    ');
    
    // Upload file
    $asset = $client->uploadFile('/path/to/image.jpg');
    
    print_r($result);
    
} catch (ApiException $e) {
    die("Error: " . $e->getMessage());
}
