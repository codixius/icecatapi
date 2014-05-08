<?php

namespace Wk\IcecatApi\Lib;

use Monolog\Logger;
use Wk\GuzzleCommandClient\Lib\GuzzleCommandClient;

/**
 * Class IcecatConnection
 */
class IcecatConnection extends GuzzleCommandClient
{
    protected $logger;

    protected $user;

    protected $password;

    protected $url;

    protected $language;

    /**
     * Constructor of the class
     */
    public function __construct()
    {
        $json = file_get_contents(__DIR__. "/../Resources/config/service.json");
        parent::__construct($json);
    }

    /**
     * @param Logger $logger
     */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param $url
     */
    public function setUrl($url)
    {
        $this->user = $url;
    }

    /**
     * @param $lang
     */
    public function setLanguage($lang)
    {
        $this->language = $lang;
    }

    public function findProductInfoByEan ($ean)
    {
        //https://data.icecat.biz/xml_s3/xml_server3.cgi?ean_upc=4960999358246&lang=de&output=productxml

        $params = array(
            "ean" => $ean,
            "lang" => $this->language,
        );

        $this->setHttpAuth();

        $result = $this->executeCommand('FindProductByEan', $params);

        var_dump($result);
        die();

        if ("success" == $result['status']) {
            return ("Success" == $result['message']['Ack'] && isset($result['message']['Product'])) ? json_encode($result['message']['Product']) : json_encode(array("error" => "Product not found on ebay"));
        }

        return json_encode(array("error" => $result['message']));
    }


    protected function setHttpAuth()
    {
        $this->initClient(array('config' => array('curl' => array(CURLOPT_HTTPAUTH => CURLAUTH_NTLM, CURLOPT_USERPWD => "$this->user:$this->password"))));
    }

    /**
     * $client->get('/', [
    * 'config' => [
    * 'curl' => [
    * CURLOPT_HTTPAUTH => CURLAUTH_NTLM,
    * CURLOPT_USERPWD  => 'username:password'
    * ]
    *]
    * ]);
     */

    //$request->setAuth('michael', 'password', CURLAUTH_DIGEST);
    //$this->assertSame($this->request, $this->request->setAuth('michael', '123'));
    //$this->assertEquals('michael', $this->request->getUsername());
    //$this->assertEquals('123', $this->request->getPassword());


}