<?php 
require 'vendor/autoload.php';

use DatoCMS\Client;

$client = new Client('33246cac4351504945429041134759'); 

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
