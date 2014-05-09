<?php

namespace Wk\IcecatApi\Lib;

use Monolog\Logger;
use GuzzleHttp\Stream;
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
        $this->url = $url;
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
        $params = array(
            "ean" => $ean,
            "lang" => $this->language,
        );

        $this->setBaseUrl($this->buildUrlWithHttpAuth());

        $result = $this->executeCommand('FindProductByEan', $params);

        if ("success" == $result['status']) {
            $xml = $result['message']->xml();

            return json_encode($xml);
        }

        return json_encode(array("error" => $result['message']));
    }

    private function buildUrlWithHttpAuth()
    {
        $auth = $this->user.":".$this->password."@";

        return substr_replace($this->url, $auth, strpos($this->url, '://') + 3, 0);
    }

}