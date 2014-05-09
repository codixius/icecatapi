<?php


namespace Wk\IcecatApi\Tests\Lib;

use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Adapter\MockAdapter;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream;

use Wk\IcecatApi\Lib\IcecatConnection;

/**
 * Class IcecatConnectionTest
 */
class IcecatConnectionTest extends \PHPUnit_Framework_TestCase
{
    private $clientMock;

    /**
     * Test for finding product function
     */
    public function testFindProductInfoByEan()
    {
        $paramRequest = array(
            "ean" => "4960999358246",
            "lang" => "de",
        );

        $jsonString = '{ "Product": { "Category": "304", "Supplier": { "@attributes": { "ID": 10, "Name": "Canon" } } } }';
        $this->_initMockClient($jsonString);

        $icecatConnection = new IcecatConnection();
        $icecatConnection->setClient($this->clientMock);

        $result = $icecatConnection->executeCommand('FindProductByEan', $paramRequest);
        $jsonResult = $result['message']->json();

        $this->assertEquals("success", $result['status']);
        $this->assertArrayHasKey("Product", $jsonResult);
        $this->assertArrayHasKey("Category", $jsonResult['Product']);
        $this->assertEquals("Canon", $jsonResult['Product']['Supplier']['@attributes']['Name']);
    }

    /*
     * Init the mock client
     */
    private function _initMockClient($jsonString)
    {
        $response = new Response(
            200, array(
                'Location' => 'asgoodasnu.test.com',
                'Content-Type' => 'application/json'
            ), Stream\create($jsonString)
        );
        $adapter = new MockAdapter();
        $adapter->setResponse($response);
        $client = new Client(['adapter' => $adapter]);
        $json = file_get_contents(__DIR__ . "/../../Resources/config/service.json");
        $config = json_decode($json, true);
        $description = new Description($config);
        $this->clientMock = new GuzzleClient($client, $description);
    }
}
