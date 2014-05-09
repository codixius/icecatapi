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
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param string $lang
     */
    public function setLanguage($lang)
    {
        $this->language = $lang;
    }

    /**
     * Method that finds the product description on icecat based on an EAN
     * @param string $ean
     *
     * @return string
     */
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

    /**
     * Method for building the URL with the authentication.
     * Tried it with setDefaultOption but I didn't get it working
     *
     * @return mixed
     */
    private function buildUrlWithHttpAuth()
    {
        $auth = $this->user.":".$this->password."@";

        return substr_replace($this->url, $auth, strpos($this->url, '://') + 3, 0);
    }

}