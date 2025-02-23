<?php 
require 'vendor/autoload.php';

use DatoCMS\Client;

$client = new Client('DATOCMS_API_KEY'); 

try {
    $result = $client->query('
        query {
            allProducts {
                    title
                    description
                    price
            }
        }
    ', []);

    print_r($result);
    
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
