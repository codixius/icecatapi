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
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * @param $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @param $url
     */
    public function setUrl($url) {
        $this->user = $url;
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